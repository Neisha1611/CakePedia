@extends('layouts.app')

@section('title', 'Login - CakePedia')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 85vh;">
    <div class="card card-meta-auth p-2" style="width: 100%; max-width: 440px;">
        <div class="card-body p-4 p-md-5">
            
            <div class="text-center mb-4">
                <div class="mb-2" style="font-size: 2.5rem;">🍰</div>
                <h2 class="m-display fw-bold mb-1" style="color: var(--cp-brown); font-size: 28px;">CakePedia</h2>
                <p class="m-body" style="font-size: 14px;">Silakan masuk untuk melanjutkan</p>
            </div>

            @if($errors->any())
                <div class="alert alert-cp-error mb-4" style="padding: 10px 15px;">
                    <i class="bi bi-exclamation-circle-fill me-2"></i> {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" autocomplete="off">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label fw-bold mb-2" style="font-size: 12px; color: var(--cp-brown-light); letter-spacing: 0.5px;">EMAIL ADDRESS</label>
                    <input type="email" name="email" class="form-control form-meta" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus autocomplete="off">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold mb-2" style="font-size: 12px; color: var(--cp-brown-light); letter-spacing: 0.5px;">PASSWORD</label>
                    <input type="password" name="password" class="form-control form-meta" placeholder="Masukkan password" required autocomplete="new-password">
                </div>

                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-meta-primary py-3">
                        Masuk
                    </button>
                </div>

                <div class="text-center">
                    <p class="m-body mb-0" style="font-size: 14px;">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="fw-bold text-decoration-none" style="color: var(--cp-pink-dark);">Daftar di sini</a>
                    </p>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection