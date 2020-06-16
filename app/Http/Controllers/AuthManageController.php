<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\User;
use Illuminate\Http\Request;

class AuthManageController extends Controller
{
    // Show View Login
    public function viewLogin()
    {
    	$users = User::all()
    	->count();

    	return view('login', compact('users'));
    }

    // Verify Login
    public function verifyLogin(Request $request)
    {
    	if(Auth::attempt($request->only('username', 'password'))){
    		return redirect('/dashboard');
    	}
    	Session::flash('login_failed', 'Username atau password salah');
    	
    	return redirect('/login');
    }

    // Logout Process
    public function logoutProcess()
    {
    	Auth::logout();

    	return redirect('/login');
    }
}