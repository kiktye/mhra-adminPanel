<?php

namespace App\Http\Controllers;

use App\Models\Recommendation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users =  User::withTrashed()->get();

        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show($id)
    {
        $user = User::withTrashed()
            ->with(['likedBlogs', 'likedComments', 'comments', 'comments.replies', 'blogs', 'connections', 'receivedRecommendations', 'sentRecommendations'])
            ->findOrFail($id);

        return view('admin.users.show', ['user' => $user]);
    }


    // Friends
    public function sendFriendRequest(User $user, User $connectedUser)
    {
        $user->connections()->attach($connectedUser->id, ['status' => 'pending']);

        $connectedUser->connections()->attach($user->id, ['status' => 'pending']);

        return redirect()->back()->with('success', 'Понудата за пријателство е испратена');
    }

    public function acceptFriendRequest(User $user, User $connectedUser)
    {

        $user->connections()->updateExistingPivot($connectedUser->id, ['status' => 'accepted']);
        $connectedUser->connections()->updateExistingPivot($user->id, ['status' => 'accepted']);

        return redirect()->back()->with('success', 'Понудата за пријателство е прифатена.');
    }

    public function removeFriend(User $user, User $connectedUser)
    {
        $user->connections()->detach($connectedUser->id);
        return redirect()->back()->with('success', 'Пријателството е избришано.');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $userAttributes = $request->validate([
            'name' => ['required'],
            'surname' => ['required'],
            'email' => ['required', 'email'],
            'phone' => ['required'],
            'city' => ['required'],
            'country' => ['required'],
            'title' => ['required'],
            'bio' => ['required'],
        ]);

        $user->update($userAttributes);

        return redirect()->route('users.index')->with('success', 'Измените се зачувани.');
    }

    /**
     * Update the image in storage.
     */
    public function updateImage(Request $request, User $user)
    {
        $request->validate([
            'photo_path' => ['required', 'image', File::types(['jpg', 'jpeg', 'png', 'webp'])],
        ]);

        $photoPath = $request->photo_path->store('users', 'public');

        if ($user->photo_path) {
            Storage::disk('public')->delete($user->photo_path);
        };

        $user->update([
            'photo_path' => $photoPath,
        ]);

        return redirect()->back();
    }

    /**
     * Update credentials in storage.
     */
    public function updateCredentials(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required'],
        ]);

        $user->update([
            'name' => $request->name,
            'surname' => $request->surname,
        ]);

        return redirect()->back();
    }

    /**
     * Update info in storage.
     */
    public function updateInfo(Request $request, User $user)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'phone' => ['required'],
            'title' => ['required', 'string', 'max:255'],
        ]);

        $user->update([
            'email' => $request->email,
            'phone' => $request->phone,
            'title' => $request->title,
        ]);

        return redirect()->back();
    }

    /**
     * Update bio in storage.
     */
    public function updateBio(Request $request, User $user)
    {
        $request->validate([
            'bio' => ['required'],
        ]);

        $user->update([
            'bio' => $request->bio,
        ]);

        return redirect()->back();
    }

    /**
     * Remove image from storage.
     */
    public function deleteImage(User $user)
    {
        if ($user->photo_path) {
            Storage::disk('public')->delete($user->photo_path);

            $user->update(['photo_path' => null]);

            return redirect()->back();
        };

        return redirect()->back()->with('error', 'No image to delete.');
    }

    /**
     * Remove CV from storage.
     */
    public function deleteCV(User $user)
    {
        if ($user->cv_path) {
            Storage::disk('public')->delete($user->cv_path);

            $user->update(['cv_path' => null]);

            return redirect()->back();
        };

        return redirect()->back()->with('error', 'No image to delete.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->forceDelete();

        return redirect()->route('users.index')->with('success', 'Корсникот е избришан.');
    }

    // ban/unban
    public function restrict(User $user)
    {

        $user->update(['restricted' => true]);

        return redirect()->back();
    }

    public function restore(User $user)
    {

        $user->update(['restricted' => false]);

        return redirect()->back();
    }
}
