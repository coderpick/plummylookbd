<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

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
    protected $redirectTo;

    protected function authenticated($request, $user)
    {
        if ($user->type === 'user') {
            $this->redirectTo = route('home');
        }else{
            $this->redirectTo = route('dashboard');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }



    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $fbUser = Socialite::driver('facebook')->user();

        //return $fbUser->email;

        $findUser = User::where('email', $fbUser->email)->first();

        if ($findUser){
            Auth::login($findUser);
            session()->flash('success', 'Successfully logged in');
            return redirect()->route('home');
        }
        else{

            $user = new User;
            $user->name = $fbUser->name;
            $slug = Str::slug($fbUser->name, '-').'-'.rand(000,999);
            $user->slug = $slug;
            $user->email = $fbUser->email;
            $user->password = bcrypt('pass123456');
            $user->email_verified_at = Carbon::now();
            $user->save();

            Auth::login($user);
            session()->flash('success', 'Successfully logged in');
            return redirect()->route('home');
        }

    }
}
