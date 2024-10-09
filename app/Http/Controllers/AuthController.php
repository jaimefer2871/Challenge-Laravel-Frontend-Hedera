<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return view('auth.login');
    }

    public function validate(Request $request)
    {
        session(['authenticated' => true]);

        return redirect()->route('hedera_index');
    }
}
