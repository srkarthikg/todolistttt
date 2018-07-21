<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Auth;
use App\User;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
	
	public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (Exception $e) {
            return redirect('auth/google');
        }   
		$authUser = $this->createUser($user);
		Auth::login($authUser, true);
		return redirect()->route('home');        
    }

    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
        } catch (Exception $e) {
            return redirect('auth/facebook');
        }
        $authUser = $this->createFBUser($user);
        Auth::login($authUser, true);
        return redirect()->route('home'); 
    }
	
	public function createUser($user)
    {
        $authUser = User::where('google_id', $user->id)->first();
		if($authUser){
			return $authUser;
		}
		return User::create([
            'name' => $user->name,
            'email' => $user->email,
            'google_id' => $user->id,
        ]);
    }

    public function createFBUser($user)
    {
        $authUser = User::where('facebook_id', $user->id)->first();
		if($authUser){
			return $authUser;
		}
		return User::create([
            'name' => $user->name,
            'email' => $user->email,
            'facebook_id' => $user->id,
        ]);
    }
}
