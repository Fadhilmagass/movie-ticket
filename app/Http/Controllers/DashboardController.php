<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $totalMovies = Movie::count();
        $totalUsers = User::count();
        $totalReviews = Review::count();
        $latestMovies = Movie::orderBy('release_date', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('totalMovies', 'totalUsers', 'totalReviews', 'latestMovies'));
    }
}
