<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\MovieRequest;
use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function index()
    {
        $movie = Movie::all();
        return view('admin.movies', ['movie' => $movie]);
    }

    public function create()
    {
        return view('admin.movie-create');
    }

    public function store(MovieRequest $request)
    {

        $data = $request->all();
        $smallThumbnail = $request->small_thumbnail;
        $largeThumbnail = $request->large_thumbnail;

        $small = Str::random(20) . $smallThumbnail->getClientOriginalName();
        $large = Str::random(20) . $largeThumbnail->getClientOriginalName();

        $smallThumbnail->storeAs('public/thumbnail', $small);
        $largeThumbnail->storeAs('public/thumbnail', $large);

        $data['small_thumbnail'] = $small;
        $data['large_thumbnail'] = $large;
        Movie::create($data);

        // return redirect('admin.movie')->with('status', 'Create movie successfully');
        return redirect()->route('admin.movie')->with('status', 'Create movie successfully');
    }

    public function edit($id)
    {
        $movie = Movie::findOrFail($id);
        return view('admin.movie-edit', ['movie' => $movie]);
    }

    public function update(Request $request, $id)
    {
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
            'featured' => 'required',
        ]);
        $data = $request->all();
        $movie = Movie::findOrFail($id);

        // check image
        if ($request->small_thumbnail) {
            $smallThumbnail = $request->small_thumbnail;
            $small = Str::random(20) . $smallThumbnail->getClientOriginalName();
            $smallThumbnail->storeAs('public/thumbnail', $small);
            $data['small_thumbnail'] = $small;

            Storage::delete('public/thumbnail/' . $movie->small_thumbnail);
        }

        if ($request->large_thumbnail) {
            $largeThumbnail = $request->large_thumbnail;
            $large = Str::random(20) . $largeThumbnail->getClientOriginalName();
            $largeThumbnail->storeAs('public/thumbnail', $large);
            $data['large_thumbnail'] = $large;
            Storage::delete('public/thumbnail/' . $movie->large_thumbnail);
        }

        // end

        $movie->update($data);

        return redirect()->route('admin.movie')->with('status', 'Update movie successfully');
    }

    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);
        $movie->delete();

        if ($movie->small_thumbnail) {
            Storage::delete('public/thumbnail/' . $movie->small_thumbnail);
        }
        if ($movie->large_thumbnail) {
            Storage::delete('public/thumbnail/' . $movie->large_thumbnail);
        }
        return redirect()->route('admin.movie')->with('status', 'Delete movie successfully');
    }
}
