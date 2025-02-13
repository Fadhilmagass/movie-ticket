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
        try {
            $validated = $request->validate([
                'movie_id' => 'required|exists:movies,id',
                'rating' => 'required|numeric|min:1|max:5',
                'comment' => 'nullable|string|max:500',
            ]);

            // Check if movie exists and is active
            $movie = Movie::findOrFail($validated['movie_id']);

            // Check if user has already reviewed this movie
            $existingReview = Review::where('user_id', Auth::id())
                ->where('movie_id', $validated['movie_id'])
                ->first();

            DB::beginTransaction();
            try {
                Review::updateOrCreate(
                    [
                        'user_id' => Auth::id(),
                        'movie_id' => $validated['movie_id'],
                    ],
                    [
                        'rating' => $validated['rating'],
                        'comment' => $validated['comment'] ?? null,
                    ]
                );

                $this->updateMovieRating($validated['movie_id']);
                DB::commit();

                $message = $existingReview ? 'Review updated successfully!' : 'Review submitted successfully!';

                if ($request->expectsJson()) {
                    return response()->json(['message' => $message], 200);
                }

                return back()->with('success', $message);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => $e->errors()], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Failed to submit review'], 500);
            }
            return back()->with('error', 'Failed to submit review. Please try again.');
        }
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
        try {
            $this->authorize('update', $review);

            $validated = $request->validate([
                'rating' => 'required|numeric|min:1|max:5',
                'comment' => 'nullable|string|max:500',
            ]);

            DB::beginTransaction();
            try {
                $review->update([
                    'rating' => $validated['rating'],
                    'comment' => $validated['comment'] ?? null,
                ]);

                $this->updateMovieRating($review->movie_id);
                DB::commit();

                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Review updated successfully!',
                        'review' => $review->fresh()
                    ]);
                }

                return back()->with('success', 'Review updated successfully!');
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => $e->errors()], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Failed to update review'], 500);
            }
            return back()->with('error', 'Failed to update review. Please try again.');
        }
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
