<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MovieController extends Controller
{
    public function index()
    {
        $movies  = Movie::all();
        return view('admin.movies', compact('movies'));
    }

    public function create()
    {
        return view('admin.movie-create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $request->validate([
            'title' => 'required|string',
            'small_thumbnail' => 'required|image|mimes:jpeg,jpg,png',
            'large_thumbnail' => 'required|image|mimes:jpeg,jpg,png',
            'trailer' => 'required|url',
            'movie' => 'required|url',
            'casts' => 'required|string',
            'categories' => 'required|string',
            'release_date' => 'required|string',
            'about' => 'required|string',
            'short_about' => 'required|string',
            'duration' => 'required|string',
            'featured' => 'required'
        ]);

        $data['small_thumbnail'] = Storage::disk('public')->put('thumbnail', $request->file('small_thumbnail'));
        $data['large_thumbnail'] = Storage::disk('public')->put('thumbnail', $request->file('large_thumbnail'));

        Movie::create($data);

        return redirect()->route('admin.movie.index')->with('success', 'Movie created');
    }

    public function edit(Movie $movie)
    {
        return view('admin.movie-edit', compact('movie'));
    }

    public function update(Movie $movie, Request $request)
    {
        $data = $request->all();
        $request->validate([
            'title' => 'required|string',
            'small_thumbnail' => 'image|mimes:jpeg,jpg,png',
            'large_thumbnail' => 'image|mimes:jpeg,jpg,png',
            'trailer' => 'required|url',
            'movie' => 'required|url',
            'casts' => 'required|string',
            'categories' => 'required|string',
            'release_date' => 'required|string',
            'about' => 'required|string',
            'short_about' => 'required|string',
            'duration' => 'required|string',
            'featured' => 'required'
        ]);

        if ($request->small_thumbnail) {
            $data['small_thumbnail'] = Storage::disk('public')->put('thumbnail', $request->file('small_thumbnail'));

            Storage::delete('public/' . $movie->small_thumbnail);
        }

        if ($request->large_thumbnail) {
            $data['large_thumbnail'] = Storage::disk('public')->put('thumbnail', $request->file('large_thumbnail'));
            Storage::delete('public/' . $movie->large_thumbnail);
        }

        $movie->update($data);

        return redirect()->route('admin.movie.index')->with('success', 'Movie Updated');
    }

    public function destroy(Movie $movie)
    {
        Storage::delete('public/' . $movie->small_thumbnail);
        Storage::delete('public/' . $movie->large_thumbnail);
        
        $movie->delete();

        return redirect()->route('admin.movie.index')->with('success', 'Movie Deleted');
    }
}
