<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function getUserRole()
    {
        $user = auth()->user();
        return response()->json(['name' => $user->name]);
    }

    public function getAuthenticatedUser()
    {
        $user = auth()->user();
        return response()->json($user);
    }


    public function getRoleUser()
    {
        $userAutenticado = auth()->user();
        $user = (object) [
            'id' => $userAutenticado->id,
            'role' => $userAutenticado->roles[0]->name
        ];

        return response()->json($user);
    }


    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

}
