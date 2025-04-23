@extends('layouts.app')

@section('content')

<nav class="navbar navbar-expand-lg" style="background-color: #fff0f6; box-shadow: 0 2px 10px rgba(0,0,0,0.06);">
    <div class="container py-2">
        <a class="navbar-brand fw-bold" href="#" style="color: #f472b6;">📊 Dashboard Admin</a>

        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle fs-5 me-1" style="color: #c084fc;"></i> 
                        <span style="color: #c084fc;">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('admin.user') }}">Daftar Akun</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger" type="submit">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h3 class="mb-3 fw-bold">📸 Semua Foto</h3>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="masonry">
        @foreach ($photos as $photo)
            <div class="photo-card position-relative">
                <a href="{{ route('admin.photos.show', $photo->id) }}">
                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="{{ $photo->title }}">
                </a>

                <div class="p-2 d-flex justify-content-between align-items-center bg-white">
                    <div>
                        ❤️ {{ $photo->likes->count() }} 
                        💬 {{ $photo->comments->count() }}
                    </div>

                    <div class="dropdown">
                        <button class="btn btn-sm btn-light border rounded-pill dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            ⋮
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item text-warning" href="{{ route('admin.edit', $photo->id) }}">✏️ Edit</a>
                            </li>
                            <li>
                                <form action="{{ route('photos.destroy', $photo->id) }}" method="POST" onsubmit="return confirm('Yakin hapus foto ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="dropdown-item text-danger" type="submit">🗑️ Hapus</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<a href="{{ route('photos.create') }}" class="btn btn-primary rounded-circle p-3 shadow-lg" 
    style="position: fixed; bottom: 20px; right: 20px; width: 70px; height: 70px; 
           display: flex; justify-content: center; align-items: center;
           background-color: #f472b6; border: none;">
    <i class="fa-solid fa-plus" style="font-size: 35px; color: white;"></i>
</a>

<style>
    .masonry {
        column-count: 3;
        column-gap: 1rem;
    }

    @media (max-width: 992px) {
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
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 1rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        background-color: white;
        transition: transform 0.2s ease;
    }

    .photo-card:hover {
        transform: scale(1.01);
    }

    .dropdown-menu {
        min-width: 150px;
    }
</style>

@endsection
