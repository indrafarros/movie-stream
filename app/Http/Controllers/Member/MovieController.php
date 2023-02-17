<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function show($id)
    {
        $movie = Movie::findOrFail($id);

        return view('member.movie-detail', ['movie' => $movie]);
    }
}
