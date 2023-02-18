<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserPremium;
use Illuminate\Support\Facades\Auth;

class UserPremiumController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $userPremium = UserPremium::with('package')->where('user_id', $userId)->first();

        if (!$userPremium) {
            return redirect()->route('pricing');
        }

        return view('member.subscription', ['user_subscription' => $userPremium]);
    }

    public function destroy($id)
    {
        UserPremium::destroy($id);

        return redirect()->route('member.dashboard');
    }
}
