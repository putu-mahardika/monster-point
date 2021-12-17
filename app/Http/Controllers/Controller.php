<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

 /**
 * @OA\Info(
 *    title="Monster Point Service API Documentation",
 *    version="1.0.0",
 *    description = "This is a direction for using all the APIs that we have created for our Monster Point Service users.",
 *    @OA\Contact(
 *         email="superadmin@monsterpoint.com"
 *      )
 *  )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
