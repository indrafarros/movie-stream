<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\UserPremium;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    public function watch($id)
    {
        $user = Auth::user()->id;
        $userPremium = UserPremium::where('user_id', $user)->first();

        if ($userPremium) {
            $endOfSubscription = $userPremium->end_of_subscription;
            $date = Carbon::createFromFormat('Y-m-d', $endOfSubscription);
            $isValid = $date->greaterThan(now());

            if ($isValid) {
                $movie = Movie::findOrFail($id);
                return view('member.movie-watching', ['movie' => $movie]);
            }
        }

        return redirect()->route('pricing');
    }
    public function show($id)
    {
        $movie = Movie::findOrFail($id);

        return view('member.movie-detail', ['movie' => $movie]);
    }
}
