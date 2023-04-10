<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function prosesLogin(Request $request){
        if(Auth::guard('karyawan')->attempt(['nik'=> $request->nik,'password' => $request->password])) {
            return redirect()->route('dashboard');
        }else {
            return redirect('/')->with(['warning' => 'NIK / Password Salah']);
        }
    }

    public function prosesLogout(){
        if(Auth::guard('karyawan')->check()){
            Auth::guard('karyawan')->logout();
            return redirect()->route('halamanLogin');
        }
      
    }
    public function prosesLogoutAdmin() {
        if(Auth::guard('user')->check()){
            Auth::guard('user')->logout();
            return redirect('/panel');
        }
    }
    public function prosesLoginAdmin(Request $request){
        if(Auth::guard('user')->attempt(['email'=> $request->email,'password' => $request->password])) {
            return redirect()->route('dashboardadmin');
        }else {
            return redirect('/panel')->with(['warning' => 'Username / Password Salah']);
        }
    }

}
