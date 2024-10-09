<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function register(Request $request)
    {
        return view('users.register');
    }
}
