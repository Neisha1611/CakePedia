@extends('layouts.app')

@section('title', 'Koleksi Saya — CakePedia')

@push('styles')
<style>
    .bookmarks-hero {
        background: linear-gradient(135deg, var(--cp-pink-light) 0%, var(--cp-beige) 60%, var(--cp-cream) 100%);
        padding: 3.5rem 0 2.5rem;
        border-bottom: 2px solid var(--cp-border);
        position: relative;
        overflow: hidden;
    }
    .bookmarks-hero::before {
        content: '💖';
        position: absolute;
        font-size: 9rem;
        opacity: 0.06;
        right: 4%;
        top: 50%;
        transform: translateY(-50%);
    }
    .bookmarks-hero-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--cp-brown);
        margin-bottom: 0.4rem;
    }
    .bookmarks-hero-sub {
        font-size: 0.95rem;
        color: var(--cp-muted);
    }
    .stat-pill {
        background: #fff;
        border: 1.5px solid var(--cp-border);
        border-radius: 25px;
        padding: 0.45rem 1.1rem;
        font-size: 0.84rem;
        font-weight: 700;
        color: var(--cp-brown);
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
    }
    .btn-remove-bookmark {
        background: transparent;
        border: 1.5px solid #F5B7B1;
        color: #C0392B;
        border-radius: 20px;
        padding: 0.45rem 1rem;
        font-size: 0.8rem;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.2s, color 0.2s;
        line-height: 1;
    }
    .btn-remove-bookmark:hover {
        background: #FDECEA;
        color: #922B21;
    }
    .recipe-rating {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.85rem;
        margin: 0.3rem 0 0.7rem;
    }
    .stars-fill { color: #F39C12; }
    .rating-value { font-weight: 700; color: var(--cp-brown); }
    .rating-count { color: var(--cp-muted); font-size: 0.78rem; }
    .card-actions {
        display: flex;
        gap: 0.6rem;
        margin-top: auto;
        padding-top: 1rem;
    }
    .bookmarks-empty {
        text-align: center;
        padding: 5rem 1rem;
    }
    .bookmarks-empty-icon {
        font-size: 5rem;
        opacity: 0.4;
        margin-bottom: 1.25rem;
        animation: float 3s ease-in-out infinite;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .bookmarks-empty h3 {
        font-family: 'Playfair Display', serif;
        color: var(--cp-brown);
        margin-bottom: 0.5rem;
    }
    .bookmarks-empty p {
        color: var(--cp-muted);
        font-size: 0.93rem;
        max-width: 400px;
        margin: 0 auto 1.5rem;
    }
</style>
@endpush

@section('content')

<section class="bookmarks-hero">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb" style="font-size:0.82rem;">
                <li class="breadcrumb-item">
                    <a href="{{ route('recipes.index') }}" style="color:var(--cp-pink-dark);">
                        <i class="bi bi-house-heart me-1"></i>Beranda
                    </a>
                </li>
                <li class="breadcrumb-item active" style="color:var(--cp-muted);">Koleksi Saya</li>
            </ol>
        </nav>
        <h1 class="bookmarks-hero-title">
            <i class="bi bi-bookmark-heart me-2" style="color:var(--cp-pink-dark);"></i>Koleksi Saya
        </h1>
        <p class="bookmarks-hero-sub">Resep kue favorit yang kamu simpan, siap dimasak kapan saja.</p>
    </div>
</section>

<div class="container py-5">

    @if($bookmarkedRecipes->isEmpty())
        <div class="bookmarks-empty">
            <div class="bookmarks-empty-icon">📑</div>
            <h3>Belum ada resep yang disimpan</h3>
            <p>
                Jelajahi beranda, lalu klik ikon <i class="bi bi-bookmark-heart text-danger"></i>
                pada resep kue yang kamu suka untuk menyimpannya di sini.
            </p>
            <a href="{{ route('recipes.index') }}" class="btn-cp-primary">
                <i class="bi bi-search me-2"></i>Cari Resep
            </a>
        </div>

    @else

        <div class="mb-4">
            <span class="stat-pill">
                <i class="bi bi-bookmark-fill" style="color:var(--cp-pink-dark);"></i>
                {{ $bookmarkedRecipes->total() }} resep tersimpan
            </span>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($bookmarkedRecipes as $recipe)
                @php
                    $avg   = $recipe->averageRating();
                    $count = $recipe->ratings()->count();
                @endphp
                <div class="col">
                    <article class="recipe-card h-100 d-flex flex-column">

                        <a href="{{ route('recipes.show', $recipe) }}" class="recipe-card-img-link">
                            @if($recipe->image_url)
                                <img src="{{ $recipe->image_url }}"
                                     alt="{{ $recipe->title }}"
                                     class="recipe-card-img"
                                     loading="lazy"
                                     onerror="this.closest('a').innerHTML='<div class=\'recipe-card-img-placeholder\'>🎂</div>'">
                            @else
                                <div class="recipe-card-img-placeholder">🎂</div>
                            @endif
                        </a>

                        <div class="recipe-card-body d-flex flex-column flex-grow-1">

                            <span class="{{ $recipe->categoryBadgeClass() }} align-self-start mb-2">
                                {{ $recipe->category }}
                            </span>

                            <h5 class="recipe-card-title">
                                <a href="{{ route('recipes.show', $recipe) }}" style="color:inherit; text-decoration:none;">
                                    {{ $recipe->title }}
                                </a>
                            </h5>

                            <div class="recipe-rating">
                                <span class="stars-fill">
                                    @for($s = 1; $s <= 5; $s++)
                                        {{ $s <= floor($avg) ? '★' : '☆' }}
                                    @endfor
                                </span>
                                <span class="rating-value">{{ $avg > 0 ? $avg : '—' }}</span>
                                @if($count > 0)
                                    <span class="rating-count">({{ $count }} ulasan)</span>
                                @endif
                            </div>

                            <div class="card-actions">
                                <a href="{{ route('recipes.show', $recipe) }}" class="btn-cp-primary flex-grow-1 text-center py-2">
                                    <i class="bi bi-eye me-1"></i>Lihat Resep
                                </a>
                                <form action="{{ route('bookmarks.toggle') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">
                                    <button type="submit" class="btn-remove-bookmark" title="Hapus dari koleksi">
                                        <i class="bi bi-bookmark-x"></i>
                                    </button>
                                </form>
                            </div>

                        </div>
                    </article>
                </div>
            @endforeach
        </div>

        @if($bookmarkedRecipes->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $bookmarkedRecipes->links() }}
            </div>
        @endif

    @endif
</div>

@endsection