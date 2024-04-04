<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Log;
use App\Events\UpdateCalendar;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $request->all();
        if (isset($data['calendar_id'])) {
            $appointments = Appointment::where('calendar_id', $data['calendar_id'])->get();
        }
        else {
            $appointments = Appointment::all();
        }
        return response()->json($appointments);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request)
    {
        $data = $request->validated();
        $appointment = Appointment::create($data);
        event(new UpdateCalendar($appointment));
        return response()->json(['message' => 'Appointment created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $data = $request->validated();
        $data['start'] = date('Y-m-d H:i:s', strtotime($data['start']));
        $data['end'] = date('Y-m-d H:i:s', strtotime($data['end']));
        $appointment->update($data);

        event(new UpdateCalendar($appointment));
       
        return response()->json(['message' => 'Appointment updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        event(new UpdateCalendar($appointment));
        $appointment->delete();
        return response()->json(['message' => 'Appointment deleted successfully']);
    }
}
