<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles; // Pastikan trait ini ada di Model User
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReviewController extends Controller
{
    use AuthorizesRequests;

    /**
    /**
     * Store or update a review.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        Review::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'movie_id' => $validated['movie_id'],
            ],
            [
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
            ]
        );

        $this->updateMovieRating($validated['movie_id']);

        return back()->with('success', 'Review submitted successfully!');
    }

    /**
     * Update a review.
     */
    public function update(Request $request, Review $review)
    {
        $this->authorize('update', $review);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        $review->update($validated);
        $this->updateMovieRating($review->movie_id);

        return back()->with('success', 'Review updated successfully!');
    }

    /**
     * Delete a review.
     */
    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);

        $movieId = $review->movie_id;
        $review->delete();

        $this->updateMovieRating($movieId);

        return back()->with('success', 'Review deleted successfully!');
    }

    /**
     * Update movie's average rating.
     */
    private function updateMovieRating($movieId)
    {
        $avgRating = Review::where('movie_id', $movieId)->avg('rating');
        Movie::where('id', $movieId)->update(['rating' => (float)number_format($avgRating, 1)]);
    }
}
