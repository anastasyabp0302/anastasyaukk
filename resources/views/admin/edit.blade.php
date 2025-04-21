@extends('layouts.app')

@section('content')

<!-- Navbar Admin -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Dashboard Admin</a>
        <form action="{{ route('logout') }}" method="POST" class="d-flex ms-auto">
            @csrf
            <button class="btn btn-danger" type="submit">Logout</button>
        </form>
    </div>
</nav>

<div class="container mt-4">
    <h3 class="mb-4 fw-bold">Edit Foto</h3>

    <form action="{{ route('photos.update', $photo->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Judul Foto</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $photo->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" id="description" rows="4" class="form-control">{{ old('description', $photo->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Ganti Gambar (Opsional)</label>
            <input type="file" name="image" id="image" class="form-control">
            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti gambar.</small>
        </div>

        <div class="mb-3">
            <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Preview" class="img-fluid rounded" style="max-height: 300px;">
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

@endsection
