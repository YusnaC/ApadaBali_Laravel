<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        // Auth::
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }
}
