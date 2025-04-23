@extends('layouts.app')

@section('content')

<style>
    .profile-card {
        background-color: #fff0f6;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .upload-btn {
        background-color: #f472b6;
        color: white;
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: 30px;
        font-weight: bold;
        transition: background-color 0.3s ease;
        text-decoration: none;
    }

    .upload-btn:hover {
        background-color: #ec4899;
    }

    .masonry {
        column-count: 3;
        column-gap: 1rem;
        margin-top: 2rem;
    }

    @media (max-width: 768px) {
        .masonry {
            column-count: 2;
        }
    }

    @media (max-width: 576px) {
        .masonry {
            column-count: 1;
        }
    }

    .photo-card {
        break-inside: avoid;
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 1rem;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }

    .photo-card img {
        width: 100%;
        height: auto;
        display: block;
    }

    .photo-card .btn {
        font-size: 0.8rem;
        padding: 0.3rem 0.8rem;
    }

    .photo-actions {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 10;
    }

    .btn-custom {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        border-radius: 20px;
        background-color: #f472b6;
        color: white;
        border: none;
        margin: 0.5rem 0;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-custom:hover {
        background-color: #ec4899;
    }

    .btn-delete {
        background-color: #f87171;
    }

    .btn-delete:hover {
        background-color: #f87171;
    }
</style>

<nav class="navbar navbar-expand-lg" style="background-color: #fff0f6; box-shadow: 0 2px 10px rgba(0,0,0,0.06);">
    <div class="container py-2">
        <a class="navbar-brand fw-bold" href="{{ route('photos.index') }}" style="color: #f472b6;">📷 Gallery</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">

                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle fs-5 me-1" style="color: #c084fc;"></i> <span style="color: #c084fc;">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('photos.index') }}">Dashboard</a></li>
                        <li><a class="dropdown-item" href="{{ route('profile') }}">Profil Saya</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger" type="submit">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
                @else
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary rounded-pill px-3">Sign In</a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

    <div class="profile-card">
        <h2 class="mb-4">👤 Profil Saya</h2>

        <p><strong>Nama:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>

        <hr class="my-4">

        <h5 class="mb-3">🎨 Aksi</h5>
        <a href="{{ route('photos.create') }}" class="upload-btn">+ Upload Foto Baru</a>
    </div>

    @if($user->photos->count())
        <h4 class="mt-5 mb-3">📸 Foto yang Kamu Upload</h4>
        <div class="masonry">
            @foreach ($user->photos as $photo)
            <div class="photo-card">
    <a href="{{ route('photos.show', $photo->id) }}">
        <img src="{{ asset('storage/' . $photo->image_path) }}" alt="{{ $photo->title }}">
    </a>

    @if ($photo->user_id == auth()->id())
        <div class="d-flex justify-content-center gap-2 p-3 bg-white">
            <a href="{{ route('photos.edit', $photo->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">✏️ Edit</a>

            <form action="{{ route('photos.destroy', $photo->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus foto ini?')" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">🗑️ Delete</button>
            </form>
        </div>
    @endif
</div>

            @endforeach
        </div>
    @else
        <p class="mt-4">Kamu belum upload foto apa pun 😔</p>
    @endif
</div>

@endsection
