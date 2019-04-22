<?php

namespace App\Http\Controllers\Cpanel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class AdminAuthController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = cp;
    protected $guard = 'admin';
    protected function guard()
    {
        return Auth::guard('admin');
    }
    public function showLoginForm()
    {
        return view('cpanel.auth.login');
    }

    public function logout(Request $request)
    {
        $this->guard('admin')->logout();
        return redirect(cp.'login');
    }

}
