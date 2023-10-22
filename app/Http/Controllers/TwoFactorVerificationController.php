<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class TwoFactorVerificationController extends Controller
{
    public function show()
    {
        return view('auth.2fa-verify'); 
    }


    public function verify(Request $request)
    {
        
        if ($request->user()->twoFactorChallengePassed($request->input('2fa_code'))) {
            
            return redirect()->intended(route('home'));
        }

        
        return back()->withErrors(['2fa_code' => 'Invalid 2FA code.']);
    }
}
