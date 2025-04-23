<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $photos = Photo::with(['likes', 'comments'])->latest()->get();
        return view('admin.dashboard', compact('photos'));
    }
    
}

