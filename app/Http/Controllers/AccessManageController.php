<?php

namespace App\Http\Controllers;

use App\Acces;
use Illuminate\Http\Request;

class AccessManageController extends Controller
{
    // Show View Access
    public function viewAccess()
    {
    	$access = Acces::join('users', 'users.id', '=', 'access.user')
    	->select('access.*', 'users.*')
    	->get();

    	return view('manage_account.access', compact('access'));
    }

    // Change Access
    public function changeAccess($user, $access)
    {
    	$pengguna = Acces::where('user', $user)
    	->select($access)
    	->first();
    	if($pengguna->$access == 1){
    		Acces::where('user', $user)
            ->update([$access => 0]);
    	}else{
    		Acces::where('user', $user)
            ->update([$access => 1]);
    	}
    	$access = Acces::join('users', 'users.id', '=', 'access.user')
    	->select('access.*', 'users.*')
    	->get();
    	return view('manage_account.access_table', compact('access'));
    }

    // Check Access
    public function checkAccess($user)
    {
    	$check = Acces::where('user', $user)
    	->select('kelola_akun')
    	->first();
    	if($check->kelola_akun == 1)
    		echo "benar";
    	else
    		echo "salah";
    }

    // Sidebar Refresh
    public function sidebarRefresh()
    {
    	return view('templates.sidebar');
    }
}