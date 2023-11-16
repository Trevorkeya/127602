<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Notifications\TwoFactorCodeNotification;
use Illuminate\Support\Facades\Auth;
use App\Helpers\TwoFactorHelper;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
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
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
 
    public function generateTwoFactorCode()
    {
        return rand(1000, 9999);
    }
    
    public function login(Request $request)
   {
    $input = $request->all();

    $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (auth()->attempt(array('email' => $input['email'], 'password' => $input['password']))) {
        $user = auth()->user();

        if ($user->type == 'admin') {
            return redirect()->route('instructor.home'); 
        } else if ($user->type == 'instructor') {
            return redirect()->route('instructor.home');
        } else {
            
            $code = $this->generateTwoFactorCode();

            // Store the code in the user's session or database for later verification
            $user->two_factor_code = $code;
            $user->save();
            
            // Send the 2FA code notification and redirect to the 2FA verification page
            $user->notify(new TwoFactorCodeNotification($code));
            
            return redirect()->route('2fa.verify');
        }
    } else {
        return redirect()->route('login')
            ->with('error', 'Email-Address And Password Are Wrong.');
    }
  }

}
