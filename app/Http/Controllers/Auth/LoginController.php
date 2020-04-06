<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    /**
     * 
     */
    public function login(Request $request)
    {
        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];

        $user = User::where('username', $credentials['username'])->where('status', 1);
        
        if(!$user->exists()) {
            Session::flash('user.notfound', 'Пользователь не найден.');

            return redirect()->route('login')->withInput([
                'username' => $request->username
            ]);
        }   

        if (Auth::attempt($credentials)) {  
            return redirect()->route('home');
        }
        
        return redirect()->route('login')->withInput([
            'username' => $request->username
        ])->withErrors([
            'password' => 'Неверный пароль.'
        ]);
    }
}
