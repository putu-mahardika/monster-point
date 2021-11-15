<?php

namespace App\Actions\Fortify;

use App\Models\Merchant;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Fortify;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        // dd($input);
        Validator::make($input, [
            'merchant_name' => ['required', 'string', 'max:150'],
            'merchant_email' => ['required', 'string', 'email:rfc,dns', 'max:150', 'unique:users,email'],
            'merchant_address' => ['required', 'string', 'max:150'],
            'merchant_pic' => ['required', 'string', 'max:150'],
            'merchant_pic_phone' => ['required', 'string', 'max:150'],
            'use_for' => ['required', 'string', 'max:250'],
            // 'password' => $this->passwordRules(),
        ])->validate();

        $password = Hash::make(config('app.default_password', '12345678'));

        Merchant::create([
            'Nama' => $input['merchant_name'],
            'Email' => $input['merchant_email'],
            'Alamat' => $input['merchant_address'],
            'Pic' => $input['merchant_pic'],
            'PicTelp' => $input['merchant_pic_phone'],
            'Kebutuhan' => $input['use_for'],
            'Token' => Str::random(25),
            'Pass' => $password
        ]);

        return User::create([
            'name' => $input['merchant_pic'],
            'email' => $input['merchant_email'],
            // 'password' => Hash::make($input['password']),
            'password' => $password,
        ]);
    }
}
