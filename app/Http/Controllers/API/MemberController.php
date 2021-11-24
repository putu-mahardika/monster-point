<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Helpers\MemberHelper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $member = Member::all();
        return response()->json([
            'status' => 'success',
            'data' => $member
        ]);
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
        // return MemberHelper::storeMember($request);
        $validator = Validator::make($request->all(), [
            'member_key' => ['required'],
            'member_name' => ['required', 'string', 'max:250'],
            'member_note' => ['string', 'max:250'],
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), Response::HTTP_BAD_REQUEST);
        } else {
            Member::create([
                'IdMerhant' => 1,
                'MerchentMemberKey' => 2,
                'Point' => $request->member_key,
                'Nama' => $request->member_name,
                'Keterangan' => $request->member_note,
                'Aktif' => 1,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'data berhasil ditambahkan'
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        $member = Member::where('id', $member->Id)->first();
        return response()->json([
            'status' => 'success',
            'data' => $member
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        $member = Member::where('id', $id)->first();
        if ( Member::where('id', $member->Id)->doesntExist() ) {
            return response()->json([
                'status' => 'error',
                'message' => 'Member tidak ditemukan'
            ]);
        } else {
            Member::where('id', $member->Id)->update([
                'Aktif' => 0
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'data berhasil di update'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
