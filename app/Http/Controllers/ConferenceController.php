<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Conference;
use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;


class ConferenceController extends Controller
{

    public function userIndex()
    {
        $conference = Conference::with(['speakers', 'agenda'])->where('status', 'active')->get();
        return view('conferences.index', ['conference' => $conference]);
    }

    public function userShow(Conference $conference)
    {
        $conference->load(['speakers', 'agenda']);

        $tickets = json_decode($conference->ticket_packages, true);

        return view('conferences.show', ['conference' => $conference, 'tickets' => $tickets]);
    }

    // Admin Panel

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $conferences = Conference::all();
        return view('admin.conferences.index', ['conferences' => $conferences]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $agendas = Agenda::all();
        $speakers = Speaker::all();

        return view('admin.conferences.create', ['agendas' => $agendas, 'speakers' => $speakers]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $conferenceAttributes = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required'],
            'location' => ['required', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'ticket_packages' => ['required', 'array'],
            'ticket_packages.*.type' => ['required', 'string'],
            'ticket_packages.*.price' => ['required', 'numeric'],
            'ticket_packages.*.option' => ['nullable', 'array'],
            'ticket_packages.*.option.*' => ['nullable', 'string'],
            'agenda_id' => ['required', 'exists:agendas,id'],
            'photo_path' => ['required', 'image', File::types(['jpg', 'jpeg', 'png', 'webp'])],
        ]);

        $photoPath = $request->photo_path->store('conferences', 'public');


        Conference::create([
            'title' => $conferenceAttributes['title'],
            'description' => $conferenceAttributes['description'],
            'location' => $conferenceAttributes['location'],
            'start_date' => $conferenceAttributes['start_date'],
            'end_date' => $conferenceAttributes['end_date'],
            'ticket_packages' => json_encode($conferenceAttributes['ticket_packages']),
            'agenda_id' => $conferenceAttributes['agenda_id'],
            'photo_path' => $photoPath,
        ]);

        return redirect()->route('conferences.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Conference $conference)
    {
        // dd($conference);
        $conference->load(['speakers', 'agenda']);
        $tickets = json_decode($conference->ticket_packages, true);

        $agenda = Agenda::find($conference->agenda_id);

        return view('admin.Conferences.show', ['conference' => $conference, 'tickets' => $tickets, 'agenda' => $agenda]);
    }

    /**
     * Update the image in storage.
     */
    public function updateImage(Request $request, Conference $conference)
    {
        $request->validate([
            'photo_path' => ['required', 'image', File::types(['jpg', 'jpeg', 'png', 'webp'])],
        ]);

        $photoPath = $request->photo_path->store('conferences', 'public');

        if ($conference->photo_path) {
            Storage::disk('public')->delete($conference->photo_path);
        };

        $conference->update([
            'photo_path' => $photoPath,
        ]);

        return redirect()->back();
    }

    /**
     * Update the location and dates in storage.
     */
    public function updateInfo(Request $request, Conference $conference)
    {
        $request->validate([
            'location' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
        ]);

        $conference->update([
            'location' => $request->location,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,

        ]);

        return redirect()->back();
    }

    /**
     * Update the title and description in storage.
     */
    public function updateMain(Request $request, Conference $conference)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required'],
        ]);

        $conference->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->back();
    }

    /**
     * Update the prices packages in storage.
     */
    public function updatePrices(Request $request, Conference $conference)
    {
        $request->validate([
            'ticket_packages' => ['required', 'array'],
            'ticket_packages.*.type' => ['required', 'string'],
            'ticket_packages.*.price' => ['required', 'numeric'],
            'ticket_packages.*.option' => ['nullable', 'array'],
            'ticket_packages.*.option.*' => ['nullable', 'string'],
        ]);

        $conference->update([
            'ticket_packages' => json_encode($request->ticket_packages),
        ]);

        return redirect()->back();
    }

    /**
     * Update the conference status in storage.
     */
    public function updateStatus(Request $request, Conference $conference)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,canceled',
        ]);

        $conference->update([
            'status' => $request->status,
        ]);

        return redirect()->back();
    }

    /**
     * Remove image from storage.
     */
    public function deleteImage(Conference $conference)
    {
        if ($conference->photo_path) {
            Storage::disk('public')->delete($conference->photo_path);

            $conference->update(['photo_path' => null]);

            return redirect()->back();
        };

        return redirect()->back()->with('error', 'No image to delete.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Conference $conference)
    {
        $conference->delete();

        return redirect()->route('conferences.index');
    }
}
