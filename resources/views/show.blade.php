@extends('layouts.app')

@section('title', $photo->title)
<style>
    .card {
        border-radius: 15px;
        border: 1px solid #eaeaea;
    }

    #commentList li {
        font-size: 0.95rem;
    }

    .btn-link.text-danger {
        font-size: 0.85rem;
        text-decoration: none
    }

    .btn-link.text-danger:hover {
        text-decoration: underline;
    }
    </style>

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

            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title">Komentar ({{ $photo->comments->count() }})</h5>

    <ul class="list-unstyled" id="commentList">
        @foreach($photo->comments as $comment)
             <li class="mb-3 d-flex justify-content-between align-items-start border-bottom pb-2">
                <div>
                <span><strong>{{ $comment->user->name }}</strong> {{ $comment->comment }}</span><br>
                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}<small>
                </div>

                @if (auth()->check() && auth()->id() === $comment->user_id)
                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-link text-danger p-0 ms-2">Hapus</button>
                </form>
                @endif
            </li>
        @endforeach
    </ul>

    <form id="commentForm" action="{{ route('photos.comment', $photo->id) }}" method="POST">
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