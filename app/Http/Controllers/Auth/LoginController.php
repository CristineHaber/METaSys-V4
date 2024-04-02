<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function logout()
    {
        $this->guard()->logout();

        return redirect('/login')->with('message', 'You have been Logout!');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    public function authenticated(Request $request, $user)
    {
        $usertype = $user->usertype;

        switch ($usertype) {
            case 'admin':
                return redirect()->route('admin.index')->with('message', 'Welcome, ' . $user->first_name . ' ' . $user->last_name . '!');
            case 'judge':
                return redirect()->route('judge.index')->with('message', 'Welcome, ' . $user->first_name . ' ' . $user->last_name . '!');
            default:
                abort(403, 'Unauthorized role.');
        }        
    }
}
