<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function index()
    {
        $package = Package::all();
        return view('member.pricing', ['package' => $package]);
    }
}
