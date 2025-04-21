@extends('layouts.app')

@section('content')
<style>
    html, body {
        height: 100%;
        margin: 0;
        background-color: #fef4f8; 
        font-family: 'Quicksand', sans-serif;
    }

    .login-wrapper {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #fef4f8;
    }

    .login-card {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 20px;
        border: 2px dashed #e0b3dd; 
        box-shadow: 0 10px 20px rgba(224, 179, 221, 0.2); 
        width: 360px;
    }

    .login-card h3 {
        text-align: center;
        color: #d85fa5; /* pink lembut */
        font-weight: bold;
        margin-bottom: 25px;
    }

    .login-card label {
        color: #a64d79; 
        font-weight: 600;
    }

    .form-control {
        border-radius: 12px;
        margin-bottom: 15px;
        background-color: #f9f9f9;
        border: 1px solid #e0d4e5;
    }

    .btn-login {
        background-color: #d85fa5;
        color: white;
        border-radius: 12px;
        font-weight: 600;
        box-shadow: 0 4px 8px rgba(216, 95, 165, 0.3);
    }

    .btn-login:hover {
        background-color: #bf4d91;
    }

    .text-center a {
        color: #a64d79;
        font-weight: bold;
    }
</style>


<div class="login-wrapper">
    <div class="login-card">
        <h3> Login ke Galeri</h3>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-2">
                <label for="email"> Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-2">
                <label for="password"> Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-login w-100 mb-2"> Login Sekarang</button>
        </form>

        @if ($errors->any())
            <div class="alert alert-danger mt-2" style="border-radius: 10px;">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="text-center mt-3" style="color: #555;">
            Belum punya akun? <a href="{{ route('register') }}">Daftar Yuk </a>
        </div>
    </div>
</div>
@endsection
