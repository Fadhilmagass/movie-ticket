<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    use AuthorizesRequests;

    /**
     * Store or update a review.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500'
        ]);

        $review = Review::updateOrCreate(
            ['user_id' => Auth::id(), 'movie_id' => $validated['movie_id']],
            $validated
        );

        $this->updateMovieRating($validated['movie_id']);

        return response()->json(['success' => true]);
    }

    /**
     * Update a review.
     *
     * @param Request $request
     * @param Review $review
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Review $review)
    {
        $this->authorize('update', $review);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500'
        ]);

        $review->update($validated);
        $this->updateMovieRating($review->movie_id);

        return response()->json(['success' => true]);
    }

    /**
     * Delete a review.
     *
     * @param Review $review
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Review $review)
    {
        try {
            $this->authorize('delete', $review);

            DB::beginTransaction();
            try {
                $movieId = $review->movie_id;
                $review->delete();

                $this->updateMovieRating($movieId);
                DB::commit();

                if (request()->expectsJson()) {
                    return response()->json(['message' => 'Review deleted successfully!']);
                }

                return back()->with('success', 'Review deleted successfully!');
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['error' => 'Failed to delete review'], 500);
            }
            return back()->with('error', 'Failed to delete review. Please try again.');
        }
    }

    /**
     * Update movie's average rating.
     *
     * @param int $movieId
     * @return void
     */
    private function updateMovieRating($movieId)
    {
        try {
            $avgRating = Review::where('movie_id', $movieId)
                ->whereNotNull('rating')
                ->avg('rating');

            // If there are no reviews, set rating to 0
            $avgRating = $avgRating ?? 0;

            Movie::where('id', $movieId)->update([
                'rating' => round($avgRating, 1)
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update movie rating: ' . $e->getMessage(), [
                'movie_id' => $movieId,
                'error' => $e
            ]);
            throw $e;
        }
    }
}
