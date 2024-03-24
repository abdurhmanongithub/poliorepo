<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;


class LoginController extends Controller
{
    //
    function loginView(Request $request)
    {
        return view('auth.login');
    }
    function store(Request $request)
    {

        $credential = $request->only('email', 'password');
        // dd($credential);
        if (!Auth::attempt($credential, )) {
            throw ValidationException::withMessages([
                'email' => 'Incorrect Email or password',
            ]);
        }
        $request->session()->regenerate();
        // dd(auth()->user());
        return redirect()->intended(RouteServiceProvider::HOME);


    }
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

}
