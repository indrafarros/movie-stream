<?php

namespace App\Http\Controllers\Member;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('member.register');
    }

    public function store(RegisterRequest $request)
    {

        $request['role'] = "member";
        $request['password'] = Hash::make($request->password);
        User::create($request->all());
        return redirect('/');
    }
}
