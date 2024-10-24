<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class BlogController extends Controller
{

    // Users
    public function userIndex()
    {
        $blogs = Blog::with(['user', 'comments.replies'])->orderByDesc('is_featured')->get();
        return view('blogs.index', ['blogs' => $blogs]);
    }

    public function userShow(Blog $blog)
    {
        $blog->load([
            'user' => function ($query) {
                $query->withTrashed(); // Include soft-deleted users
            },
            'likes',
            'comments' => function ($query) {
                $query->withTrashed()->with('replies');
            }
        ]);

        $sections = json_decode($blog->sections, true);

        return view('blogs.show', ['blog' => $blog, 'sections' => $sections]);
    }


    // Admin Panel

    /**
     * Display a listing of the resource. 
     */
    public function index()
    {
        $blogs = Blog::with(['user', 'comments.replies'])->get();
        return view('admin.blogs.index', ['blogs' => $blogs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $blogs = Blog::all();
        return view('admin.blogs.create', compact('blogs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $blogAttributes = $request->validate([
            'photo_path' => ['required', 'image', File::types(['jpg', 'jpeg', 'png', 'webp'])],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required'],
            'sections' => ['required', 'array'],
            'sections.*.section_title' => ['required', 'string', 'max:255'],
            'sections.*.section_body' => ['required'],
            'is_featured' => ['boolean'],
        ]);

        $photoPath = $request->photo_path->store('blogs', 'public');

        $blog = Blog::create([
            'photo_path' => $photoPath,
            'title' => $blogAttributes['title'],
            'description' => $blogAttributes['description'],
            'sections' => json_encode($blogAttributes['sections']),
            'is_featured' => $blogAttributes['is_featured'] ?? false,
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('blogs.index')->with('success', 'Успешно напишан блог.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        $blog->load(['user', 'likes', 'comments' => function ($query) {
            $query->withTrashed()->with('replies');
        }]);
        $sections = json_decode($blog->sections, true);
        $relatedBlogs = $blog->relatedBlogs();

        return view('admin.blogs.show', ['blog' => $blog, 'sections' => $sections, 'relatedBlogs' => $relatedBlogs]);
    }

    // /**
    //  * Show the form for editing the specified resource. ( Not In Use )
    //  */ 
    // public function edit(Blog $blog)
    // {
    //     $blogs = Blog::all();
    //     $sections = json_decode($blog->sections, true);

    //     return view('admin.blogs.edit', ['blog' => $blog, 'blogs' => $blogs, 'sections' => $sections]);
    // }


    public function like(Blog $blog)
    {
        $user = Auth::user();

        if ($blog->likes()->where('user_id', $user->id)->exists()) {
            $blog->likes()->where('user_id', $user->id)->delete();
            $liked = false;
        } else {
            $blog->likes()->create([
                'user_id' => $user->id,
            ]);
            $liked = true;
        }

        return response()->json([
            'likesCount' => $blog->likes->count(),
            'liked' => $liked
        ]);
    }

    /**
     * Update the image in storage.
     */
    public function updateImage(Request $request, Blog $blog)
    {
        $request->validate([
            'photo_path' => ['required', 'image', File::types(['jpg', 'jpeg', 'png', 'webp'])],
        ]);

        $photoPath = $request->photo_path->store('blogs', 'public');

        if ($blog->photo_path) {
            Storage::disk('public')->delete($blog->photo_path);
        };

        $blog->update([
            'photo_path' => $photoPath,
        ]);

        return redirect()->back();
    }

    /**
     * Update the main info in storage.
     */
    public function updateInfo(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required'],
        ]);

        $blog->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->back();
    }

    /**
     * Update the sections in storage.
     */
    public function updateSections(Request $request, Blog $blog)
    {
        $request->validate([
            'sections' => ['required', 'array'],
            'sections.*.section_title' => ['required', 'string', 'max:255'],
            'sections.*.section_body' => ['required'],
        ]);

        $blog->update([
            'sections' => json_encode($request->sections),
        ]);

        return redirect()->back();
    }

    /**
     * Set the blog as featured.
     */
    public function featured(Blog $blog)
    {
        Blog::where('id', '!=', $blog->id)->update(['is_featured' => false]);

        $blog->update([
            'is_featured' => true,
        ]);

        return redirect()->back();
    }

    /**
     * Remove image from storage.
     */
    public function deleteImage(Blog $blog)
    {
        if ($blog->photo_path) {
            Storage::disk('public')->delete($blog->photo_path);

            $blog->update(['photo_path' => null]);

            return redirect()->back();
        };

        return redirect()->back()->with('error', 'No image to delete.');
    }

    /**
     * Remove a section from storage.
     */
    public function deleteSection(Blog $blog, $sectionIndex)
    {
        $sections = json_decode($blog->sections, true);

        if (isset($sections[$sectionIndex])) {
            // re-indexing
            unset($sections[$sectionIndex]);
            $sections = array_values($sections);

            if (count($sections) > 0) {
                $blog->update(['sections' => json_encode($sections)]);
            } else {
                $blog->update(['sections' => json_encode([])]);
            }

            return redirect()->back()->with('success', 'Section deleted successfully.');
        }

        return redirect()->back()->with('error', 'Section not found.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog = Blog::find($blog->id);

        if ($blog->photo_path) {
            Storage::delete($blog->photo_path);
        }

        $blog->delete();

        return redirect()->route('blogs.index');
    }
}
