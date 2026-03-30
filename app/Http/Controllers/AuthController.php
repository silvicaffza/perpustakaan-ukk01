<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user'
        ]);

        return redirect()->route('login');
    }

public function login(Request $request)
{
    if(Auth::attempt($request->only('email','password')))
    {
        $user = Auth::user();

       // dd($user->role); // ✅ TARUH DI SINI

        if($user->role == 'admin'){
            return redirect('/admin/dashboard');
        } elseif($user->role == 'petugas'){
            return redirect('/petugas-home');
        } else {
            return redirect('/user/dashboard');
        }
    } 

    return back()->with('error','Email atau password salah');
}
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}