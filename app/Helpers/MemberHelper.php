<?php
namespace App\Helpers;

use App\Models\Log;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Merchant;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class MemberHelper {
    public static function indexMember()
    {
        if (request()->ajax()) {
            $members = Member::orderBy('id', 'DESC')->get();
            return response()->json($members);
        }
        return view('pages.member.index');
    }

    public static function createMember(Request $request)
    {
        $merchants = Merchant::select('Id', 'Nama')->get();
        return view('pages.member.editor', compact('request', 'merchants'));
    }

    public static function storeMember(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'merchant_id' => ['required'],
            'member_key' => ['required', 'string', 'max:150', 'unique:members'],
            'member_name' => ['required', 'string', 'max:150'],
            'member_note' => ['nullable', 'string', 'max:150'],
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), Response::HTTP_BAD_REQUEST);
        } else {
            // dd($request);
            Member::create([
                'IdMerhant' => $request->merchant_id,
                'MerchentMemberKey' => $request->member_key,
                'Point' => 0,
                'Nama' => $request->member_name,
                'Keterangan' => $request->member_note,
                'Aktif' => 1
            ]);
        }
        return response(['msg' => 'The member has been created']);
    }

    public static function editMember(Member $member)
    {
        return view('pages.member.editor', compact('member'));
    }

    public static function updateMember(Request $request, Member $member)
    {
        $validator = Validator::make($request->all(), [
            'member_key' => ['required'],
            'member_name' => ['required', 'string', 'max:250'],
            'member_note' => ['max:250'],
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), Response::HTTP_BAD_REQUEST);
        } else {
            Member::where('id', $member->Id)->update([
                'MerchentMemberKey' => $request->member_key,
                'Nama' => $request->member_name,
                'Keterangan' => $request->member_note,
            ]);
        }
        return response(['msg' => 'The member has been updated']);
    }

    public static function destroyMember(Member $member)
    {
        Member::where('id', $member->Id)->delete();
        return response(['message' => 'The member has been deleted']);
    }

    public static function getMembers(Request $request)
    {
        $members = Member::where('IdMerhant', $request->id)->orderBy('id', 'DESC')->get();
        return response()->json($members);
    }

    public static function getCountMembers(Request $request)
    {
        $countMembers = Member::where('IdMerhant', $request->id)->get()->count();
        return $countMembers;
    }

    public static function getCountMemberHistoryPoints(Request $request)
    {
        $idMerchant = Merchant::where('Token', $request->token)->pluck('Id')->first();
        $idMember = Member::where('MerchentMemberKey', $request->id)->where('IdMerhant', $idMerchant)->pluck('Id')->first();
        $exec = Log::select('CreateDate', 'Point')
                    ->where('IdMerchant', $idMerchant)
                    ->where('IdMember', $idMember)

                    ->get()->count();

        return $exec;
    }

}
