<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\support\Carbon;

class EventController extends Controller
{
    public function events()
    {
        // Define the date range: today and four months from today
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->addMonths(3)->endOfMonth(); // Up to the end of the fourth month

        // Retrieve events within the date range
        $events = Event::whereBetween('event_date', [$startDate, $endDate])
            ->orderBy('event_date', 'asc')
            ->get()
            ->groupBy(function ($event) {
                return Carbon::parse($event->event_date)->format('F Y');
            });

        return view('events', compact('events'));
    }

    public function eventDetail($id)
    {
        $event = Event::find($id);
        return view('event-detail', compact('event'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Event::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $events = $query->paginate(10);

        return view('admin.events.index', compact('events'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        $event = new Event();
        $event->title = $request->title;
        $event->description = $request->description;
        $event->event_date = $request->event_date;
        $event->start_time = $request->start_time;
        $event->location = $request->location;
        $event->latitude = $request->latitude;
        $event->longitude = $request->longitude;

        if ($request->hasFile('image')) {
            $filename = 'event/' . (string) Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();
            Storage::disk('public')->put($filename, file_get_contents($request->file('image')));
            $event->image = $filename;
        }

        $event->save();

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        Event::find($event->id);
        return view('admin.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->title = $request->title;
        $event->description = $request->description;
        $event->event_date = $request->event_date;
        $event->start_time = $request->start_time;
        $event->location = $request->location;
        $event->latitude = $request->latitude;
        $event->longitude = $request->longitude;

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($event->image);
            $filename = 'event/' . (string) Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();
            Storage::disk('public')->put($filename, file_get_contents($request->file('image')));
            $event->image = $filename;
        }

        $event->save();

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        Storage::disk('public')->delete($event->image);
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}
