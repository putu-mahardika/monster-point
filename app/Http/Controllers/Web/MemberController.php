<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Helpers\MemberHelper;
use App\Models\Merchant;
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
        return MemberHelper::indexMember();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return MemberHelper::createMember();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('members create')) {
            return response(['msg' => 'You are not allowed to create members'], Response::HTTP_FORBIDDEN);
        }
        return MemberHelper::storeMember($request);
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
    public function edit(Member $member)
    {
        return MemberHelper::editMember($member);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        if (!auth()->user()->can('members edit')) {
            return response(['msg' => 'You are not allowed to edit members'], Response::HTTP_FORBIDDEN);
        }
        return MemberHelper::updateMember($request, $member);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        if (!auth()->user()->can('members delete')) {
            return response(['msg' => 'You are not allowed to delete members'], Response::HTTP_FORBIDDEN);
        }
        return MemberHelper::destroyMember($member);
    }

    public function getMembers(Request $request)
    {
        return MemberHelper::getMembers($request);
    }

    public function dx(Request $request, $merchant_id = null)
    {
        $members = Member::when(!empty($merchant_id), function ($query) use ($merchant_id) {
            return $query->where('IdMerhant', $merchant_id);
        })->get();
        return response()->json($members);
    }

}
