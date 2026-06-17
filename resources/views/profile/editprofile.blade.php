@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')

<section class="page-hero" style="padding:2.5rem 0 2rem;">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb" style="font-size:0.82rem;">
                <li class="breadcrumb-item">
                    <a href="{{ route('recipes.index') }}" style="color:var(--cp-pink-dark);">
                        <i class="bi bi-house-heart me-1"></i>Beranda
                    </a>
                </li>
                <li class="breadcrumb-item active" style="color:var(--cp-muted);">Profil Saya</li>
            </ol>
        </nav>
        <h1 class="page-hero-title" style="font-size:1.9rem;">
            <i class="bi bi-person-gear me-2" style="color:var(--cp-pink-dark);"></i>Profil Saya
        </h1>
        <p class="page-hero-sub">Perbarui nama, email, atau password akunmu.</p>
    </div>
</section>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-xl-5">

            @if(session('success'))
                <div class="alert-cp-success d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert-cp-error mb-4">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <strong>Mohon periksa kembali:</strong>
                    </div>
                    <ul class="mb-0 ps-3" style="font-size:0.85rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="cp-card mb-4">
                    <h5 style="margin-bottom:1.5rem;">Informasi Akun</h5>

                    <div class="mb-4">
                        <label for="name" class="form-label-cp">
                            Nama <span style="color:var(--cp-pink-dark);">*</span>
                        </label>
                        <input type="text" id="name" name="name"
                               class="form-control-cp w-100 @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}" maxlength="255">
                        @error('name')
                            <div class="invalid-feedback d-block" style="font-size:0.8rem; color:#C0392B;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="form-label-cp">
                            Email <span style="color:var(--cp-pink-dark);">*</span>
                        </label>
                        <input type="email" id="email" name="email"
                               class="form-control-cp w-100 @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}">
                        @error('email')
                            <div class="invalid-feedback d-block" style="font-size:0.8rem; color:#C0392B;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="cp-card mb-4">
                    <h5 style="margin-bottom:0.4rem;">Ganti Password</h5>
                    <p class="form-hint mb-3">Kosongkan jika tidak ingin mengganti password.</p>

                    <div class="mb-4">
                        <label for="password" class="form-label-cp">Password Baru</label>
                        <div class="position-relative">
                            <input type="password" id="password" name="password"
                                   class="form-control-cp w-100 @error('password') is-invalid @enderror"
                                   placeholder="Minimal 8 karakter" style="padding-right: 3rem;">
                            <button type="button" onclick="togglePassword('password', 'eyePass')" class="btn-eye">
                                <i class="bi bi-eye" id="eyePass"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block" style="font-size:0.8rem; color:#C0392B;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="form-label-cp">Konfirmasi Password Baru</label>
                        <div class="position-relative">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="form-control-cp w-100"
                                   placeholder="Ulangi password baru" style="padding-right: 3rem;">
                            <button type="button" onclick="togglePassword('password_confirmation', 'eyePassConfirm')" class="btn-eye">
                                <i class="bi bi-eye" id="eyePassConfirm"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3 justify-content-end">
                    <a href="{{ route('recipes.index') }}" class="btn-cp-outline">
                        <i class="bi bi-x-lg me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn-cp-primary">
                        <i class="bi bi-check2-circle me-2"></i>Simpan Perubahan
                    </button>
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