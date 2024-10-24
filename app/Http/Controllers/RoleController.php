<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function create()
    {
        return view('admin.Roles.create');
    }


    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);


        Role::create([
            'name' => $request->name,
        ]);

        return redirect()->route('employees.create');
    }
}
