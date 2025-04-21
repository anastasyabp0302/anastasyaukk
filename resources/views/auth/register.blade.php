@extends('layouts.app')

@section('content')
<style>
    html, body {
        height: 100%;
        margin: 0;
        background-color: #fef4f8;
        font-family: 'Quicksand', sans-serif;
    }

    .register-wrapper {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #fef4f8;
    }

    .register-card {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 20px;
        border: 2px dashed #e0b3dd;
        box-shadow: 0 10px 20px rgba(224, 179, 221, 0.2);
        width: 400px;
    }

    .register-card h3 {
        text-align: center;
        color: #d85fa5;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .register-card label {
        color: #a64d79;
        font-weight: 600;
    }

    .form-control {
        border-radius: 12px;
        margin-bottom: 15px;
        background-color: #f9f9f9;
        border: 1px solid #e0d4e5;
    }

    .btn-register {
        background-color: #d85fa5;
        color: white;
        border-radius: 12px;
        font-weight: 600;
        box-shadow: 0 4px 8px rgba(216, 95, 165, 0.3);
    }

    .btn-register:hover {
        background-color: #bf4d91;
    }

    .text-center a {
        color: #a64d79;
        font-weight: bold;
    }
</style>

<div class="register-wrapper">
    <div class="register-card">
        <h3> Daftar ke Galeri </h3>
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label> Nama</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label> Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label> Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label> Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button class="btn btn-register w-100"> Daftar Sekarang</button>
        </form>
        <div class="text-center mt-3">
            Udah punya akun? <a href="{{ route('login') }}">Login Yuk </a>
        </div>
    </div>
</div>
@endsection
