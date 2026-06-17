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
                @if ($recipe->image_url)
                    <img src="{{ $recipe->image_url }}"
                         alt="{{ $recipe->title }}"
                         class="detail-img mb-3 w-100 rounded-4 shadow-sm"
                         onerror="this.outerHTML='<div class=\'detail-img-placeholder\'>🎂</div>'">
                @else
                    <div class="detail-img-placeholder mb-3">🎂</div>
                @endif

                {{-- Tombol Bookmark — HANYA untuk member --}}
                @if(auth()->user()->role !== 'admin')
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
                @endif

                {{-- Meta card --}}
                <div class="cp-card">
                    <h6 style="font-family:'Lato',sans-serif; font-weight:700; font-size:0.75rem; letter-spacing:0.12em; text-transform:uppercase; color:var(--cp-muted); margin-bottom:1rem;">
                        Detail Resep
                    </h6>

                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div style="width:36px; height:36px; background:var(--cp-beige); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:1.1rem;">🏷️</div>
                        <div>
                            <div style="font-size:0.75rem; color:var(--cp-muted);">Kategori</div>
                            <span class="{{ $recipe->categoryBadgeClass() }}">{{ $recipe->category }}</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div style="width:36px; height:36px; background:var(--cp-beige); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:1.1rem;">📋</div>
                        <div>
                            <div style="font-size:0.75rem; color:var(--cp-muted);">Jumlah Bahan</div>
                            <div style="font-weight:700; color:var(--cp-brown);">{{ count($recipe->ingredientLines()) }} bahan</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div style="width:36px; height:36px; background:var(--cp-beige); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:1.1rem;">📝</div>
                        <div>
                            <div style="font-size:0.75rem; color:var(--cp-muted);">Langkah Membuat</div>
                            <div style="font-weight:700; color:var(--cp-brown);">{{ count($recipe->instructionLines()) }} langkah</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <div style="width:36px; height:36px; background:var(--cp-beige); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:1.1rem;">🕐</div>
                        <div>
                            <div style="font-size:0.75rem; color:var(--cp-muted);">Ditambahkan</div>
                            <div style="font-weight:700; color:var(--cp-brown);">{{ $recipe->created_at->locale('id')->isoFormat('D MMM YYYY') }}</div>
                        </div>
                    </div>

                    {{-- Tombol Edit & Hapus — HANYA untuk Admin --}}
                    @if(auth()->user()->role === 'admin')
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
                    @endif
                </div>
            </div>

            {{-- ===== RIGHT: Detail konten ===== --}}
            <div class="col-lg-7">

                <span class="{{ $recipe->categoryBadgeClass() }} mb-2 d-inline-block">{{ $recipe->category }}</span>
                <h1 style="font-family:'Playfair Display',serif; font-size:2rem; font-weight:700; color:var(--cp-brown); line-height:1.2; margin-bottom:0.5rem;">
                    {{ $recipe->title }}
                </h1>

                {{-- Rating rata-rata --}}
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
                    <span style="font-weight:700; color:var(--cp-brown); font-size:1.1rem;">{{ $finalRating }} / 5.0</span>
                    <span style="color:var(--cp-muted); font-size:0.9rem;" class="ms-2">({{ $recipe->ratings()->count() }} Penilaian)</span>
                </div>

                {{-- ===== BAHAN-BAHAN ===== --}}
                <div class="cp-card mb-4">
                    <h3 style="font-size:1.1rem; margin-bottom:1rem; display:flex; align-items:center; gap:0.6rem;">
                        <span style="font-size:1.4rem;">🧂</span> Bahan-Bahan
                    </h3>
                    <ul class="ingredient-list">
                        @foreach ($recipe->ingredientLines() as $ingredient)
                            @if (Str::startsWith($ingredient, '—') || Str::startsWith($ingredient, '--'))
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
                        <span style="font-size:1.4rem;">👩‍🍳</span> Cara Membuat
                    </h3>
                    <ol class="instruction-list">
                        @foreach ($recipe->instructionLines() as $step)
                            @if (Str::endsWith(rtrim($step), ':'))
                                <li style="font-weight:700; color:var(--cp-brown); background:var(--cp-cream); border-radius:8px; padding:0.6rem 0.9rem; border-bottom:none; margin-bottom:0.3rem;"
                                    class="instruction-subheader">
                                    {{ $step }}
                                </li>
                            @else
                                <li>{{ $step }}</li>
                            @endif
                        @endforeach
                    </ol>
                </div>

                {{-- ===== FORM RATING + KOMENTAR — hanya member ===== --}}
                @if(auth()->user()->role !== 'admin')
                    <div class="cp-card mb-4" style="border: 2px dashed var(--cp-pink);">
                        <h3 style="font-size:1.1rem; margin-bottom:1rem; display:flex; align-items:center; gap:0.6rem;">
                            <span style="font-size:1.4rem;">⭐</span>
                            {{ $userRating ? 'Ubah Penilaian' : 'Beri Nilai & Komentar' }}
                        </h3>
                        <form action="{{ route('ratings.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">

                            <div class="d-flex gap-2 mb-3 flex-row-reverse justify-content-end">
                                <input type="radio" name="score" value="5" id="s5" class="d-none" {{ $userRating && $userRating->score == 5 ? 'checked' : '' }}>
                                <label for="s5" class="bi bi-star-fill rating-star-input"></label>
                                <input type="radio" name="score" value="4" id="s4" class="d-none" {{ $userRating && $userRating->score == 4 ? 'checked' : '' }}>
                                <label for="s4" class="bi bi-star-fill rating-star-input"></label>
                                <input type="radio" name="score" value="3" id="s3" class="d-none" {{ $userRating && $userRating->score == 3 ? 'checked' : '' }}>
                                <label for="s3" class="bi bi-star-fill rating-star-input"></label>
                                <input type="radio" name="score" value="2" id="s2" class="d-none" {{ $userRating && $userRating->score == 2 ? 'checked' : '' }}>
                                <label for="s2" class="bi bi-star-fill rating-star-input"></label>
                                <input type="radio" name="score" value="1" id="s1" class="d-none" {{ $userRating && $userRating->score == 1 ? 'checked' : '' }}>
                                <label for="s1" class="bi bi-star-fill rating-star-input"></label>
                            </div>

                            <div class="mb-3">
                                <textarea name="body"
                                          class="form-control-cp w-100"
                                          rows="3"
                                          placeholder="Tulis komentarmu tentang resep ini..."
                                          maxlength="1000">{{ $userComment ? $userComment->body : '' }}</textarea>
                            </div>

                            <button type="submit" class="btn-cp-outline px-4" style="border-radius:8px;">
                                <i class="bi bi-send me-2"></i>{{ $userRating ? 'Perbarui Penilaian' : 'Kirim Penilaian' }}
                            </button>
                        </form>
                    </div>
                @endif

                {{-- ===== DAFTAR KOMENTAR ===== --}}
                <div class="cp-card mb-4">
                    <h3 style="font-size:1.1rem; margin-bottom:1.5rem; display:flex; align-items:center; gap:0.6rem;">
                        <span style="font-size:1.4rem;">💬</span>
                        Komentar
                        <span style="font-size:0.85rem; font-weight:400; color:var(--cp-muted);">({{ $recipe->comments->count() }})</span>
                    </h3>

                    @forelse($recipe->comments as $comment)
                        <div class="comment-item" id="comment-{{ $comment->id }}">
                            <div class="d-flex gap-3">
                                <div class="comment-avatar">
                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                        <span class="comment-name">{{ $comment->user->name }}</span>
                                        @if($comment->user->role === 'admin')
                                            <span class="comment-badge-admin">Admin</span>
                                        @endif
                                        @if($comment->from_rating)
                                            @php
                                                $commentRating = $comment->user->ratings()
                                                    ->where('recipe_id', $recipe->id)
                                                    ->first();
                                            @endphp
                                            @if($commentRating)
                                                <span class="comment-stars">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="bi bi-star-fill" style="font-size:0.7rem; color:{{ $i <= $commentRating->score ? '#F39C12' : '#ddd' }};"></i>
                                                    @endfor
                                                </span>
                                            @endif
                                        @endif
                                        <span class="comment-time">{{ $comment->updated_at->locale('id')->diffForHumans() }}</span>
                                    </div>
                                    <p class="comment-body">{{ $comment->body }}</p>
                                    <div class="d-flex align-items-center gap-3">
                                        <button type="button" class="btn-reply-toggle"
                                                onclick="toggleReplyForm('reply-{{ $comment->id }}')">
                                            <i class="bi bi-reply me-1"></i>Balas
                                        </button>
                                        {{-- Hapus hanya untuk admin --}}
                                        @if(auth()->user()->role === 'admin')
                                            <form action="{{ route('comments.destroy', $comment) }}" method="POST"
                                                  onsubmit="return confirm('Hapus komentar ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn-comment-delete">
                                                    <i class="bi bi-trash3 me-1"></i>Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                    {{-- Form balas --}}
                                    <div id="reply-{{ $comment->id }}" style="display:none; margin-top:0.75rem;">
                                        <form action="{{ route('comments.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">
                                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                            <div class="mb-2">
                                                <textarea name="body" class="form-control-cp w-100" rows="2"
                                                          placeholder="Tulis balasanmu..." maxlength="1000"></textarea>
                                            </div>
                                            <div class="d-flex gap-2 justify-content-end">
                                                <button type="button"
                                                        onclick="toggleReplyForm('reply-{{ $comment->id }}')"
                                                        class="btn-cp-outline" style="padding:0.35rem 1rem; font-size:0.82rem;">
                                                    Batal
                                                </button>
                                                <button type="submit" class="btn-cp-primary"
                                                        style="padding:0.35rem 1rem; font-size:0.82rem;">
                                                    <i class="bi bi-send me-1"></i>Kirim
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    {{-- Balasan --}}
                                    @if($comment->replies->count() > 0)
                                        <div class="replies-wrapper">
                                            @foreach($comment->replies as $reply)
                                                <div class="d-flex gap-2 mt-3">
                                                    <div class="comment-avatar comment-avatar-sm">
                                                        {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                                            <span class="comment-name">{{ $reply->user->name }}</span>
                                                            @if($reply->user->role === 'admin')
                                                                <span class="comment-badge-admin">Admin</span>
                                                            @endif
                                                            <span class="comment-time">{{ $reply->created_at->locale('id')->diffForHumans() }}</span>
                                                        </div>
                                                        <p class="comment-body mb-1">{{ $reply->body }}</p>
                                                        {{-- Hapus balasan hanya untuk admin --}}
                                                        @if(auth()->user()->role === 'admin')
                                                            <form action="{{ route('comments.destroy', $reply) }}" method="POST"
                                                                  onsubmit="return confirm('Hapus balasan ini?')">
                                                                @csrf @method('DELETE')
                                                                <button type="submit" class="btn-comment-delete">
                                                                    <i class="bi bi-trash3 me-1"></i>Hapus
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div style="text-align:center; padding:2rem 0; color:var(--cp-muted);">
                            <div style="font-size:2.5rem; opacity:0.4; margin-bottom:0.5rem;">💬</div>
                            <p style="font-size:0.9rem;">Belum ada komentar. Jadilah yang pertama!</p>
                        </div>
                    @endforelse
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
    .instruction-subheader { counter-increment: none !important; }
    .instruction-subheader::before { content: '✦' !important; background: var(--cp-beige-dark) !important; font-size: 0.7rem !important; }

    .rating-star-input { font-size: 2rem; color: #e4e4e4; cursor: pointer; transition: all 0.2s; }
    .rating-star-input:hover,
    .rating-star-input:hover ~ .rating-star-input { color: #ffca28; transform: scale(1.15); }
    input[type="radio"]:checked ~ label { color: #ffca28 !important; }

    .comment-item { padding: 1rem 0; border-bottom: 1px dashed var(--cp-border); }
    .comment-item:last-child { border-bottom: none; }
    .comment-avatar { width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, var(--cp-pink), var(--cp-pink-dark)); color: #fff; font-weight: 700; font-size: 0.9rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .comment-avatar-sm { width: 30px; height: 30px; font-size: 0.75rem; }
    .comment-name { font-weight: 700; font-size: 0.88rem; color: var(--cp-brown); }
    .comment-badge-admin { background: var(--cp-pink-light); color: var(--cp-pink-dark); font-size: 0.7rem; font-weight: 700; padding: 0.1rem 0.5rem; border-radius: 10px; }
    .comment-stars { display: inline-flex; gap: 1px; align-items: center; }
    .comment-time { font-size: 0.75rem; color: var(--cp-muted); }
    .comment-body { font-size: 0.9rem; color: var(--cp-text); margin-bottom: 0.5rem; line-height: 1.6; }
    .btn-reply-toggle { background: none; border: none; color: var(--cp-pink-dark); font-size: 0.8rem; font-weight: 700; cursor: pointer; padding: 0; }
    .btn-reply-toggle:hover { color: var(--cp-brown); }
    .btn-comment-delete { background: none; border: none; color: var(--cp-muted); font-size: 0.78rem; cursor: pointer; padding: 0; }
    .btn-comment-delete:hover { color: #C0392B; }
    .replies-wrapper { margin-top: 0.5rem; padding-left: 1rem; border-left: 2px solid var(--cp-border); }
</style>
@endpush

@push('scripts')
<script>
    function toggleReplyForm(id) {
        const el = document.getElementById(id);
        el.style.display = el.style.display === 'none' ? 'block' : 'none';
    }
</script>
@endpush