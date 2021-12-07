<?php

namespace App\Http\Controllers\API\V1;

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

     /**
     * @OA\Get(
     *      path="/api/v1/members",
     *      operationId="getMemberList",
     *      tags={"Members"},
     *      summary="Get list of members",
     *      description="Returns list of members",
     *
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", readOnly="true"),
     *              @OA\Property(property="data", type="object", readOnly="true")
     *          )
     *      ),
     *     )
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

     /**
     * @OA\Post(
     *      path="/api/v1/members",
     *      operationId="createMember",
     *      tags={"Members"},
     *      summary="Create members",
     *      description="Store a new member data",
     *
     *      @OA\RequestBody(
     *      required=true,
     *      description="Input member_key & member_name",
     *
     *       @OA\JsonContent(
     *       required={"member_key","member_name"},
     *       @OA\Property(property="member_key", type="string", example="8"),
     *       @OA\Property(property="member_name", type="string", example="ekky"),
     *    )
     * ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", readOnly="true"),
     *              @OA\Property(property="data", type="object", readOnly="true")
     *          )
     *      ),
     *     )
     */

    public function store(Request $request)
    {
        // return MemberHelper::storeMember($request);
        $validator = Validator::make($request->all(), [
            'member_key' => ['required'],
            'member_name' => ['required', 'string', 'max:150'],
            'member_note' => ['string', 'max:150'],
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), Response::HTTP_BAD_REQUEST);
        } else {
            Member::create([
                'IdMerhant' => '1',
                'MerchentMemberKey' => $request->member_key,
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
    /**
     * @OA\Get(
     *      path="api/v1/members/{member}",
     *      operationId="getMemberById",
     *      tags={"Members"},
     *      summary="Get Member information",
     *      description="Returns Member data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Member id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", readOnly="true"),
     *              @OA\Property(property="data", type="object", readOnly="true")
     *          )
     *      ),
     *
     * )
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

     /** @OA\Put(
     *      path="api/v1/members/{member} ",
     *      operationId="updateMember",
     *      tags={"Members"},
     *      summary="Update existing member",
     *      description="Returns updated member data",
     *
     *      @OA\Parameter(
     *          name="id",
     *          description="Member id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", readOnly="true"),
     *              @OA\Property(property="data", type="object", readOnly="true")
     *          )
     *      ),
     *
     * )
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
