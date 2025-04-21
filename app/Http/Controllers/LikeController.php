<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Photo;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store($photoId)
    {
        $photo = Photo::findOrFail($photoId);

        if ($photo->likes()->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'Anda sudah menyukai foto ini.');
        }

        Like::create([
            'photo_id' => $photoId,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Anda menyukai foto ini.');
    }

    public function destroy($photoId)
    {
        $like = Like::where('photo_id', $photoId)->where('user_id', Auth::id())->first();

        if ($like) {
            $like->delete();
            return back()->with('success', 'Anda telah membatalkan like.');
        }

        return back()->with('error', 'Anda belum menyukai foto ini.');
    }
}

