<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        return view('dashboard', [
            'totalMovies' => Movie::count(),
            'totalUsers' => User::count(),
            'totalReviews' => Review::count(),
            'latestMovies' => Movie::latest()->take(5)->get(),
        ]);
    }
}
