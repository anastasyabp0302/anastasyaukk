<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Comment;
use App\Models\User;

class AdminPhotoController extends Controller
{
    public function edit($id)
    {
        $photo = Photo::findOrFail($id);
        return view('admin.edit', compact('photo'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'category' => 'nullable|string',
        ]);

        // Cari foto yang ingin diedit
        $photo = Photo::findOrFail($id);

        // Update judul dan deskripsi
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

        // Redirect ke halaman dashboard atau daftar foto
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
        $photo = Photo::with(['likes.user'])->findOrFail($id);
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
        return view('admin.users', compact('users'));
    }



}
