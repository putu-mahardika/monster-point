<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\SocialAccount;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallBack($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            return redirect('/login');
        }

        $authUser = $this->findOrCreateUser($user, $provider);

        Auth::login($authUser, true);

        return redirect('/dashboard');
    }

    public function findOrCreateUser($socialUser, $provider)
    {
        $socialAccount = SocialAccount::where('provider_id', $socialUser->getId())
                        ->where('provider_name', $provider)
                        ->first();

        if($socialAccount)
        {
            return $socialAccount->user;
        } else {
            $user = User::where('email', $socialUser->getEmail())->first();

            if(! $user)
            {
                Merchant::create([
                    'CreateDate' => now(),
                    'Token' => Str::random(25),
                    'Nama' => '',
                    'Alamat' => '',
                    'Pic' => $socialUser->getName(),
                    'PicTelp' => '',
                    'Email' => $socialUser->getEmail(),
                    'Pass' => 'password',
                    'Kebutuhan' => '',
                    'LastUpdate' => now(),
                    'Akif' => 1,
                    'Validasi' => 1
                ]);

                $password = Hash::make(config('app.default_password', '12345678'));

                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'password' => $password
                ])->assignRole('merchant');
            }

            $user->socialAccounts()->create([
                'provider_id' => $socialUser->getId(),
                'provider_name' => $provider,
            ]);

            return $user;
        }

    }
}
