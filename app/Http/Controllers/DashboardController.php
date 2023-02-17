<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $movie = Movie::orderBy('featured', 'DESC')->orderBy('created_at', 'DESC')->get();
        return view('member.dashboard', ['movie' => $movie]);
    }
}
