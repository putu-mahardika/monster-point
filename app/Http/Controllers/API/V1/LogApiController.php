<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\LogHelper;
use App\Jobs\Transactions;
use App\Models\Member;
use App\Models\Merchant;
use Illuminate\Database\Eloquent\Builder;
use Log;

class LogApiController extends Controller
{
     /**
     * @OA\POST(
     *      path="/api/v1/{token}/{event}/{id}/{value}",
     *      tags={"Transaction"},
     *      summary="Make poin by user activity",
     *      description="Make points based on the value obtained by the user from the results of activities in the application. For example: the value of playing games, the minimum number of transactions a user achieves when shopping online, and so on.",
     *      @OA\Parameter(
     *          name="token",
     *          description="Your Token",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="event",
     *          description="The event name you created",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Member Key",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="value",
     *          description="Value obtained by user, e.g : game score",
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

    public function transaction($token, $event, $id, $value){
        $member = Member::whereHas('Merchant', function (Builder $query) use ($token) {
            $query->where('Token', $token);
        })->where('MerchentMemberKey', $id)->pluck('id')->first();

        dispatch(new Transactions($token, $event, $member, $value));

        Log::info('Dispached Transaction');
        return response()->json([
            'message' => 'Dispached Transaction'
        ]);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/{token}/history/{id}",
     *      tags={"Transaction"},
     *      summary="Show member point history",
     *      description="Displays the entire history of member points based on the member_key entered.",
     *      @OA\Parameter(
     *          name="token",
     *          description="Your Token",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Member Key",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
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

    public function getMemberHistoryPoint(Request $request, $token, $id){
        return LogHelper::memberHistoryPoint($request, $token, $id);
    }
}
