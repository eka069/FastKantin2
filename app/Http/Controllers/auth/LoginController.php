<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $name = trim($request->input('name'));
        $password = $request->input('password');
        $role = $request->input('role');

        if (empty($name) || empty($password)) {
            return back()->withInput()->with('error', 'Nama dan password harus diisi');
        }

        // Cek ke database (ganti dengan model sebaiknya)
        $user = DB::table('users')
            ->where('name', $name)
            ->where('role', $role)
            ->first();

        if (!$user || !password_verify($password, $user->password)) {
            return back()->withInput()->with('error', 'Email atau password salah');
        }

        if ($user->role === 'seller') {
            return redirect()->route('seller.index');
        } else {
            return redirect()->route('Order');
        }

        if (Session::get('user.role') !== 'seller') {
            abort(403, 'Unauthorized');
        }

        // Simpan ke session
        Session::put('user',
        [
            'id' => $user->id,
            'name' => $user->name,
            'role' => $user->role
        ]);

        return redirect()->route('profile');
    }
}
