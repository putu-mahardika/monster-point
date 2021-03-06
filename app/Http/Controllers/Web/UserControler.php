<?php

namespace App\Http\Controllers\Web;

use App\Helpers\EmailChangeHelper;
use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\User;
use App\Rules\NullablePasswordMin;
use App\Rules\ValidPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserControler extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $role = $user->roles->first()->id;
        // dd($user->hasMerchant);
        $merchant = $user->hasMerchant ?? null;
        $userData = [];
        $merchantData = [];

        $request->validate([
            'merchant_name' => [Rule::requiredIf(!empty($request->merchant_name)), 'string', 'max:100'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:150', 'unique:users,email,'.$id],
            'merchant_address' => [Rule::requiredIf(!empty($request->merchant_address)), 'string', 'max:150'],
            'pic' => [Rule::requiredIf(!empty($request->pic)), 'string', 'max:50'],
            'pic_phone' => [Rule::requiredIf(!empty($request->pic_phone)), 'string', 'max:13'],
            'use_for' => [Rule::requiredIf(!empty($request->use_for)), 'string', 'max:100'],
            'old_password' => [Rule::requiredIf(!empty($request->new_password)), new ValidPassword($user)],
            'new_password' => ['nullable', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'new_password_confirmation' => ['nullable', 'min:8', 'same:new_password'],
        ]);

        $password = !empty($request->new_password) ? Hash::make($request->new_password) : null;

        if($role != 1){
            $merchantData = [
                'Nama' => $request->merchant_name,
                'Alamat' => $request->merchant_address,
                'Pic' => $request->pic,
                'PicTelp' => $request->pic_phone,
                'Kebutuhan' => $request->use_for,
            ];

            $userData['name'] = $request->merchant_name;

            if (!empty($password)) {
                $merchantData['Pass']  = $password;
                $userData['password'] = $password;
            }

            $user->update($userData);
            $merchant->update($merchantData);
        } else {
            if(!empty($password)) {
                $userData['password'] = $password;
            }
            $user->update($userData);
        }

        if ($user->email !== $request->email) {
            EmailChangeHelper::create($user, $request->email);
            return redirect()->route('profile.index')
                         ->with('status', "Profile saved. Please check inbox or spam at $request->email for validate your email change.");
        }

        return redirect()->route('profile.index')
                         ->with('status', 'The profile has been updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
