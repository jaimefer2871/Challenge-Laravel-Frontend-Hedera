<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HederaController extends Controller
{
    public function dashboard(Request $request)
    {
        $request->session(['authenticated' => true]);
        
        return view('hedera.dashboard');
    }
}
