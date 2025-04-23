@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #fdf6f9; 
        font-family: 'Poppins', sans-serif;
    }

    h3 {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        color: #a78bfa; 
    }

    .table-responsive {
        background-color: #fffafc;
        padding: 1rem;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .table thead {
        background-color: #fce7f3;
        color: #a855f7;
        font-weight: bold;
    }

    .table td,
    .table th {
        font-size: 14px;
        color: #6b21a8;
        background-color: #fff0f6;
    }

    .btn-cute {
        background-color: #f9a8d4; 
        border: none;
        padding: 0.5rem 1.2rem;
        border-radius: 20px;
        font-weight: bold;
        transition: background-color 0.3s ease, transform 0.2s ease;
        box-shadow: 0 4px 10px rgba(236, 72, 153, 0.2);
        font-family: 'Poppins', sans-serif;
    }

    .btn-cute:hover {
        background-color: #f472b6;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(236, 72, 153, 0.3);
    }

    .back-link {
        margin-top: 1rem;
        display: inline-block;
        text-decoration: none;
        color: #9333ea;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .back-link:hover {
        color: #7c3aed;
        text-decoration: underline;
    }
</style>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">📋 Daftar Akun yang Pernah Login</h3>
        <div class="text-center mt-4">
            <a href="{{ route('admin.dashboard') }}" class="btn-cute">← Kembali ke Dashboard</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered shadow-sm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Terdaftar sejak</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('D M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Belum ada akun</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
