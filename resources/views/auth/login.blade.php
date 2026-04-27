@extends('layouts.auth')

@section('title', 'Login - Alhasanah App')

@section('auth_heading', 'Ahlan Wa Sahlan ')
@section('auth_description', 'Silakan login untuk mengakses Website Al-Hasanah')

@section('content')
<div class="auth-form-icon" aria-hidden="true">
    <i class="fas fa-key"></i>
</div>
<h2>Login</h2>
<p class="auth-subtitle">Masukkan email dan password untuk melanjutkan.</p>

@if ($errors->any())
    <div class="auth-error">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('login') }}" class="auth-form" novalidate>
    @csrf

    <div class="auth-field">
        <label for="email">Email</label>
        <div class="auth-control">
            <input id="email" type="email" name="email" autocomplete="email" required class="auth-input" value="{{ old('email') }}">
            <i class="fas fa-envelope auth-icon" aria-hidden="true"></i>
        </div>
    </div>

    <div class="auth-field">
        <label for="password">Password</label>
        <div class="auth-control">
            <input id="password" type="password" name="password" autocomplete="current-password" required class="auth-input">
            <i class="fas fa-lock auth-icon" aria-hidden="true"></i>
        </div>
    </div>

    <button type="submit" class="auth-btn">
        <span>Masuk</span>
        <i class="fas fa-sign-in-alt" aria-hidden="true"></i>
    </button>
</form>

<div class="auth-switch">
    Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
</div>
@endsection
