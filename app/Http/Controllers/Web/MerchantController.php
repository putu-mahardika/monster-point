<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Response;

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
            'merchant_name' => ['required'],
            'merchant_address' => ['required'],
            'merchant_pic' => ['required'],
            'merchant_pic_phone' => ['required'],
            'merchant_pic_email' => ['required'],
            'use_for' => ['required'],
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
                'Pass' => '123',
                'Kebutuhan' => $request->use_for,
                'LastUpdate' => now(),
                'Akif' => 1,
                'Validasi' => 1
            ]);
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
            'merchant_name' => ['required'],
            'merchant_address' => ['required'],
            'merchant_pic' => ['required'],
            'merchant_pic_phone' => ['required'],
            'merchant_pic_email' => ['required'],
            'use_for' => ['required'],
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), Response::HTTP_BAD_REQUEST);
        } else {
            Merchant::where('id', $merchant->Id)->update([
                'Nama' => $request->merchant_name,
                'Alamat' => $request->merchant_address,
                'Pic' => $request->merchant_pic,
                'PicTelp' => $request->merchant_pic_phone,
                'Email' => $request->merchant_pic_email,
                'Kebutuhan' => $request->use_for,
            ]);
            return response(['msg' => 'The Merchant has been updated']);
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
        Merchant::where('id', $merchant->Id)->delete();
        return response(['message' => 'The merchant has been deleted']);
    }
}
