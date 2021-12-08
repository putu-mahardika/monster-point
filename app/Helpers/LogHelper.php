<?php
namespace App\Helpers;

use App\Models\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class LogHelper {
    public static function indexLogApi(Request $request, $token, $event, $id, $value){
        try {
            $exec = DB::select('SET NOCOUNT ON; EXEC dbo.sp_ExecEvent @token = ?, @idmember = ?, @event = ?, @value = ?', [
                $token,
                $id,
                $event,
                $value
            ]);
            unset($exec[0]->Times);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong!'], 400);
        }
        return response()->json($exec);
    }

    public static function memberHistoryPoint(Request $request, $token, $id){

        try {
            $exec = DB::table('Log')
                        ->join('Member', 'Log.IdMember', '=', 'Member.Id')
                        ->select('Log.CreateDate as CreateDate',
                                 'Log.Point as Point')
                        ->where('Log.IdMember', $id)
                        ->where('Member.MerchentMemberKey', $token)
                        ->orderByDesc('CreateDate')
                        ->get();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong!'], 400);
        }

        return response()->json($exec);
    }

}
