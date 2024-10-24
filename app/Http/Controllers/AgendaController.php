<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    
    /**
     *  Display a listing of the resource.
     *  
     */
    public function index()
    {
        $agendas = Agenda::all();

        return view('admin.agendas.index', ['agendas' => $agendas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $agendas = Agenda::all();

        return view('admin.agendas.create', ['agendas' => $agendas]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request->all());
        $agendaAttributes = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'days' => ['required', 'array'],
            'days.*.date' => ['required', 'string'],  // Date ( Thursday, 25 July ) or ( Day 1, Day 2 etc)
            'days.*.sections' => ['required', 'array'],  // Sections ( Time, Title, Subtitles )
            'days.*.sections.*.hour' => ['required', 'string'],  // Hour of the section
            'days.*.sections.*.title' => ['required', 'string'],  // Title of the section
            'days.*.sections.*.subtitle' => ['nullable', 'array'],  // Subtitles of the sections
            'days.*.sections.*.subtitle.*' => ['nullable', 'string'],  // Each subtitle
        ]);

        Agenda::create([
            'name' => $agendaAttributes['name'],
            'days' => $agendaAttributes['days'],
        ]);

        return redirect()->back()->with('success', 'Agenda created successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agenda $agenda)
    {
        // dd($request->all());

        $agendaAttributes = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'days' => ['required', 'array'],
            'days.*.date' => ['required', 'string'],
            'days.*.sections' => ['required', 'array'],
            'days.*.sections.*.hour' => ['required', 'string'],
            'days.*.sections.*.title' => ['required', 'string'],
            'days.*.sections.*.subtitle' => ['nullable', 'array'],
            'days.*.sections.*.subtitle.*' => ['nullable', 'string'],
        ]);

        $agenda->update([
            'name' => $agendaAttributes['name'],
            'days' => $agendaAttributes['days'],
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agenda $agenda)
    {
        $agenda->delete();

        return redirect()->back();
    }
}
