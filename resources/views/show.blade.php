@extends('layouts.app')

@section('title', $photo->title)

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('photos.index') }}" class="btn btn-secondary"> Kembali</a>
    </div>

    <div class="row">
        <div class="col-md-7 text-center">
            <img src="{{ asset('storage/' . $photo->image_path) }}" alt="{{ $photo->title}}" class="img-fluid rounded shadow">
        </div>

        <div class="col-md-5">
            <h2>{{ $photo->title }}</h2>
            <p class="text-muted">{{ $photo->description }}</p>

            <div class="d-flex align-items-center mb-3">
                <form action="{{ route('photos.like', $photo->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-light">
                        ❤️ {{ $photo->likes->count() }} Suka
                    </button>
                </form>
            </div>

    <h5>Komentar ({{ $photo->comments->count() }})</h5>
    <ul class="list-group mb-3" id="commentlist">
        @foreach($photo->comments as $comment)
             <li class="list-group-item">
                <strong>{{ $comment->user->name }}</strong><br>
                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}<small><br>
                {{ $comment->comment }}
            </li>
        @endforeach
    </ul>

    <form id="commentsForm" action="{{ route('photos.comment', $photo->id) }}" method="POST">
        @csrf
        <div class="input-group">
            <input type="text" id="commentInput" name="comment" class="form-controll rounded-start-pill" placeholder="Tambahkan komentar..." required>
            <button type="submit" class="btn btn-primary rounded-end-pill">Kirim</button>
        </div>
    </form>
</div>
</div>
</div>
@endsection

@section('scripts')

<script>
    document.getElementById('commentForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        let commentInput = document.getElementById('commentInput');
        let comment = commentInput.value.trim();
        if (!comment) return;

        const response = await fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ comment: comment })
        });

        const data = await response.json();

        if(data.comment) {
            const commentList = document.getElementById('commentList');
            const newItem = document.createElement('li');
            newItem.className = 'list-group-item';
            newItem.innerHTML = `<strong>${data.user}</strong><br>
                                 <small class="text-muted">${data.created_at}</small><br>
                                 ${data.comment}`;
            commentList.prepend(newItem);
            commentInput.value = '';
        }
    });
    </script>
    @endsection