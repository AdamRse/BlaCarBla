<?php

namespace App\Http\Controllers;

use App\Models\cities;
use App\Models\journey;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class JourneyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'time_departure' => 'required|date|after:now',
            'time_travel' => 'required|date|after:time_departure',
            'seats' => 'required|integer|min:1|max:31',
        ]);

        if ($validator->fails())
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $journey = journey::find($id);
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
    public function update(Request $request, journey $journey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(journey $journey)
    {
        //
    }
}
