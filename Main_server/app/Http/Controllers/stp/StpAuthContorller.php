<?php

namespace App\Http\Controllers\stp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StpAuthContorller extends Controller
{
    public function login()
    {
        return view('stp.auth.login'); 
    }
    public function doLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->roles_id == 1) {
                return redirect()->route('stp.dashboard');
            } else {
                Auth::logout();
                return redirect()->route('stp.login')->withErrors(['Access denied']);
            }
        }

        return redirect()->route('stp.login')->withErrors(['Invalid credentials']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('stp.login');
    }
}
