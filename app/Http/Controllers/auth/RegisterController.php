<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:13',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:user,seller',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone, // <--- TAMBAHKAN INI
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Akun berhasil dibuat!');
    }
}
