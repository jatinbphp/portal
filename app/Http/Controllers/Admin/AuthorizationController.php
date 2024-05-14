<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorizationController extends Controller
{
    public function adminLoginForm(){
        if(Auth::check()){
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.auth.admin_login', ['url' => route('admin.login'), 'title' => 'Admin']);
    }

    public function adminLogin(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => ['companies', 'super_admin', 'controllers']])) {
            $user = Auth::user();
            return redirect()->route('admin.dashboard');
        } else {
            \Session::flash('danger', 'Invalid Credentials!');
            return redirect()->route('admin.login');
        }
    }

    public function adminLogout(){
        Auth::logout();
        return redirect('admin');
    }
}
