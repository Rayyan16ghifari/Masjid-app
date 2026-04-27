@extends('layouts.auth')

@section('title', 'Register - Alhasanah App')

@section('auth_heading', 'Buat akun')
@section('auth_description', 'Daftar untuk mendapatkan akses cepat dan pengalaman yang lebih personal di Alhasanah App.')

@section('content')
<div class="auth-form-icon" aria-hidden="true">
    <i class="fas fa-user-plus"></i>
</div>
<h2>Register</h2>
<p class="auth-subtitle">Lengkapi data berikut untuk membuat akun.</p>

<form method="POST" action="{{ route('register') }}" class="auth-form" novalidate>
    @csrf

    <div class="auth-field">
        <label for="name">Nama</label>
        <input id="name" type="text" name="name" autocomplete="name" placeholder="Nama lengkap" value="{{ old('name') }}" class="auth-input" required>
        @error('name')
            <div class="auth-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="auth-field">
        <label for="email">Email</label>
        <div class="auth-control">
            <input id="email" type="email" name="email" autocomplete="email" placeholder="nama@email.com" value="{{ old('email') }}" class="auth-input" required>
            <i class="fas fa-envelope auth-icon" aria-hidden="true"></i>
        </div>
        @error('email')
            <div class="auth-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="auth-field">
        <label for="password">Password</label>
        <div class="auth-control">
            <input id="password" type="password" name="password" autocomplete="new-password" placeholder="Minimal 8 karakter" class="auth-input" required>
            <i class="fas fa-lock auth-icon" aria-hidden="true"></i>
        </div>
        @error('password')
            <div class="auth-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="auth-field">
        <label for="password_confirmation">Konfirmasi Password</label>
        <div class="auth-control">
            <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" placeholder="Ulangi password" class="auth-input" required>
            <i class="fas fa-shield-halved auth-icon" aria-hidden="true"></i>
        </div>
    </div>

    <button type="submit" class="auth-btn">
        <span>Daftar</span>
        <i class="fas fa-user-plus" aria-hidden="true"></i>
    </button>
</form>

<div class="auth-switch">
    Sudah punya akun? <a href="{{ route('login') }}">Login</a>
</div>
@endsection
