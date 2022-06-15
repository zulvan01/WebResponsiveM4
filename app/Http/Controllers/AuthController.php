<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class AuthController extends Controller
{
    public function register()
    {
        return view('register');
    }

    public function simpanuser(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required'
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return view('login')->with('pesan', 'Account has been created');
    }

    public function login()
    {
        return view('login');
    }

    public function ceklogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $auth = Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        if($auth) {
            return redirect('/home');
        }else{
            return view('login')->with('pesan', 'Email or password incorrect');
        }
    }

    public function home()
    {
        return 'Selamat datang ' . '<a href="/logout">Logout</a>';
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
