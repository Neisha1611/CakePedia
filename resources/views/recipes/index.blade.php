@extends('layouts.app')

@section('title', 'Beranda - CakePedia')

@push('styles')
<style>
    /* =========================================
       META DESIGN SYSTEM FOR LANDING PAGE
       ========================================= */
    .meta-hero {
        background-color: var(--cp-white);
        border-bottom: 1px solid var(--cp-border);
        padding: 80px 0 64px 0; /* spacing.section-lg */
        text-align: center;
    }
    
    .meta-hero-title {
        font-family: 'Montserrat', sans-serif;
        font-size: 48px; /* display-lg */
        font-weight: 700;
        letter-spacing: -0.02em;
        color: var(--cp-brown);
        margin-bottom: 16px;
        line-height: 1.17;
    }
    
    .meta-hero-subtitle {
        font-family: 'Montserrat', sans-serif;
        font-size: 18px; /* subtitle-md */
        font-weight: 400;
        color: var(--cp-muted);
        max-width: 600px;
        margin: 0 auto 40px;
        line-height: 1.44;
    }

    /* Meta Search Pill */
    .meta-search-input {
        background-color: var(--cp-cream);
        border: 1px solid var(--cp-border);
        border-radius: var(--m-rounded-full);
        padding: 14px 24px 14px 52px;
        font-size: 16px;
        width: 100%;
        max-width: 560px;
        outline: none;
        color: var(--cp-text);
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .meta-search-input:focus {
        border-color: var(--cp-pink-dark);
        box-shadow: 0 0 0 4px rgba(242,167,181,0.15);
    }

    /* Meta Pill Tabs */
    .meta-filter-bar {
        display: flex;
        gap: 12px;
        justify-content: center;
        margin-top: 40px;
        flex-wrap: wrap;
    }
    .meta-filter-pill {
        background-color: var(--cp-white);
        border: 1px solid var(--cp-border);
        color: var(--cp-brown);
        font-family: 'Montserrat', sans-serif;
        font-size: 14px; /* body-sm-bold */
        font-weight: 700;
        letter-spacing: -0.14px;
        border-radius: var(--m-rounded-full);
        padding: 8px 20px;
        text-decoration: none;
        transition: all 0.2s;
    }
    .meta-filter-pill:hover, .meta-filter-pill.active {
        background-color: var(--cp-brown);
        color: var(--cp-white);
        border-color: var(--cp-brown);
    }

    /* Meta Product Card (card-product-feature) */
    .meta-card {
        background-color: var(--cp-white);
        border-radius: var(--m-rounded-xxxl); /* 32px */
        padding: 24px;
        border: 1px solid var(--cp-border);
        transition: transform 0.2s, box-shadow 0.2s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .meta-card:hover {
        box-shadow: 0 10px 30px var(--cp-shadow);
        transform: translateY(-4px);
    }
    
    /* Product Thumbnail (aspect-ratio: 1/1) */
    .meta-card-img {
        border-radius: var(--m-rounded-lg); /* 8px atau 16px ala thumbnail */
        aspect-ratio: 1 / 1;
        object-fit: cover;
        width: 100%;
        margin-bottom: 24px;
        background-color: var(--cp-cream);
        border: 1px solid var(--cp-border);
    }
    
    .meta-card-title {
        font-family: 'Montserrat', sans-serif;
        font-size: 24px; /* heading-sm */
        font-weight: 700;
        color: var(--cp-brown);
        margin-bottom: 8px;
        letter-spacing: -0.01em;
        line-height: 1.25;
    }
    
    .meta-card-category {
        font-family: 'Montserrat', sans-serif;
        font-size: 12px; /* caption-bold */
        font-weight: 700;
        color: var(--cp-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 8px;
    }
</style>
@endpush

@section('content')
<section class="meta-hero">
    <div class="container">
        <h1 class="meta-hero-title">Temukan Resep Kue Favoritmu</h1>
        <p class="meta-hero-subtitle">Dari pastry mewah, cookies renyah, hingga camilan tradisional Nusantara yang selalu bikin rindu.</p>
        
        <form action="{{ route('recipes.index') }}" method="GET" class="d-flex justify-content-center position-relative">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <div style="position: relative; width: 100%; max-width: 560px;">
                <i class="bi bi-search" style="position: absolute; left: 24px; top: 50%; transform: translateY(-50%); color: var(--cp-muted); font-size: 1.1rem;"></i>
                <input type="text" name="search" class="meta-search-input" placeholder="Cari nama resep kue..." value="{{ request('search') }}">
            </div>
        </form>

        <div class="meta-filter-bar">
            <a href="{{ route('recipes.index') }}" class="meta-filter-pill {{ !request('category') ? 'active' : '' }}">Semua Resep</a>
            @foreach (\App\Models\Recipe::$categories as $cat)
                <a href="{{ route('recipes.index', ['category' => $cat]) }}" class="meta-filter-pill {{ request('category') == $cat ? 'active' : '' }}">{{ $cat }}</a>
            @endforeach
        </div>
    </div>
</section>

<section class="py-5" style="background-color: var(--cp-white);">
    <div class="container py-4">
        
        <div class="d-flex justify-content-between align-items-center mb-5">
            <p class="m-body mb-0 fw-bold">Menampilkan {{ $recipes->total() ?? $recipes->count() }} resep kue</p>
            
            @if(auth()->check() && auth()->user()->role === 'admin')
                <a href="{{ route('recipes.create') }}" class="btn-meta-primary text-decoration-none">
                    <i class="bi bi-plus-lg me-2"></i>Tambah Resep Baru
                </a>
            @endif
        </div>

        @if($recipes->isEmpty())
            <div class="text-center py-5">
                <div style="font-size: 64px; opacity: 0.3; margin-bottom: 16px;">🍰</div>
                <h3 class="m-display fs-4" style="color: var(--cp-brown);">Resep tidak ditemukan</h3>
                <p class="m-body">Coba gunakan kata kunci pencarian atau kategori yang berbeda.</p>
                <a href="{{ route('recipes.index') }}" class="btn-meta-primary mt-3 text-decoration-none d-inline-block">Reset Pencarian</a>
            </div>
        @else
            <div class="row g-4 mb-5">
                @foreach($recipes as $recipe)
                    <div class="col-md-6 col-lg-4">
                        <div class="meta-card">
                            
                            @if($recipe->image_url)
                                <img src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}" class="meta-card-img" onerror="this.outerHTML='<div class=\'meta-card-img d-flex align-items-center justify-content-center\' style=\'font-size: 4rem;\'>🎂</div>'">
                            @else
                                <div class="meta-card-img d-flex align-items-center justify-content-center" style="font-size: 4rem;">🎂</div>
                            @endif
                            
                            <div class="meta-card-category">{{ $recipe->category }}</div>
                            <h3 class="meta-card-title">{{ $recipe->title }}</h3>
                            
                            <div class="d-flex align-items-center mb-4" style="color: #ffca28; font-size: 14px;">
                                <i class="bi bi-star-fill me-1"></i>
                                <span style="color: var(--cp-brown); font-weight: 700; margin-top: 2px;">{{ $recipe->averageRating() }}</span>
                                <span style="color: var(--cp-muted); margin-left: 6px; font-weight: 500; font-family: 'Montserrat', sans-serif;">({{ $recipe->ratings()->count() }})</span>
                            </div>

                            <div class="mt-auto pt-2">
                                <a href="{{ route('recipes.show', $recipe) }}" class="btn-meta-primary d-block text-center text-decoration-none w-100" style="padding: 12px 20px;">
                                    Lihat Resep
                                </a>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center">
                {{ $recipes->links() }}
            </div>
        @endif
    </div>
</section>
@endsection