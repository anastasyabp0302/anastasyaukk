@extends('layouts.app')

@section('content')

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Dashboard Admin</a>
        <form action="{{ route('logout') }}" method="POST" class="d-flex ms-auto">
            @csrf
            <button class="btn btn-danger" type="submit">Logout</button>
        </form>
    </div>
</nav>

<div class="container mt-5">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary mb-4">
        ← Kembali ke Dashboard
    </a>

    <div class="row">
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm border-0">
                <img src="{{ asset('storage/' . $photo->image_path) }}" class="card-img-top rounded" alt="{{ $photo->title }}">
                <div class="card-body">
                    <h4 class="fw-bold">{{ $photo->title }}</h4>
                    <p class="text-muted mb-1"><strong>Kategori:</strong> {{ $photo->kategori ?? '-' }}</p>
                    <p>{{ $photo->description }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-white fw-bold">
                    ❤️ Disukai oleh ({{ $photo->likes->count() }})
                </div>
                <ul class="list-group list-group-flush">
                    @forelse ($photo->likes as $like)
                        <li class="list-group-item">{{ $like->user->name }}</li>
                    @empty
                        <li class="list-group-item text-muted">Belum ada yang menyukai</li>
                    @endforelse
                </ul>
            </div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-bold">
        💬 Komentar ({{ $photo->comments->count() }})
    </div>
    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
        @forelse ($comments as $comment)
            <div class="mb-4 p-3 rounded border bg-light">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <strong>{{ $comment->user->name }}</strong>
                        <small class="text-muted d-block">{{ $comment->created_at->diffForHumans() }}</small>
                    </div>
                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">🗑</button>
                    </form>
                </div>
                <p class="mt-2 mb-1">{{ $comment->comment }}</p>

                <form action="{{ route('comments.reply', $comment->id) }}" method="POST" class="mt-2">
                    @csrf
                    <div class="input-group input-group-sm">
                        <input type="text" name="reply" class="form-control" placeholder="Balas komentar..." required>
                        <button type="submit" class="btn btn-outline-primary">↩️</button>
                    </div>
                </form>

                @foreach ($comment->replies as $reply)
                    <div class="mt-3 ms-4 p-2 border-start border-2">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong>{{ $reply->user->name }}</strong>
                                <small class="text-muted d-block">{{ $reply->created_at->diffForHumans() }}</small>
                            </div>
                            <form action="{{ route('comments.destroy', $reply->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">🗑</button>
                            </form>
                        </div>
                        <p class="mt-1 mb-0">{{ $reply->comment }}</p>
                    </div>
                @endforeach
            </div>
        @empty
            <p class="text-muted">Belum ada komentar</p>
        @endforelse
    </div>
</div>


        </div>
    </div>
</div>

@endsection
