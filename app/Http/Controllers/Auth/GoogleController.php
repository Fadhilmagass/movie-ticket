<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // public function handleGoogleCallback()
    // {
    //     try {
    //         $googleUser = Socialite::driver('google')->user();
    //         $user = User::where('email', $googleUser->getEmail())->first();

    //         if (!$user) {
    //             $user = User::create([
    //                 'name' => $googleUser->getName(),
    //                 'email' => $googleUser->getEmail(),
    //                 'google_id' => $googleUser->getId(),
    //                 'password' => bcrypt(Str::random(24)),
    //                 'email_verified_at' => now(),
    //             ]);
    //         }

    //         $user->update([
    //             'google_id' => $googleUser->getId(),
    //             'google_token' => $googleUser->token,
    //         ]);

    //         FacadesAuth::login($user);

    //         return redirect()->intended('/dashboard');
    //     } catch (\Exception $e) {
    //         FacadesLog::error('Google Auth Error: ' . $e->getMessage());
    //         return redirect()->route('login')->withErrors([
    //             'email' => 'Google authentication failed. Please try again.',
    //         ]);
    //     }
    // }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $findUser = User::where('email', $user->getEmail())->first();

            if ($findUser) {
                Auth::login($findUser);
                return redirect()->intended('dashboard');
            } else {
                $newUser = User::create([
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'google_id' => $user->getId(),
                    'google_token' => $user->token,
                    'password' => encrypt('my-google')
                ]);

                Auth::login($newUser);
                return redirect()->intended('dashboard');
            }
        } catch (Exception $e) {
            return redirect('login')->with('error', 'Google login failed!');
        }
    }
}
