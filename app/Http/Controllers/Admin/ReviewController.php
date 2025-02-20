<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Menghapus review (Admin Only)
     */
    public function destroy(Review $review)
    {
        try {
            $movieId = $review->movie_id;
            $review->delete();

            $this->updateMovieRating($movieId);

            return back()->with('success', 'Review berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus review.');
        }
    }

    /**
     * Update rating movie
     */
    private function updateMovieRating($movieId)
    {
        $avgRating = Review::where('movie_id', $movieId)->avg('rating');
        Movie::where('id', $movieId)->update([
            'rating' => number_format((float)$avgRating, 1)
        ]);
    }
}
