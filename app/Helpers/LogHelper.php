<?php
namespace App\Helpers;

use App\Models\Event;
use App\Models\Log;
use App\Models\Member;
use App\Models\Merchant;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

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
            $idMerchant = Merchant::where('Token', $token)->pluck('Id')->first();
            $idEvent = Event::where('Kode', $event)->where('IdMerchant', $idMerchant)->pluck('Id')->first();
            $idMember = Member::where('MerchentMemberKey', $id)->where('IdMerhant', $idMerchant)->pluck('Id')->first();
            $guid = Str::upper(Str::uuid());

            Log::create([
                'Guid' => $guid,
                'IdMerchant' => $idMerchant,
                'IdMember' => $idMember,
                'IdEvent' => $idEvent,
                'Node' => $event,
                'Keterangan' => $e->getMessage(),
                'Point' => 0,
                'Status' => 400,
            ]);
            return response()->json(['message' => 'Something went wrong!'], 400);
        }
        return response()->json($exec);
    }

    public static function memberHistoryPoint(Request $request, $token, $id){

        $idMerchant = Merchant::where('Token', $token)->pluck('Id')->first();
        $idMember = Member::where('MerchentMemberKey', $id)->where('IdMerhant', $idMerchant)->pluck('Id')->first();
        $exec = Log::select('CreateDate', 'Point')->where('IdMerchant', $idMerchant)->where('IdMember', $idMember)->get();

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
