@extends('layouts.app')

@section('content')
<style>
    :root {
        --cp-pink: #ffb7c5;
        --cp-beige: #f5f0ea;
        --cp-white: #fdfbf7;
        --cp-dark: #5c4b47;
    }
    .card-recipe { border: none; border-radius: 20px; background-color: #fff; transition: all 0.3s ease; overflow: hidden; }
    .card-recipe:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
    .btn-cp-pink { background-color: var(--cp-pink); color: var(--cp-dark); border: none; font-weight: bold; }
</style>

<div class="container py-5" style="color: var(--cp-dark);">
    <div class="text-center mb-5">
        <h1 class="fw-bold display-6">💖 Koleksi Saya</h1>
        <p class="text-muted">Kumpulan resep kue andalan yang Anda simpan untuk dimasak kembali</p>
    </div>

    @if($bookmarkedRecipes->isEmpty())
        <div class="text-center py-5">
            <div class="fs-1 text-muted mb-3">📑</div>
            <h4 class="fw-bold text-secondary">Belum ada resep yang disimpan</h4>
            <p class="text-muted">Jelajahi halaman beranda dan tandai resep kue kesukaanmu!</p>
            <a href="{{ route('recipes.index') }}" class="btn btn-cp-pink rounded-pill px-4 mt-2">Cari Resep</a>
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($bookmarkedRecipes as $recipe)
                <div class="col">
                    <div class="card h-100 card-recipe shadow-sm">
                        <img src="{{ $recipe->image_url }}" class="card-img-top" alt="{{ $recipe->title }}" style="height: 220px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <span class="badge bg-light text-secondary border align-self-start mb-2 px-3 py-1 rounded-pill">{{ $recipe->category }}</span>
                            <h5 class="card-title fw-bold">{{ $recipe->title }}</h5>
                            <div class="text-warning mb-3">
                                <i class="bi bi-star-fill text-warning"></i> <span class="text-dark fw-bold">{{ $recipe->averageRating() }}</span>
                            </div>
                            <div class="mt-auto">
                                <a href="{{ route('recipes.show', $recipe->id) }}" class="btn btn-cp-pink rounded-pill w-100 py-2">Lihat Resep</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $bookmarkedRecipes->links() }}
        </div>
    @endif
</div>
@endsection