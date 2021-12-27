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
        $merchant = $user->merchant;
        $userData = [];
        $merchantData = [];

        $request->validate([
            'merchant_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:150', 'unique:users,email,'.$id],
            'merchant_address' => ['required', 'string', 'max:150'],
            'pic' => ['required', 'string', 'max:150'],
            'pic_phone' => ['required', 'string', 'max:150'],
            'use_for' => ['required', 'string', 'max:250'],
            'old_password' => [Rule::requiredIf(!empty($request->new_password)), new ValidPassword($user)],
            'new_password' => ['nullable', 'min:8', 'confirmed'],
        ]);

        $password = !empty($request->new_password) ? Hash::make($request->new_password) : null;

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
