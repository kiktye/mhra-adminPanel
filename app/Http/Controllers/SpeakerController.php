<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Event;
use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class SpeakerController extends Controller
{


    /** 
     * Display a listing of the resource.
     */
    public function index(Speaker $speaker)
    {
        $speakers = Speaker::with(['event', 'conference'])->orderBy('is_special_guest', 'desc')->get();
        $events = Event::all();
        $conferences = Conference::all();

        return view('admin.Speakers.index', ['speakers' => $speakers, 'events' => $events, 'conferences' => $conferences]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = Event::all();
        $conferences = Conference::all();

        return view('admin.Speakers.create', ['events' => $events, 'conferences' => $conferences]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $speakerAttributes = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'photo_path' => ['required', 'image', File::types(['jpg', 'jpeg', 'png', 'webp'])],
            'social_links' => ['required', 'array'],
            'social_links.*.platform' => ['required', 'string'],
            'social_links.*.link' => ['required', 'string'],
            'is_special_guest' => ['boolean'],
            'conference_id' => ['nullable', 'exists:conferences,id'],
            'event_id' => ['nullable', 'exists:events,id'],
        ]);


        $photoPath = $request->photo_path->store('speakers', 'public');

        Speaker::create([
            'name' => $speakerAttributes['name'],
            'surname' => $speakerAttributes['surname'],
            'title' => $speakerAttributes['title'],
            'photo_path' => $photoPath,
            'social_links' => json_encode($speakerAttributes['social_links']),
            'is_special_guest' => $speakerAttributes['is_special_guest'] ?? false,
            'event_id' => $speakerAttributes['event_id'],
            'conference_id' => $speakerAttributes['conference_id']
        ]);

        return redirect()->back()->with('success', 'Говорник е успешно запишан.!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(Speaker $speaker)
    {

        $speaker->load(['event', 'conference']);
        $socialLinks = json_decode($speaker->social_links, true);

        $events = Event::all();
        $conferences = Conference::all();

        return view('admin.Speakers.show', ['speaker' => $speaker, 'socialLinks' => $socialLinks, 'events' => $events, 'conferences' => $conferences]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Speaker $speaker)
    {

        // dd($request->all());
        $speakerAttributes = $request->validate([
            'is_special_guest' => ['boolean'],
            'conference_id' => ['nullable', 'exists:conferences,id'],
            'event_id' => ['nullable', 'exists:events,id'],
        ]);


        $speaker->update([
            'is_special_guest' => $speakerAttributes['is_special_guest'] ?? false,
            'event_id' => $speakerAttributes['event_id'],
            'conference_id' => $speakerAttributes['conference_id']
        ]);

        return redirect()->back()->with('success', 'Говорник е успешно ажуриран!');
    }


    /**
     * Update the image in storage.
     */
    public function updateImage(Request $request, Speaker $speaker)
    {
        $request->validate([
            'photo_path' => ['required', 'image', File::types(['jpg', 'jpeg', 'png', 'webp'])],
        ]);

        $photoPath = $request->photo_path->store('speakers', 'public');

        if ($speaker->photo_path) {
            Storage::disk('public')->delete($speaker->photo_path);
        };

        $speaker->update([
            'photo_path' => $photoPath,
        ]);

        return redirect()->back();
    }

    /**
     * Update credentials in storage.
     */
    public function updateCredentials(Request $request, Speaker $speaker)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required'],
            'title' => ['required']
        ]);

        $speaker->update([
            'name' => $request->name,
            'surname' => $request->surname,
            'title' => $request->title
        ]);

        return redirect()->back();
    }

    /**
     * Update social links in storage.
     */
    public function updateLinks(Request $request, Speaker $speaker)
    {
        $infoAttributes = $request->validate([
            'social_links' => ['required', 'array'],
            'social_links.*.platform' => ['required', 'string'],
            'social_links.*.link' => ['required', 'string'],
        ]);


        $speaker->update([
            'social_links' => json_encode($infoAttributes['social_links']),
        ]);

        return redirect()->back();
    }

    /**
     * Unassign Speaker from Event.
     */
    public function removeFromEvent(Request $request, Speaker $speaker)
    {
        $speaker->update([
            'event_id' => null
        ]);

        return redirect()->back();
    }

    /**
     * Unassign Speaker from Conference.
     */
    public function removeFromConference(Request $request, Speaker $speaker)
    {

        if ($speaker->is_special_guest) {
            $speaker->update([
                'conference_id' => null,
                'is_special_guest' => false
            ]);
        } else {
            $speaker->update([
                'conference_id' => null
            ]);
        }

        return redirect()->back();
    }

    /**
     * Remove image from storage.
     */
    public function deleteImage(Speaker $speaker)
    {
        if ($speaker->photo_path) {
            Storage::disk('public')->delete($speaker->photo_path);

            $speaker->update(['photo_path' => null]);

            return redirect()->back();
        };

        return redirect()->back()->with('error', 'No image to delete.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Speaker $speaker)
    {
        $speaker->delete();

        return redirect()->route('speakers.index')->with('success', 'Говорник е успешно избришан!');
    }
}
