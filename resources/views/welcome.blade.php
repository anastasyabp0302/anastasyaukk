@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap');

    body {
        margin: 0;
        padding: 0;
        background-color: #fdf6f0;
        font-family: 'Quicksand', sans-serif;
        overflow-x: hidden;
    }

    .gallery-bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        background: linear-gradient(145deg, #ffe4ec, #f0f8ff);
        background-size: cover;
        opacity: 0.6;
        animation: bgFloat 10s ease-in-out infinite;
    }

    @keyframes bgFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .welcome-box {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 2rem;
    }

    .welcome-content {
        background: #ffffffdd;
        padding: 2rem 2.5rem;
        border-radius: 25px;
        box-shadow: 0 10px 40px rgba(255, 182, 193, 0.4);
        animation: fadeIn 1.2s ease-in-out;
        max-width: 800px; /* Menyesuaikan lebar konten */
        width: 100%;
        border: 2px dashed #ffc0cb;
        position: relative;
    }

    .welcome-content::before {
        position: absolute;
        top: -15px;
        left: -15px;
        font-size: 2rem;
    }

    .welcome-content::after {
        position: absolute;
        bottom: -15px;
        right: -15px;
        font-size: 2rem;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    h1 {
        font-size: 2.2rem;  
        font-weight: 700;
        color: #ff69b4;
        margin-bottom: 1rem;
        width: 100%; 
        text-align: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    p {
        font-size: 1.2rem;
        color: #6b7280;
        margin-bottom: 2rem;
    }

    .btn-custom {
        padding: 0.75rem 1.6rem;
        font-size: 1rem;
        border-radius: 15px;
        margin: 0.5rem;
        transition: all 0.3s ease-in-out;
        display: inline-block;
        border: none;
        cursor: pointer;
        font-weight: 600;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .btn-login {
        background-color: #ff90b3;
        color: white;
    }

    .btn-login:hover {
        background-color: #ff66a6;
        transform: scale(1.05) rotate(-1deg);
        box-shadow: 0 6px 18px rgba(255, 105, 180, 0.4);
    }

    .tooltip-wrapper {
        position: relative;
        display: inline-block;
    }

    .tooltip-text {
        visibility: hidden;
        background-color: #fff0f5;
        color: #ff69b4;
        text-align: center;
        border-radius: 10px;
        padding: 8px 12px;
        position: absolute;
        z-index: 10;
        bottom: 120%;
        left: 50%;
        transform: translateX(-50%);
        opacity: 0;
        white-space: nowrap;
        font-size: 0.85rem;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: opacity 0.3s ease;
    }

    .tooltip-wrapper:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
    }

    @media (max-width: 768px) {
        .welcome-content {
            padding: 2rem;
        }
    }

    .photo-preview-container {
        margin-top: 2rem; 
    }

    .preview-title {
        font-size: 1.5rem;
        color: #ff69b4;
        font-weight: bold;
        margin-bottom: 1rem;
        text-align: center;
    }

    .photo-gallery {
        column-count: 3;
        column-gap: 1rem;
        padding: 1rem;
    }

    .photo-card {
        background: #fff0f6;
        margin-bottom: 1rem;
        display: inline-block;
        width: 100%;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: transform 0.2s ease;
    }

    .photo-card:hover {
        transform: scale(1.02);
    }

    .photo-card img {
        width: 100%;
        display: block;
        border-bottom: 1px solid #fbcfe8;
    }

    .photo-author {
        padding: 0.7rem 1rem;
        font-weight: bold;
        font-size: 0.95rem;
        text-align: center;
        color: #be185d;
    }

    @media (max-width: 1024px) {
        .photo-gallery {
            column-count: 2;
        }
    }

    @media (max-width: 640px) {
        .photo-gallery {
            column-count: 1;
        }
    }
</style>


<div class="gallery-bg"></div>

<div class="welcome-box">
    <div class="welcome-content">
        <h1> Selamat Datang di Galeri Foto </h1>
        <p> Temukan momen terbaik & abadikan kenanganmu dengan gaya lucu~ </p>

        <div class="tooltip-wrapper">
            <a href="{{ route('login') }}" class="btn-custom btn-login">Login ke Galery</a>
            <span class="tooltip-text">Yuk gabung & unggah kenanganmu</span>
        </div>

        <a href="#photo-preview" class="btn-custom btn-user"> Lihat Preview</a>
    </div>
</div>

<div id="photo-preview" class="photo-preview-container">
    <h2 class="preview-title"> Jelajahi Foto Terbaru!</h2>

    <div class="photo-gallery">
        @foreach ($photos->take(6) as $photo)
            <div class="photo-card">
                <img src="{{ asset('storage/' . $photo->image_path) }}" alt="{{ $photo->title }}">
                <div class="photo-author"> {{ $photo->user->name }}</div>
            </div>
        @endforeach
    </div>
</div>

@endsection
