<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

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
            $merchants = Merchant::all();
            return response($merchants);
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
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $query = Merchant::create([
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

            if ($query) {
                return response()->json(['code' => 1, 'msg' => 'New Merchant has been successfuly saved']);
            } else {
                return response()->json(['code' => 0, 'msg' => 'Something went wrong']);
            }
        }
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
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $query = $merchant->where('id', $merchant->Id)->update([
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
        $query = $merchant->delete();
        if ($query) {
            return response()->json(['code' => 1, 'msg' => 'Merchant Has Been Deleted From Databases']);
        } else {
            return response()->json(['code' => 0, 'msg' => 'Something went wrong']);
        }
    }
}
