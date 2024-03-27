<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCalendarRequest;
use App\Http\Requests\UpdateCalendarRequest;
use App\Models\Calendar;
use Inertia\Inertia;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $calendars = Calendar::with('appointments')->get();
        return Inertia::render('Calendars/Index', [
            'calendars' => $calendars,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Calendars/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCalendarRequest $request)
    {
        $data = $request->validated();
        Calendar::create($data);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Calendar $calendar)
    {
        $calendar->load('appointments');
        return Inertia::render('Calendars/Show', [
            'calendar' => $calendar,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Calendar $calendar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCalendarRequest $request, Calendar $calendar)
    {
        $data = $request->validated();
        $calendar->update($data);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Calendar $calendar)
    {
        $calendar->delete();
        return redirect()->back();
    }
}
