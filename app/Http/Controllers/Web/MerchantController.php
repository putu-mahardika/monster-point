<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $merchants = Merchant::orderBy('id', 'DESC')->get();
            return response()->json($merchants);
        }
        return view('pages.merchant.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.merchant.editor');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'merchant_name' => ['required', 'string', 'max:100'],
            'merchant_address' => ['required', 'string', 'max:150'],
            'merchant_pic' => ['required', 'string', 'max:50', 'regex:/^[\pL\s\-]+$/u'],
            'merchant_pic_phone' => ['required', 'string', 'max:15'],
            'merchant_pic_email' => ['required', 'string', 'email:rfc,dns', 'max:150', 'unique:Merchant,Email'],
            'use_for' => ['required', 'string', 'max:250'],
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), Response::HTTP_BAD_REQUEST);
        } else {
            Merchant::create([
                'CreateDate' => now(),
                'Token' => Str::random(25),
                'Nama' => $request->merchant_name,
                'Alamat' => $request->merchant_address,
                'Pic' => $request->merchant_pic,
                'PicTelp' => $request->merchant_pic_phone,
                'Email' => $request->merchant_pic_email,
                'Pass' => 'password',
                'Kebutuhan' => $request->use_for,
                'LastUpdate' => now(),
                'Akif' => 1,
                'Validasi' => 1
            ]);

            $password = Hash::make(config('app.default_password', '12345678'));

            User::create([
                'name' => $request->merchant_name,
                'email' => $request->merchant_pic_email,
                // 'password' => Hash::make($input['password']),
                'password' => $password,
            ])->assignRole('merchant');
        }
        return response(['msg' => 'The Merchant has been created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Merchant $merchant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Merchant $merchant)
    {
        // dd($merchant);
        return view('pages.merchant.editor', compact('merchant'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Merchant $merchant)
    {
        $validator = Validator::make($request->all(), [
            'merchant_name' => ['required', 'string', 'max:100'],
            'merchant_address' => ['required', 'string', 'max:150'],
            'merchant_pic' => ['required', 'regex:/^[\pL\s\-]+$/u', 'string', 'max:50'],
            'merchant_pic_phone' => ['required', 'string', 'max:13'],
            'merchant_pic_email' => ['required', 'string', 'email:rfc,dns', 'max:150', 'unique:Merchant,Email'],
            'use_for' => ['required', 'string', 'max:250'],
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), Response::HTTP_BAD_REQUEST);
        } else {
            $query = Merchant::where('id', $merchant->Id)->update([
                'Nama' => $request->merchant_name,
                'Alamat' => $request->merchant_address,
                'Pic' => $request->merchant_pic,
                'PicTelp' => $request->merchant_pic_phone,
                'Email' => $request->merchant_pic_email,
                'Kebutuhan' => $request->use_for,
            ]);
        }

        if ($query) {
            return response()->json(['code' => 1, 'msg' => 'Merchant Has Been Updated']);
        } else {
            return response()->json(['code' => 0, 'msg' => 'Something went wrong']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Merchant $merchant)
    {
        // dd($merchant);
        $query = $merchant->delete();
        if ($query) {
            return response()->json(['code' => 1, 'message' => 'Merchant Has Been Deleted From Databases']);
        } else {
            return response()->json(['code' => 0, 'message' => 'Something went wrong']);
        }
    }

    public function dx(Request $request)
    {
        $merchants = Merchant::all();
        return response()->json($merchants);
    }
}
