<?php

namespace App\Http\Controllers\Web;

use App\Helpers\FunctionHelper;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Merchant;
use App\Rules\UniqueInGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if (request()->ajax()) {
        //     $events = Event::all();
        //     return response()->json($events);
        // }
        return view('pages.event.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.event.editor');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('events create')) {
            return response(['msg' => 'You are not allowed to create events'], Response::HTTP_FORBIDDEN);
        }

        $validator = Validator::make($request->all(),[
            'code' => ['required', new UniqueInGroup('events', 'Kode', 'IdMerchant', $request->merchant_id), 'string', 'max:10'],
            'name' => ['required', 'string', 'max:250'],
            'note' => ['nullable', 'string', 'max:250'],
            'formula' => ['required', 'string', 'max:500'],
            'action' => ['required'],
            // 'rate_limiter' => ['required', 'min:0', 'numeric']
        ]);
        // dd('stop');

        if ($validator->fails()) {
            return response($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $event = Event::create([
            'IdMerchant' => $request->merchant_id,
            'Kode' => $request->code,
            'Event' => $request->name,
            'Keterangan' => $request->note,
            'Formula' => FunctionHelper::formatFormula($request->formula),
            'Daily' => $request->action == 'daily' ? true : null,
            'OnceTime' => $request->action == 'oncetime' ? true : null,
            // 'LockDelay' => $request->rate_limiter
        ]);

        return response([
            'message' => 'The event has been created',
            'url' => route('events.edit', $event)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return view('pages.event.editor', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        if (!auth()->user()->can('events edit')) {
            return response(['msg' => 'You are not allowed to edit events'], Response::HTTP_FORBIDDEN);
        }

        $validator = Validator::make($request->all(),[
            'code' => ['required', new UniqueInGroup('events', 'Kode', 'IdMerchant', $event->merchant->Id, $request->code), 'string', 'max:10'],
            'name' => ['required', 'string', 'max:250'],
            'note' => ['string', 'max:250'],
            'formula' => ['required', 'string', 'max:500'],
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        Event::where('Id', $event->Id)->update([
            'Kode' => $request->code,
            'Event' => $request->name,
            'Keterangan' => $request->note,
            'Formula' => FunctionHelper::formatFormula($request->formula),
            'Daily' => $request->action == 'daily' ? true : null,
            'OnceTime' => $request->action == 'oncetime' ? true : null,
            // 'LockDelay' => $request->rate_limiter
        ]);
        $event->refresh();

        return response([
            'message' => 'The event has been updated',
            'url' => route('events.edit', $event)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        if (!auth()->user()->can('events delete')) {
            return response(['msg' => 'You are not allowed to delete events'], Response::HTTP_FORBIDDEN);
        }

        $event->delete();
        return response([
            'message' => 'The event has been deleted',
        ]);
    }

    public function eventTest(Event $event)
    {
        try {
            $exec = DB::select('SET NOCOUNT ON; EXEC dbo.sp_FormulaTesting @token = ?, @event = ?, @value = ?', [
                $event->merchant->Token,
                $event->Kode,
                rand(1, 10)
            ]);
            $event->update(['tested' => true]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong!'], 400);
        }
        return response()->json($exec);
    }

    public function dx(Request $request, $merchant_id)
    {
        $events = Event::where('IdMerchant', $merchant_id)->get();
        return response()->json($events);
    }
}
