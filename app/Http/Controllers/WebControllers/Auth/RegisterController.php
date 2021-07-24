<?php

namespace App\Http\Controllers\WebControllers\Auth;

use App\Models\Client;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{

    use RegistersUsers;
    public function showRegistrationForm()
    {
        return view('web.auth.register');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    protected $redirectTo = '/';


    public function __construct()
    {
        $this->middleware('guest:clients');
    }

    protected function guard()
    {
        return Auth::guard('clients');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required',
            'email'=>'required|unique:users|unique:clients|email',
            'password'=>'required|confirmed',
        ]);
    }


    protected function create(array $data)
    {
        return Client::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
