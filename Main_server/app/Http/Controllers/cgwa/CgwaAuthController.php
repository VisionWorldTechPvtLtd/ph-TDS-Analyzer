<?php

namespace App\Http\Controllers\cgwa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CgwaAuthController extends Controller
{
     public function login()
    {
        return view('cgwa.auth.login'); 
    }
    public function doLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->roles_id == 2) {
                return redirect()->route('cgwa.dashboard');
            } else {
                Auth::logout();
                return redirect()->route('cgwa.login')->withErrors(['Access denied']);
            }
        }

        return redirect()->route('cgwa.login')->withErrors(['Invalid credentials']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('cgwa.login');
    } 

}
