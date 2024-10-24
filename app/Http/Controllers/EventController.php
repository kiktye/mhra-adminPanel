<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Event;
use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class EventController extends Controller
{

    public function userIndex()
    {
        $events = Event::with(['speakers', 'agenda'])->orderByDesc('is_featured')->get();
        // dd($events);
        return view('events.index', ['events' => $events]);
    }

    public function userShow(Event $event)
    {
        $event->load(['speakers', 'agenda']);

        $tickets = json_decode($event->ticket_prices, true);
        $relatedEvents = $event->relatedEvents();

        return view('events.show', ['event' => $event, 'tickets' => $tickets, 'relatedEvents' => $relatedEvents]);
    }

    // Admin Panel

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with(['speakers', 'agenda'])->get();

        return view('admin.Events.index', ['events' => $events]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $agendas = Agenda::all();
        $speakers = Speaker::all();

        return view('admin.Events.create', ['agendas' => $agendas, 'speakers' => $speakers]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $eventAttributes = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'theme' => ['required', 'string', 'max:255'],
            'description' => ['required'],
            'objective' => ['required'],
            'location' => ['required', 'string'],
            'date' => ['required', 'date'],
            'ticket_prices' => ['required', 'array'],
            'ticket_prices.*.type' => ['required', 'string'],
            'ticket_prices.*.price' => ['required', 'numeric'],
            'agenda_id' => ['required', 'exists:agendas,id'],
            'photo_path' => ['required', 'image', File::types(['jpg', 'jpeg', 'png', 'webp'])],
            'is_featured' => ['boolean'],
        ]);

        $photoPath = $request->photo_path->store('events', 'public');

        Event::create([
            'title' => $eventAttributes['title'],
            'theme' => $eventAttributes['theme'],
            'description' => $eventAttributes['description'],
            'objective' => $eventAttributes['objective'],
            'location' => $eventAttributes['location'],
            'date' => $eventAttributes['date'],
            'ticket_prices' => json_encode($eventAttributes['ticket_prices']),
            'agenda_id' => $eventAttributes['agenda_id'],
            'photo_path' => $photoPath,
            'is_featured' => $blogAttributes['is_featured'] ?? false,
        ]);

        return redirect()->route('events.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load(['speakers', 'agenda']);
        $tickets = json_decode($event->ticket_prices, true);
        $agenda = Agenda::find($event->agenda_id);

        $relatedEvents = $event->relatedEvents();

        return view('admin.Events.show', ['event' => $event, 'tickets' => $tickets, 'agenda' => $agenda, 'relatedEvents' => $relatedEvents]);
    }

    /**
     * Update the image in storage.
     */
    public function updateImage(Request $request, Event $event)
    {
        $request->validate([
            'photo_path' => ['required', 'image', File::types(['jpg', 'jpeg', 'png', 'webp'])],
        ]);

        $photoPath = $request->photo_path->store('events', 'public');

        if ($event->photo_path) {
            Storage::disk('public')->delete($event->photo_path);
        };

        $event->update([
            'photo_path' => $photoPath,
        ]);

        return redirect()->back();
    }

    /**
     * Remove image from storage.
     */
    public function deleteImage(Event $event)
    {
        if ($event->photo_path) {
            Storage::disk('public')->delete($event->photo_path);

            $event->update(['photo_path' => null]);

            return redirect()->back();
        };

        return redirect()->back()->with('error', 'No image to delete.');
    }

    /**
     * Update location and date in storage.
     */
    public function updateInfo(Request $request, Event $event)
    {
        $request->validate([
            'location' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
        ]);

        $event->update([
            'location' => $request->location,
            'date' => $request->date,
        ]);

        return redirect()->back();
    }

    /**
     * Update title and theme in storage.
     */
    public function updateMain(Request $request, Event $event)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'theme' => ['required', 'string', 'max:255'],
        ]);

        $event->update([
            'title' => $request->title,
            'theme' => $request->theme,
        ]);

        return redirect()->back();
    }

    /**
     * Update description and objective in storage.
     */
    public function updateContent(Request $request, Event $event)
    {
        $request->validate([
            'description' => ['required'],
            'objective' => ['required'],
        ]);

        $event->update([
            'description' => $request->description,
            'objective' => $request->objective,
        ]);

        return redirect()->back();
    }

    /**
     * Update prices for event tickets in storage.
     */
    public function updatePrices(Request $request, Event $event)
    {
        $request->validate([
            'ticket_prices' => ['required', 'array'],
            'ticket_prices.*.type' => ['required', 'string'],
            'ticket_prices.*.price' => ['required', 'numeric'],
        ]);

        $event->update([
            'ticket_prices' => json_encode($request->ticket_prices),
        ]);

        return redirect()->back();
    }

    /**
     * Set the event as featured.
     */
    public function featured(Event $event)
    {
        Event::where('id', '!=', $event->id)->update(['is_featured' => false]);

        $event->update([
            'is_featured' => true,
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index');
    }
}
