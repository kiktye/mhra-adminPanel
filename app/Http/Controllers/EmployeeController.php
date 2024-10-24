<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Member;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class EmployeeController extends Controller
{

    public function userIndex()
    {
        $employees = Employee::with(['role'])->get();
        $president = Employee::where('role_id', 1)->first();

        return view('employees.index', ['employees' => $employees, 'president' => $president]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with(['role'])->get();

        return view('admin.Employees.index', ['employees' => $employees]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();

        return view('admin.Employees.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request->all());
        $employeeAttributes = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'photo_path' => ['required', 'image', File::types(['jpg', 'jpeg', 'png', 'webp'])],
            'description' => ['array'],
            'description.*' => ['nullable', 'string'],
            'social_links' => ['required', 'array'],
            'social_links.*.platform' => ['required', 'string'],
            'social_links.*.link' => ['required', 'string'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);


        $photoPath = $request->photo_path->store('employees', 'public');

        Employee::create([
            'name' => $employeeAttributes['name'],
            'surname' => $employeeAttributes['surname'],
            'title' => $employeeAttributes['title'],
            'photo_path' => $photoPath,
            'description' => json_encode($employeeAttributes['description']),
            'social_links' => json_encode($employeeAttributes['social_links']),
            'role_id' => $employeeAttributes['role_id']
        ]);

        return redirect()->back()->with('success', 'Вработен е успешно додаден.!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {

        $employee->load(['role']);
        $descriptions = json_decode($employee->description, true);
        $roles = Role::all();


        return view('admin.Employees.show', ['employee' => $employee, 'descriptions' => $descriptions, 'roles' => $roles]);
    }

    /**
     * Update the image in storage.
     */
    public function updateImage(Request $request, Employee $employee)
    {
        $request->validate([
            'photo_path' => ['required', 'image', File::types(['jpg', 'jpeg', 'png', 'webp'])],
        ]);

        $photoPath = $request->photo_path->store('blogs', 'public');

        if ($employee->photo_path) {
            Storage::disk('public')->delete($employee->photo_path);
        };

        $employee->update([
            'photo_path' => $photoPath,
        ]);

        return redirect()->back();
    }

    /**
     * Update the main info in storage.
     */
    public function updateInfo(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
        ]);

        $employee->update([
            'name' => $request->name,
            'surname' => $request->surname,
        ]);

        return redirect()->back();
    }


    public function deleteImage(Employee $employee)
    {
        if ($employee->photo_path) {
            Storage::disk('public')->delete($employee->photo_path);

            $employee->update(['photo_path' => null]);

            return redirect()->back();
        };

        return redirect()->back()->with('error', 'No image to delete.');
    }


    public function updateDescription(Request $request, Employee $employee)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['array'],
            'description.*' => ['nullable', 'string',],
        ]);

        $employee->update([
            'title' => $request->title,
            'description' => json_encode($request->description),
        ]);

        return redirect()->back();
    }

    public function updateRole(Request $request, Employee $employee)
    {

        $request->validate([
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $employee->update([
            'role_id' => $request->role_id,
        ]);

    return redirect()->back();
    }

    /**
     * Remove a description section from storage.
     */
    public function deleteSection(Employee $employee, $descriptionIndex)
    {
        $descriptions = json_decode($employee->description, true);

        if (isset($descriptions[$descriptionIndex])) {
            // re-indexing
            unset($descriptions[$descriptionIndex]);
            $descriptions = array_values($descriptions);

            $employee->update(['description' => json_encode($descriptions)]);

            return redirect()->back()->with('success', 'Section deleted successfully.');
        }

        return redirect()->back()->with('error', 'Section not found.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {

        $employee->delete();

        return redirect()->route('employees.index');
    }
}
