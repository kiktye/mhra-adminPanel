<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userAttributes = $request->validate([
            'name' => ['required', 'string', 'max:128'],
            'surname' => ['required', 'string', 'max:128'],
            'title' => ['required', 'string', 'max:128'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required'],
            'city' => ['required'],
            'country' => ['required'],
            'bio' => ['required'],
            'photo_path' => ['required', 'image', File::types(['jpg', 'jpeg', 'png', 'webp'])],
            'cv_path' => ['required', File::types(['pdf'])],
            'password' => ['required', Password::min(6)],
            'password_confirmation' => ['required', 'same:password'],
        ]);

        $photoPath = $request->photo_path->store('users/photos', 'public');
        $cvPath = $request->cv_path->store('users/cv', 'public');


        $user = User::create([
            'name' => $userAttributes['name'],
            'surname' => $userAttributes['surname'],
            'title' => $userAttributes['title'],
            'email' => $userAttributes['email'],
            'phone' => $userAttributes['phone'],
            'city' => $userAttributes['city'],
            'country' => $userAttributes['country'],
            'bio' => $userAttributes['bio'],
            'photo_path' => $photoPath,
            'cv_path' => $cvPath,
            'password' => Hash::make($userAttributes['password']),
        ]);

        Auth::login($user);

        return redirect()->route('welcome');
    }
}
