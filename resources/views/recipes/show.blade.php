@extends('layouts.app')

@section('title', $recipe->title)

@section('content')

    {{-- ========== BREADCRUMB ========== --}}
    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="font-size:0.82rem;">
                <li class="breadcrumb-item">
                    <a href="{{ route('recipes.index') }}" style="color:var(--cp-pink-dark);">
                        <i class="bi bi-house-heart me-1"></i>Beranda
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('recipes.index', ['category' => $recipe->category]) }}"
                       style="color:var(--cp-pink-dark);">
                        {{ $recipe->category }}
                    </a>
                </li>
                <li class="breadcrumb-item active" style="color:var(--cp-muted);">
                    {{ Str::limit($recipe->title, 40) }}
                </li>
            </ol>
        </nav>
    </div>

    {{-- ========== MAIN CONTENT ========== --}}
    <div class="container pb-5">
        <div class="row g-4 g-lg-5">

            {{-- ===== LEFT: Image + meta ===== --}}
            <div class="col-lg-5">
                {{-- Gambar --}}
                @if ($recipe->image_url)
                    <img src="{{ $recipe->image_url }}"
                         alt="{{ $recipe->title }}"
                         class="detail-img mb-3 w-100 rounded-4 shadow-sm"
                         onerror="this.outerHTML='<div class=\'detail-img-placeholder\'>🎂</div>'">
                @else
                    <div class="detail-img-placeholder mb-3">🎂</div>
                @endif

                {{-- TAHAP 3: FITUR TOMBOL BOOKMARK --}}
                @auth
                    <form action="{{ route('bookmarks.toggle') }}" method="POST" class="mb-4">
                        @csrf
                        <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">
                        @if($recipe->bookmarks()->where('user_id', auth()->id())->exists())
                            <button type="submit" class="btn-cp-danger w-100" style="border-radius: 12px;">
                                <i class="bi bi-bookmark-dash-fill me-2"></i>Hapus dari Koleksi
                            </button>
                        @else
                            <button type="submit" class="btn-cp-outline w-100 bg-white" style="border-radius: 12px;">
                                <i class="bi bi-bookmark-plus me-2"></i>Simpan ke Koleksi Saya
                            </button>
                        @endif
                    </form>
                @else
                    <div class="alert alert-warning mb-4" style="font-size: 0.85rem; border-radius: 12px;">
                        <i class="bi bi-info-circle me-1"></i> <a href="/login" class="alert-link">Login</a> untuk menyimpan resep ini ke koleksi Anda.
                    </div>
                @endauth

                {{-- Meta card --}}
                <div class="cp-card">
                    <h6 style="font-family:'Lato',sans-serif; font-weight:700; font-size:0.75rem; letter-spacing:0.12em; text-transform:uppercase; color:var(--cp-muted); margin-bottom:1rem;">
                        Detail Resep
                    </h6>

                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div style="width:36px; height:36px; background:var(--cp-beige); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:1.1rem;">
                            🏷️
                        </div>
                        <div>
                            <div style="font-size:0.75rem; color:var(--cp-muted);">Kategori</div>
                            <span class="{{ $recipe->categoryBadgeClass() }}">{{ $recipe->category }}</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div style="width:36px; height:36px; background:var(--cp-beige); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:1.1rem;">
                            📋
                        </div>
                        <div>
                            <div style="font-size:0.75rem; color:var(--cp-muted);">Jumlah Bahan</div>
                            <div style="font-weight:700; color:var(--cp-brown);">
                                {{ count($recipe->ingredientLines()) }} bahan
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div style="width:36px; height:36px; background:var(--cp-beige); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:1.1rem;">
                            📝
                        </div>
                        <div>
                            <div style="font-size:0.75rem; color:var(--cp-muted);">Langkah Membuat</div>
                            <div style="font-weight:700; color:var(--cp-brown);">
                                {{ count($recipe->instructionLines()) }} langkah
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <div style="width:36px; height:36px; background:var(--cp-beige); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:1.1rem;">
                            🕐
                        </div>
                        <div>
                            <div style="font-size:0.75rem; color:var(--cp-muted);">Ditambahkan</div>
                            <div style="font-weight:700; color:var(--cp-brown);">
                                {{ $recipe->created_at->locale('id')->isoFormat('D MMM YYYY') }}
                            </div>
                        </div>
                    </div>

                    {{-- Action buttons --}}
                    <div class="cp-divider"><span class="cp-divider-icon">✦</span></div>

                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('recipes.edit', $recipe) }}" class="btn-cp-outline text-center">
                            <i class="bi bi-pencil-square me-2"></i>Edit Resep
                        </a>

                        <form action="{{ route('recipes.destroy', $recipe) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus resep &quot;{{ addslashes($recipe->title) }}&quot;? Tindakan ini tidak bisa dibatalkan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-cp-danger w-100">
                                <i class="bi bi-trash3 me-2"></i>Hapus Resep
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ===== RIGHT: Detail konten ===== --}}
            <div class="col-lg-7">

                {{-- Judul --}}
                <span class="{{ $recipe->categoryBadgeClass() }} mb-2 d-inline-block">
                    {{ $recipe->category }}
                </span>
                <h1 style="font-family:'Playfair Display',serif; font-size:2rem; font-weight:700; color:var(--cp-brown); line-height:1.2; margin-bottom:0.5rem;">
                    {{ $recipe->title }}
                </h1>

                {{-- TAHAP 3: MENAMPILKAN RATA-RATA RATING --}}
                <div class="d-flex align-items-center mb-4">
                    <div style="color: #ffca28; font-size: 1.1rem;" class="me-2">
                        @php $finalRating = $recipe->averageRating(); @endphp
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($finalRating))
                                <i class="bi bi-star-fill"></i>
                            @else
                                <i class="bi bi-star" style="color: #ddd;"></i>
                            @endif
                        @endfor
                    </div>
                    <span style="font-weight: 700; color: var(--cp-brown); font-size: 1.1rem;">{{ $finalRating }} / 5.0</span>
                    <span style="color: var(--cp-muted); font-size: 0.9rem;" class="ms-2">({{ $recipe->ratings()->count() }} Penilaian)</span>
                </div>

                {{-- ===== BAHAN-BAHAN ===== --}}
                <div class="cp-card mb-4">
                    <h3 style="font-size:1.1rem; margin-bottom:1rem; display:flex; align-items:center; gap:0.6rem;">
                        <span style="font-size:1.4rem;">🧂</span>
                        Bahan-Bahan
                    </h3>

                    <ul class="ingredient-list">
                        @foreach ($recipe->ingredientLines() as $ingredient)
                            @if (Str::startsWith($ingredient, '—') || Str::startsWith($ingredient, '--'))
                                {{-- Sub-header bahan --}}
                                <li style="font-weight:700; color:var(--cp-brown); border-bottom:1.5px solid var(--cp-beige);">
                                    <span style="color:var(--cp-pink-dark);">{{ $ingredient }}</span>
                                </li>
                            @else
                                <li>{{ $ingredient }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>

                {{-- ===== CARA MEMBUAT ===== --}}
                <div class="cp-card mb-4">
                    <h3 style="font-size:1.1rem; margin-bottom:1rem; display:flex; align-items:center; gap:0.6rem;">
                        <span style="font-size:1.4rem;">👩‍🍳</span>
                        Cara Membuat
                    </h3>

                    <ol class="instruction-list">
                        @foreach ($recipe->instructionLines() as $step)
                            @if (Str::endsWith(rtrim($step), ':'))
                                {{-- Sub-header langkah --}}
                                <li style="font-weight:700; color:var(--cp-brown); background:var(--cp-cream); border-radius:8px; padding:0.6rem 0.9rem; border-bottom:none; margin-bottom:0.3rem; counter-increment: none;"
                                    class="instruction-subheader">
                                    {{ $step }}
                                </li>
                            @else
                                <li>{{ $step }}</li>
                            @endif
                        @endforeach
                    </ol>
                </div>

                {{-- TAHAP 3: FORM INPUT RATING BINTANG --}}
                <div class="cp-card mb-4" style="background-color: var(--cp-white); border: 2px dashed var(--cp-pink);">
                    <h3 style="font-size:1.1rem; margin-bottom:1rem; display:flex; align-items:center; gap:0.6rem;">
                        <span style="font-size:1.4rem;">⭐</span>
                        Beri Nilai Resep Ini
                    </h3>
                    <form action="{{ route('ratings.store') }}" method="POST" id="ratingForm">
                        @csrf
                        <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">
                        <div class="d-flex gap-2 mb-3 flex-row-reverse justify-content-end">
                            <input type="radio" name="score" value="5" id="s5" class="d-none"><label for="s5" class="bi bi-star-fill rating-star-input"></label>
                            <input type="radio" name="score" value="4" id="s4" class="d-none"><label for="s4" class="bi bi-star-fill rating-star-input"></label>
                            <input type="radio" name="score" value="3" id="s3" class="d-none"><label for="s3" class="bi bi-star-fill rating-star-input"></label>
                            <input type="radio" name="score" value="2" id="s2" class="d-none"><label for="s2" class="bi bi-star-fill rating-star-input"></label>
                            <input type="radio" name="score" value="1" id="s1" class="d-none"><label for="s1" class="bi bi-star-fill rating-star-input"></label>
                        </div>
                        <button type="submit" class="btn-cp-outline px-4" style="border-radius: 8px;">Kirim Penilaian</button>
                    </form>
                </div>

                {{-- Back button --}}
                <div class="mt-4">
                    <a href="{{ route('recipes.index') }}" class="btn-cp-outline">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Resep
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
<style>
    /* Override counter for sub-header rows */
    .instruction-subheader {
        counter-increment: none !important;
    }
    .instruction-subheader::before {
        content: '✦' !important;
        background: var(--cp-beige-dark) !important;
        font-size: 0.7rem !important;
    }
    
    /* TAHAP 3: CSS Interaksi Rating Bintang */
    .rating-star-input { 
        font-size: 2rem; 
        color: #e4e4e4; 
        cursor: pointer; 
        transition: all 0.2s; 
    }
    .rating-star-input:hover, 
    .rating-star-input:hover ~ .rating-star-input { 
        color: #ffca28; 
        transform: scale(1.15); 
    }
    input[type="radio"]:checked ~ label { 
        color: #ffca28 !important; 
    }
</style>
@endpush