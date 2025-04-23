<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Photo;
use App\Models\Like;
use App\Models\Comment;

class PhotoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
{
    $query = Photo::query();
    
    if ($request->has('category')) {
        $query->where('category', $request->category);
    }

    if ($request->has('q')) {
        $query->where('title', 'like', '%' . $request->q . '%');
    }

    $photos = $query->with('user')->latest()->get();

    
    $categories = Photo::select('category')->distinct()->pluck('category')->toArray();
    

    if (empty($categories)) {
        $categories = ['default']; 
    }

    return view('index', compact('photos', 'categories'));
}


public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category' => 'required|string|max:100',
        'image' => 'required|image|mimes:jpg,jpeg,png|max:5120', 
    ]);

    $path = $request->file('image')->store('photos', 'public');

    Photo::create([
        'title' => $request->title,
        'description' => $request->description,
        'image_path' => $path,
        'category' => $request->category,
        'user_id' => auth()->id(), 
    ]);

    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard')->with('success', 'Foto berhasil diunggah');
    } else {
        return redirect()->route('profile')->with('success', 'Foto berhasil diunggah');
    }
}


public function show($id)
{
    $photo = Photo::with(['comments.user', 'likes'])->findOrFail($id);
    $categories = ['alam', 'manusia', 'hewan', 'teknologi', 'makanan'];

    return view('show', compact('photo', 'categories'));
}



public function edit($id)
{
    $photo = Photo::findOrFail($id);
    if ($photo->user_id !== auth()->id() && !auth()->user()->is_admin) {
        return redirect()->route('photos.index')->with('error', 'Anda tidak punya izin untuk mengedit foto ini.');
    }

    $categories = Photo::select('category')->distinct()->pluck('category')->toArray();

    return view('edit', compact('photo', 'categories'));
}


public function update(Request $request, Photo $photo)
{
    if (!Auth::user()->is_admin && $photo->user_id !== Auth::id()) {
        return redirect()->route('photos.index')->with('error', 'Anda tidak memiliki izin untuk memperbarui foto ini.');
    }

    $validated = $request->validate([
        'title' => 'required|max:255',
        'description' => 'nullable|max:1000',
        'category' => 'required|string|max:100',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($request->hasFile('image')) {
        if ($photo->image_path) {
            Storage::delete('public/' . $photo->image_path);
        }

        $validated['image_path'] = $request->file('image')->store('photos', 'public');
    }

    $photo->update($validated);

    return redirect()->route('profile')->with('success', 'Foto berhasil diperbarui!');
}
   


public function create()
{
    $categories = ['manusia', 'makanan', 'hewan', 'pemandangan', 'kecantikan', 'random'];
    return view('create', compact('categories'));
}


public function like($id)
{
    $photo = Photo::findOrFail($id);
    $like = $photo->likes()->where('user_id', auth()->id())->first();

    if ($like) {
        $like->delete();
    } else {
        $photo->likes()->create(['user_id' => auth()->id()]);
    }

    return back();
}


public function addComment(Request $request, $photoId)
{
    $request->validate([
        'comment' => 'required|string|max:255',
    ]);

    $photo = Photo::findOrFail($photoId);

    $comment = $photo->comments()->create([
        'user_id' => Auth::id(),
        'comment' => $request->comment,
    ]);

    if ($request->ajax()) {
        return response()->json([
            'user' => $comment->user->name,
            'comment' => $comment->comment,
            'created_at' => $comment->created_at->diffForHumans(),
        ]);
    }

    return back()->with('success', 'Komentar ditambahkan!');
}


public function search(Request $request)
{
    $queryBuilder = Photo::query();

    if ($request->has('category')) {
        $queryBuilder->where('category', $request->category);
    }

    if ($request->has('q')) {
        $queryBuilder->where('title', 'like', '%' . $request->q . '%');
    }

    $photos = $queryBuilder->latest()->get();
    $categories = Photo::select('category')->distinct()->pluck('category');

    return view('index', compact('photos', 'categories'));
}



public function destroy($id)
{
    $photo = Photo::findOrFail($id);

    if ($photo->user_id !== auth()->id() && !auth()->user()->is_admin) {
        return redirect()->route('photos.index')->with('error', 'Anda tidak punya izin untuk menghapus foto ini.');
    }

    $photo->delete();
    
    return redirect()->route('profile')->with('success', 'Foto berhasil dihapus.');
}


public function welcome()
{
    $photos = Photo::with('user')->latest()->get();
    return view('welcome', compact('photos'));
}
}   
