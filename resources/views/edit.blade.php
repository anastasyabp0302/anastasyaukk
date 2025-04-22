@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Edit Foto</h2>

    <form action="{{ $formAction ?? route('photos.update', $photo->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Label</label>
            <input type="text" class="form-control" name="title" value="{{ old('title', $photo->title)}}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" name="description">{{ old('description', $photo->description) }}</textarea>
        </div>

        @if(isset($categories) && count($categories))
            <div class="mb-3">
                <label for="category" class="form-label">Kategori</label>
                <select name="category" class="form-select">
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ $photo->category == $category ? 'selected' : '' }}>
                            {{ ucfirst($category) }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        <div class="mb-3">
            <label for="image" class="form-label">Ganti Gambar (Opsional)</label>
            <input class="form-control" type="file" name="image">
            <img src="{{ asset('storage/' . $photo->image_path) }}" class="mt-2" width="200">
        </div>

        <button type="submit" class="btn btn-primary">Update Foto</button>
    </form>
</div>
@endsection
