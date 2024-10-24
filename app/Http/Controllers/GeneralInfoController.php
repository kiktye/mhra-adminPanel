<?php

namespace App\Http\Controllers;

use App\Models\GeneralInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class GeneralInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function show()
    {

        $generalInfo = GeneralInfo::first();
        $socialLinks = json_decode($generalInfo->social_links, true);

        return view('admin.general_info.show', ['generalInfo' => $generalInfo, 'socialLinks' => $socialLinks]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GeneralInfo $generalInfo)
    {

        $infoAttributes = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['required', 'string', 'max:255'],
            'photo_path' => ['required', 'image', File::types(['jpg', 'jpeg', 'png', 'webp'])],
            'social_links' => ['required', 'array'],
            'social_links.*.platform' => ['required', 'string'],
            'social_links.*.link' => ['required', 'string'],
        ]);


        $photoPath = $request->photo_path->store('homepage', 'public');


        $generalInfo->update([
            'title' => $infoAttributes['title'],
            'subtitle' => $infoAttributes['subtitle'],
            'photo_path' => $photoPath,
            'social_links' => json_encode($infoAttributes['social_links']),
        ]);

        return redirect()->back();
    }

    /**
     * Update title and subtitle in storage.
     */
    public function updateInfo(Request $request, GeneralInfo $generalInfo)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['required', 'string', 'max:255'],
        ]);

        $generalInfo->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
        ]);

        return redirect()->back();
    }

    /**
     * Update social links in storage.
     */
    public function updateLinks(Request $request, GeneralInfo $generalInfo)
    {
        $infoAttributes = $request->validate([
            'social_links' => ['required', 'array'],
            'social_links.*.platform' => ['required', 'string'],
            'social_links.*.link' => ['required', 'string'],
        ]);


        $generalInfo->update([
            'social_links' => json_encode($infoAttributes['social_links']),
        ]);

        return redirect()->back();
    }

    /**
     * Update the image in storage.
     */
    public function updateImage(Request $request, GeneralInfo $generalInfo)
    {
        $request->validate([
            'photo_path' => ['required', 'image', File::types(['jpg', 'jpeg', 'png', 'webp'])],
        ]);

        $photoPath = $request->photo_path->store('homepage', 'public');

        if ($generalInfo->photo_path) {
            Storage::disk('public')->delete($generalInfo->photo_path);
        };

        $generalInfo->update([
            'photo_path' => $photoPath,
        ]);

        return redirect()->back();
    }

    /**
     * Remove image from storage. // Not in Use
     */
    public function deleteImage(GeneralInfo $generalInfo)
    {
        if ($generalInfo->photo_path) {
            Storage::disk('public')->delete($generalInfo->photo_path);

            $generalInfo->update(['photo_path' => null]);

            return redirect()->back();
        };

        return redirect()->back()->with('error', 'No image to delete.');
    }
}
