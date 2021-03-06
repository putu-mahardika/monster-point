<?php

namespace App\Http\Controllers\Web;

use App\Helpers\FunctionHelper;
use App\Http\Controllers\Controller;
use App\Models\GlobalSetting;
use App\Rules\UniqueInGroup;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class GlobalSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if (request()->ajax()) {
        //     $globalSettings = GlobalSetting::all();
        //     return response()->json($globalSettings);
        // }
        // if (request()->ajax()) {
            $settings = $this->getSettings();
            // dd($settings);
            // dd(response()->json($globalSettings));
            // return response()->json($globalSettings);
        // }
        return view('pages.global-setting.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('pages.global-setting.editor');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'code' => ['required', 'string', 'max:10'],
        //     'value' => ['required'],
        //     'note' => ['string', 'max:250'],
        // ]);

        // if ($validator->fails()) {
        //     return response($validator->errors(), Response::HTTP_BAD_REQUEST);
        // }
        // $globalSetting = GlobalSetting::create([
        //     'Kode' => $request->code,
        //     'Value' => $request->value,
        //     'Keterangan' => $request->note
        // ]);
        // return response(['msg' => 'The Setting has been created']);
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
    public function edit(GlobalSetting $setting)
    {
        // dd($setting);
        return view('pages.global-setting.editor', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GlobalSetting $setting)
    {
        $validator = Validator::make($request->all(), [
            // 'code' => ['required', 'string', 'max:10'],
            'value' => ['required'],
            'note' => ['string', 'max:250'],
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        GlobalSetting::where('Id', $setting->Id)->update([
            // 'Kode' => $request->code,
            'Value' => $request->value,
            'Keterangan' => $request->note
        ]);
        $setting->refresh();
        return response(['msg' => 'The Setting has been updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(GlobalSetting $setting)
    {
        $query = $setting->delete();
        if ($query) {
            return response()->json(['code' => 1, 'msg' => 'Setting Has Been Deleted From Databases']);
        } else {
            return response()->json(['code' => 0, 'msg' => 'Something went wrong']);
        }
    }

    public function getSettings()
    {
        $settings = GlobalSetting::orderBy('id', 'asc')->get();
        return $settings;
    }
}
