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
    }

    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login request
    // Handle login request
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $input = $request->only('email', 'password');

        if (auth()->attempt($input)) {
            $user = auth()->user(); // Get the authenticated user
            
            return $this->authenticated($request, $user);
        }
        
        return redirect()->back()->withErrors(['email' => 'Invalid credentials.'])->withInput($request->only('email', 'remember'));
    }
    
    
    protected function authenticated(Request $request, $user)
    {
        // Define a mapping of roles to routes
        $roleRedirects = [
            'admin' => 'admin.dashboard',
            'superadmin' => 'superadmin.dashboard',
        ];

        if (array_key_exists($user->role, $roleRedirects)) {
            return redirect()->route($roleRedirects[$user->role]);
        }

        return redirect('/');
    }


}
