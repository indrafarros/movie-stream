<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\MovieRequest;
use App\Http\Controllers\Controller;
use App\Models\Movie;

class MovieController extends Controller
{
    public function index()
    {
        return view('admin.movies');
    }

    public function create()
    {
        return view('admin.movie-create');
    }

    public function store(MovieRequest $request)
    {
        $smallThumbnail = $request->small_thumbnail;
        $largeThumbnail = $request->large_thumbnail;

        $small = Str::random(20) . $smallThumbnail->getClientOriginalName();
        $large = Str::random(20) . $largeThumbnail->getClientOriginalName();

        $smallThumbnail->storeAs('public/thumbnail', $small);
        $largeThumbnail->storeAs('public/thumbnail', $large);

        $request['small_thumbnail'] = $small;
        $request['large_thumbnail'] = $large;
        Movie::create($request->all());

        // return redirect('admin.movie')->with('status', 'Create movie successfully');
        return redirect()->route('admin.movie')->with('status', 'Create movie successfully');
    }
}
