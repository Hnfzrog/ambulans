<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function login(Request $request) {
        $input = $request->all();

        $this -> validate($request, [
            'email' => 'required | email',
            'password' => 'required'
        ]);
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'superadmin') {
            return redirect()->route('superadmin.dashboard');
        }

        // Default redirection for other roles
        return redirect('/home');
    }
}


