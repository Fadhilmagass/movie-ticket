<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $movies = Movie::query()
            ->when($request->search, function ($query) use ($request) {
                $search = $request->search;
                return $query->where('title', 'like', "%$search%")
                    ->orWhere('genre', 'like', "%$search%");
            })
            ->when($request->status, function ($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->orderBy('release_date', 'desc')
            ->paginate(12);

        return view('movies.index', compact('movies'));
    }

    public function show($slug)
    {
        $movie =  Movie::where('slug', $slug)->firstOrFail();
        $movie->load(['reviews.user']);
        return view('movies.show', compact('movie'));
    }
}
