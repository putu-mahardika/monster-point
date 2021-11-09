<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GreetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /**
    * @OA\Get(
    *     path="/greet",
    *     tags={"greeting"},
    *     summary="Returns a Sample API response",
    *     description="A sample greeting to test out the API",
    *     operationId="greet",
    *     @OA\Parameter(
    *          name="firstname",
    *          description="nama depan",
    *          required=true,
    *          in="query",
    *          @OA\Schema(
    *              type="string"
    *          )
    *     ),
    *     @OA\Parameter(
    *          name="lastname",
    *          description="nama belakang",
    *          required=true,
    *          in="query",
    *          @OA\Schema(
    *              type="string"
    *          )
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="successful operation"
    *     )
    * )
    */

    public function greets(Request $request)
   {
       $userData = $request->only([
           'namadepan',
           'namabelakang',
       ]);
       if (empty($userData['namadepan']) && empty($userData['namabelakang'])) {
           return new \Exception('Missing data', 404);
       }
       return 'Halo ' . $userData['namadepan'] . ' ' . $userData['namabelakang'];
   }
}
