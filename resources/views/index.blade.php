@extends('layouts.app')

@section('content')

<style>
    .masonry {
        column-count: 3;
        column-gap: 1rem;
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

    .photo-card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    }

    .photo-card img {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.3s ease;
    }

    .photo-card:hover img {
        transform: scale(1.03);
    }

    .overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.6);
        color: white;
        padding: 10px;
        text-align: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .photo-card:hover .overlay {
        opacity: 1;
    }

    .overlay h5 {
        margin: 0;
        font-weight: 600;
        font-size: 1rem;
    }

    .navbar-brand:hover {
        color: #ec4899 !important;
    }

    .dropdown-menu {
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    input::placeholder {
        color: #b28ddb;
        font-style: italic;
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

                <li class="nav-item dropdown me-3">
                    <a class="nav-link dropdown-toggle" href="#" style="color: #c084fc;" data-bs-toggle="dropdown">Kategori</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('photos.index') }}">Semua</a></li>
                        @foreach ($categories as $kategori)
                            <li>
                                <a class="dropdown-item {{ request('category') == $kategori ? 'active' : '' }}" 
                                   href="{{ route('photos.index', ['category' => $kategori]) }}">
                                    {{ ucfirst($kategori) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

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


<div class="container mt-4 mb-3">
    <form class="d-flex justify-content-center" action="{{ route('photos.search') }}" method="GET">
        <div class="input-group w-50 shadow-sm">
            <input type="search" name="q" value="{{ request('q') }}" class="form-control rounded-start-pill px-4" placeholder="Cari foto lucu...">
            <input type="hidden" name="category" value="{{ request('category') }}">
            <button class="btn px-4 rounded-end-pill text-white" style="background-color: #c084fc;" type="submit">Cari 💫</button>
        </div>
    </form>
</div>


<div class="container mt-4">
   

<div class="masonry">
    @foreach ($photos as $photo)
        <div class="photo-card">
            <a href="{{ route('photos.show', $photo->id) }}">
                <img src="{{ asset('storage/' . $photo->image_path) }}" alt="{{ $photo->title }}">
                <div class="overlay">
                    <h5>{{ $photo->title }}</h5>
                    <small>Diunggah oleh: {{ $photo->user->name }}</small>
                </div>
            </a>
        </div>
    @endforeach
</div>

</div>

@endsection
