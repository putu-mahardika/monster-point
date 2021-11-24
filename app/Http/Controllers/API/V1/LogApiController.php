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
    public function transaction(Request $request, $token, $event, $id, $value){
        return LogHelper::indexLogApi($request, $token, $event, $id, $value);

    }
}
