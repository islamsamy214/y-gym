<?php

namespace App\Http\Controllers\WebControllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{

    use AuthenticatesUsers;
    public function showLoginForm()
    {
        return view('web.auth.login');
    }
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $this->loggedOut($request) ?: redirect('/');
    }


    protected $redirectTo = '/';


    public function __construct()
    {
        $this->middleware('guest:clients')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('clients');
    }
}
