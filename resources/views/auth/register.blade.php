@extends('layouts.app')

@section('title', 'Register - CakePedia')

@section('content')
<div class="container d-flex align-items-center justify-content-center py-5" style="min-height: 85vh;">
    <div class="card card-meta-auth p-2" style="width: 100%; max-width: 480px;">
        <div class="card-body p-4 p-md-5">

            <div class="text-center mb-4">
                <h2 class="m-display fw-bold mb-1" style="color: var(--cp-brown); font-size: 28px;">Buat Akun</h2>
                <p class="m-body" style="font-size: 14px;">Bergabunglah untuk menyimpan resep favoritmu</p>
            </div>

            @if($errors->any())
                <div class="alert alert-cp-error mb-4" style="padding: 10px 15px;">
                    <ul class="mb-0 ps-3" style="font-size: 13px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold mb-1" style="font-size: 12px; color: var(--cp-brown-light); letter-spacing: 0.5px;">NAMA LENGKAP</label>
                    <input type="text" name="name" class="form-control form-meta" placeholder="Nama Anda" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold mb-1" style="font-size: 12px; color: var(--cp-brown-light); letter-spacing: 0.5px;">EMAIL ADDRESS</label>
                    <input type="email" name="email" class="form-control form-meta" placeholder="nama@email.com" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold mb-1" style="font-size: 12px; color: var(--cp-brown-light); letter-spacing: 0.5px;">PASSWORD</label>
                    <div class="position-relative">
                        <input type="password" name="password" id="regPassword" class="form-control form-meta" placeholder="Min. 8 karakter" required style="padding-right: 3rem;">
                        <button type="button" onclick="togglePassword('regPassword', 'eyeReg')" class="btn-eye">
                            <i class="bi bi-eye" id="eyeReg"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold mb-1" style="font-size: 12px; color: var(--cp-brown-light); letter-spacing: 0.5px;">KONFIRMASI PASSWORD</label>
                    <div class="position-relative">
                        <input type="password" name="password_confirmation" id="regPasswordConfirm" class="form-control form-meta" placeholder="Ulangi password" required style="padding-right: 3rem;">
                        <button type="button" onclick="togglePassword('regPasswordConfirm', 'eyeRegConfirm')" class="btn-eye">
                            <i class="bi bi-eye" id="eyeRegConfirm"></i>
                        </button>
                    </div>
                </div>

                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-meta-primary py-3">Daftar Akun</button>
                </div>

                <div class="text-center">
                    <p class="m-body mb-0" style="font-size: 14px;">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color: var(--cp-pink-dark);">Masuk di sini</a>
                    </p>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }
</script>
@endpush