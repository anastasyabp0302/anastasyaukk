<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $photos = auth()->user()->photos;

        return view('index', compact('photos'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('user.profile', compact('user'));
    }

    public function dashboard()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Kamu harus login.');
        }

        $photos = $user->photos;

        return view('user.profile', compact('user', 'photos'));
    }

    public function edit($id)
    {
        $photo = Photo::findOrFail($id);
        $categories = Category::all();

        return view('photos.edit', compact('photo', 'categories'));
    }
}
