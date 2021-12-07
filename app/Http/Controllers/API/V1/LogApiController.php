<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\LogHelper;
class LogApiController extends Controller
{
    // public function index($token, $event, $id, $value){
    //     return LogHelper::indexLogApi($token, $event, $id, $value);
    // }

     /**
     * @OA\Get(
     *      path="api/v1/{token}/{event}/{id}/{value}",
     *      operationId="getTransactionData",
     *      tags={"Transaction"},
     *      summary="Get All Transaction",
     *      description="Returns Transaction Data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Transaction id",
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

    public function transaction(Request $request, $token, $event, $id, $value){
        return LogHelper::indexLogApi($request, $token, $event, $id, $value);
    }

    /**
     * @OA\Get(
     *      path="api/v1/{token}/history/{id}",
     *      operationId="getMemberHistoryPoint",
     *      tags={"Transaction"},
     *      summary="Get Member History Transaction Information",
     *      description="Returns Member Transaction Data",
     *      @OA\Parameter(
     *          name="id",
     *          description="History id",
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

    public function getMemberHistoryPoint(Request $request, $token, $id){
        return LogHelper::memberHistoryPoint($request, $token, $id);
    }
}
