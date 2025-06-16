<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
        }

        Auth::login($user);

        if ($user->role === 'seller') {
            return redirect('/dashboard');
        } elseif ($user->role === 'user') {
            return redirect('/');
        }

        // Fallback jika role tidak sesuai
        Auth::logout();
        return redirect('/login')->withErrors(['role' => 'Role tidak dikenali.']);
    }
}
