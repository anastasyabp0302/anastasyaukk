<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Comment;
use App\Models\User;

class AdminPhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::with(['likes', 'comments'])->latest()->get();

        $categories = Photo::select('category')->distinct()->pluck('category')->toArray();
        if (empty($categories)) {
            $categories = ['default'];
        }
        return view('admin.dashboard', compact('photos', 'categories'));
    }
    
    public function edit($id)
    {
        $photo = Photo::findOrFail($id);
        return view('admin.edit', compact('photo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'category' => 'nullable|string',
        ]);

        $photo = Photo::findOrFail($id);

        $photo->title = $request->input('title');
        $photo->description = $request->input('description');

        
        if ($request->hasFile('image')) {
            
            if (file_exists(public_path('storage/' . $photo->image_path))) {
                unlink(public_path('storage/' . $photo->image_path));
            }

            $imagePath = $request->file('image')->store('photos', 'public');
            $photo->image_path = $imagePath;
        }

        $photo->save();

        return redirect()->route('admin.dashboard')->with('success', 'Foto berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);
        $photo->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Foto berhasil dihapus.');
    }

    public function show($id)
    {
        $photo = Photo::with(['likes.user', 'comments.user', 'comments.replies'])->findOrFail($id);
        $comments = $photo->comments()
            ->whereNull('parent_id')
            ->with('replies.user', 'user')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.show', compact('photo', 'comments'));
    }

    public function listUsers()
    {
        $users = User::all();
        return view('admin.user', compact('users'));
    }



}
