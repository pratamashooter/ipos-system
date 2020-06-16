<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\User;
use App\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileManageController extends Controller
{
    // Open View Profile
    public function viewProfile()
    {
    	$activity = Activity::where('id_user', Auth::id())
    	->latest()
    	->take(3)
    	->get();
    	$activities = Activity::where('id_user', Auth::id())
    	->latest()
    	->get();

    	return view('profile', compact('activity', 'activities'));
    }

    // Change Profile Data
    public function changeData(Request $req){
    	$id = Auth::id();
    	$user_account = User::find($id);
    	$check_email = User::all()
        ->where('email', $req->email)
        ->count();
        $check_username = User::all()
        ->where('username', $req->username)
        ->count();

        if(($check_email == 0 && $check_username == 0) || ($user_account->email == $req->email && $user_account->username == $req->username) || ($check_email == 0 && $user_account->username == $req->username) || ($user_account->email == $req->email && $check_username == 0))
        {
	    	$user_account->nama = $req->nama;
	    	$user_account->email = $req->email;
	    	$user_account->username = $req->username;
	    	$user_account->save();

	    	Session::flash('update_success', 'Profil berhasil diubah');

            return redirect('/profile');
	    }
	    else if($check_email != 0 && $check_username != 0 && $user_account->email != $req->email && $user_account->username != $req->username)
        {
            Session::flash('update_error', 'Email dan username telah digunakan, silakan coba lagi');

            return back();
        }
        else if($check_email != 0 && $user_account->email != $req->email)
        {
            Session::flash('update_error', 'Email telah digunakan, silakan coba lagi');

            return back();
        }
        else if($check_username != 0 && $user_account->username != $req->username)
        {
            Session::flash('update_error', 'Username telah digunakan, silakan coba lagi');

            return back();
        }
    }

    // Change Profile Picture
    public function changePicture(Request $req){
		$user = User::find(Auth::id());
    	$foto = $req->file('foto');
        $user->foto = $foto->getClientOriginalName();
        $foto->move(public_path('pictures/'), $foto->getClientOriginalName());
        $user->save();

        Session::flash('update_success', 'Foto profil berhasil diubah');

        return redirect('/profile');
    }

    // Change Profile Password
    public function changePassword(Request $req)
    {
    	$users = User::find(Auth::id());
        if(Hash::check($req->old_password, $users->password)){
            User::where('id', '=', Auth::id())
            ->update(['password' => Hash::make($req->new_password)]);
            
            Session::flash('update_success', 'Password berhasil diubah');

            return redirect('/profile');

        }else{
            Session::flash('update_error', 'Password lama tidak sesuai');

            return back();
        }
    }
}