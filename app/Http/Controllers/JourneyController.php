<?php

namespace App\Http\Controllers;

use App\Models\journey;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class JourneyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $journeys = Journey::with(['driver', 'departure', 'arrival'])->get();
        return response()->json($journeys, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $authUser = auth()->user();
        $validator = Validator::make($request->all(), [
            'addr_departure' => 'required|string|max:255',
            'addr_arrival' => 'required|string|max:255',
            'city_departure_id' => 'required|exists:cities,id',
            'city_arrival_id' => 'required|exists:cities,id',
            'time_departure' => 'required|date_format:Y-m-d H:i:s|after:now',
            'time_travel' => 'required|date_format:Y-m-d H:i:s|after:time_departure',
            'seats' => 'required|integer|min:1|max:31',
        ]);

        if($validator->fails())
            return response()->json(['errors' => $validator->errors()], 422);
        if($authUser->role_id != 2 && $authUser->role_id != 1)
            return response()->json(['errors' => ''], 403);

        $journey = journey::create([
            'driver' => $authUser->id,
            'departure' => $request->city_departure_id,
            'arrival' => $request->city_arrival_id,
            'addr_departure' => $request->addr_departure,
            'addr_arrival' => $request->addr_arrival,
            'time_departure' => $request->time_departure,
            'time_travel' => $request->time_travel,
            'seats' => $request->seats
        ]);

        return response()->json($journey, 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start' => 'required|exists:cities,id'
            ,'end' => 'required|exists:cities,id'
            ,'date' => 'required|date_format:Y-m-d H:i:s|after:now'
        ]);
        if($validator->fails())
            return response()->json(['errors' => $validator->errors()], 422);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $journey = journey::with(['driver', 'departure', 'arrival'])->find($id);
        if(!$journey)
            return response()->json(["error" => "Missing trip"], 404);
        return response()->json($journey, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(journey $journey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $journey = journey::find($id);
        if (!$journey)
            return response()->json(['error' => 'Missing trip'], 404);

        $validator = Validator::make($request->all(), [
            'driver' => 'nullable|exists:user,id',
            'departure' => 'nullable|exists:cities,id',
            'arrival' => 'nullable|exists:cities,id',
            'addr_departure' => 'nullable|string|max:255',
            'addr_arrival' => 'nullable|string|max:255',
            'time_departure' => 'nullable|date_format:Y-m-d H:i:s|after:now',
            'time_travel' => 'nullable|date_format:Y-m-d H:i:s|after:time_departure',
            'seats' => 'nullable|integer|between:0,31',
        ]);
        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $journey->update($request->only([
            'driver'
            ,'departure'
            ,'arrival'
            ,'addr_departure'
            ,'addr_arrival'
            ,'time_departure'
            ,'time_travel'
            ,'seats'
        ]));
        $journey = journey::with(['driver', 'departure', 'arrival'])->find($id);
        return response()->json($journey, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $journey = journey::find($id);
        if (!$journey)
            return response()->json(['error' => 'Missing trip'], 404);

        $authUser = auth()->user();
        if ($authUser->id != $journey->driver && $authUser->role_id !== 1)
            return response()->json(['error' => 'Unauthorized action : user '
            .$authUser->id.' (role '.$authUser->role_id.') can\'t delete trip'], 403);
        
        $journey->delete();
        return response()->json(['confirm' => 'trip deleted'], 200);
    }
}
