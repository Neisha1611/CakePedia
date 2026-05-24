@extends('layouts.app')

@section('title', 'What Can I Bake?')

@section('content')

{{-- ========== HERO ========== --}}
<section class="wcib-hero">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb" style="font-size:.82rem;">
                <li class="breadcrumb-item">
                    <a href="{{ route('recipes.index') }}" style="color:var(--cp-pink-dark);">
                        <i class="bi bi-house-heart me-1"></i>Beranda
                    </a>
                </li>
                <li class="breadcrumb-item active" style="color:var(--cp-muted);">What Can I Bake?</li>
            </ol>
        </nav>

        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <div class="wcib-badge">
                    <i class="bi bi-stars me-1"></i> Fitur Pintar
                </div>
                <h1 class="wcib-title">
                    What Can I<br>
                    <span class="wcib-title-accent">Bake? 🍰</span>
                </h1>
                <p class="wcib-subtitle">
                    Ketikkan bahan yang kamu punya di dapur, dan kami akan
                    mencarikan resep kue yang bisa kamu buat sekarang juga!
                </p>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <div class="wcib-illustration">
                    <div class="wcib-pantry">
                        @foreach(['🥚','🧈','🌾','🍯','🥛','🧂'] as $item)
                            <div class="pantry-item">{{ $item }}</div>
                        @endforeach
                    </div>
                    <div class="wcib-arrow-hint">
                        <i class="bi bi-arrow-right-circle-fill"></i>
                    </div>
                    <div class="wcib-result-preview">🎂</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ========== FORM INPUT BAHAN ========== --}}
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <div class="wcib-form-card">
                <div class="wcib-form-header">
                    <div class="wcib-form-header-icon">🧂</div>
                    <div>
                        <h2 class="wcib-form-title">Bahan yang kamu punya</h2>
                        <p class="wcib-form-sub">Isi minimal 1 bahan, maksimal 5. Tidak perlu lengkap!</p>
                    </div>
                </div>

                <form action="{{ route('what-can-i-bake') }}" method="GET" id="wcibForm">
                    <div class="wcib-inputs-grid">
                        @for ($i = 0; $i < 5; $i++)
                            <div class="wcib-input-row">
                                <div class="wcib-input-number">{{ $i + 1 }}</div>
                                <div class="wcib-input-wrap">
                                    <input
                                        type="text"
                                        name="ingredients[]"
                                        class="wcib-input"
                                        placeholder="{{ ['Contoh: telur', 'Contoh: mentega', 'Contoh: terigu', 'Contoh: gula', 'Contoh: susu'][$i] }}"
                                        value="{{ $inputBahans[$i] ?? '' }}"
                                        autocomplete="off"
                                        maxlength="60"
                                    >
                                    @if(isset($inputBahans[$i]) && $inputBahans[$i])
                                        <i class="bi bi-check-circle-fill wcib-input-check"></i>
                                    @endif
                                </div>
                            </div>
                        @endfor
                    </div>

                    <div class="d-flex gap-3 mt-4 flex-wrap">
                        <button type="submit" class="btn-wcib-search" id="wcibSubmit">
                            <i class="bi bi-magic me-2"></i>Carikan Resep!
                        </button>
                        @if($searched)
                            <a href="{{ route('what-can-i-bake') }}" class="btn-cp-outline">
                                <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- ── Tip box ── --}}
            <div class="wcib-tip">
                <i class="bi bi-lightbulb-fill me-2" style="color:var(--cp-pink-dark);"></i>
                <strong>Tips:</strong> Kamu tidak perlu mengisi semua kolom.
                Sistem akan mencari resep yang mengandung <em>salah satu atau lebih</em> bahan yang kamu masukkan.
                Makin banyak bahan cocok, resepnya makin naik ke atas!
            </div>

        </div>
    </div>
</div>

{{-- ========== HASIL PENCARIAN ========== --}}
@if($searched)
<div class="container pb-5">
    <div class="wcib-results-header">
        {{-- Divider dekoratif --}}
        <div class="cp-divider"><span class="cp-divider-icon">✦</span></div>

        @if($results->isEmpty())
            {{-- Empty state --}}
            <div class="empty-state">
                <div class="empty-state-icon">🔍</div>
                <h4>Resep tidak ditemukan</h4>
                <p>
                    Tidak ada resep yang mengandung bahan:
                    @foreach(array_filter($inputBahans) as $b)
                        <strong>"{{ $b }}"</strong>{{ !$loop->last ? ',' : '.' }}
                    @endforeach
                </p>
                <p style="font-size:.87rem; color:var(--cp-muted);">
                    Coba kata kunci yang lebih umum (misal: "gula" bukan "gula pasir halus"),
                    atau <a href="{{ route('recipes.create') }}" style="color:var(--cp-pink-dark);">tambahkan resep baru</a>!
                </p>
            </div>

        @else
            {{-- Hasil ditemukan --}}
            <div class="wcib-results-summary">
                <div class="wcib-results-count">
                    <i class="bi bi-check2-circle me-2" style="color:#1B6B38;"></i>
                    Ditemukan <strong>{{ $results->count() }}</strong> resep
                    yang cocok dengan bahan kamu
                </div>
                <div class="wcib-bahan-pills">
                    @foreach(array_filter($inputBahans) as $bahan)
                        <span class="bahan-pill">
                            <i class="bi bi-check-lg me-1"></i>{{ $bahan }}
                        </span>
                    @endforeach
                </div>
            </div>

            {{-- Grid kartu hasil --}}
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4 mt-1">
                @foreach($results as $recipe)
                    @php
                        $detail  = $matchDetails[$recipe->id];
                        $score   = $detail['score'];
                        $matched = $detail['matched'];
                        $total   = count(array_filter($inputBahans));
                        $pct     = $total > 0 ? round(($score / $total) * 100) : 0;
                    @endphp
                    <div class="col">
                        <article class="recipe-card wcib-recipe-card">

                            {{-- Badge kesesuaian --}}
                            <div class="match-badge-wrap">
                                <span class="match-badge match-badge--{{ $score >= $total && $total > 1 ? 'perfect' : ($score > 1 ? 'good' : 'partial') }}">
                                    <i class="bi bi-stars me-1"></i>
                                    {{ $score }}/{{ $total }} bahan cocok
                                </span>
                            </div>

                            {{-- Gambar --}}
                            <a href="{{ route('recipes.show', $recipe) }}" class="recipe-card-img-link">
                                @if($recipe->image_url)
                                    <img src="{{ $recipe->image_url }}"
                                         alt="{{ $recipe->title }}"
                                         class="recipe-card-img"
                                         loading="lazy"
                                         onerror="this.closest('.recipe-card-img-link').innerHTML='<div class=\'recipe-card-img-placeholder\'>🎂</div>'">
                                @else
                                    <div class="recipe-card-img-placeholder">🎂</div>
                                @endif
                            </a>

                            <div class="recipe-card-body">
                                <span class="{{ $recipe->categoryBadgeClass() }}">
                                    {{ $recipe->category }}
                                </span>

                                <h3 class="recipe-card-title mt-2">
                                    <a href="{{ route('recipes.show', $recipe) }}">
                                        {{ $recipe->title }}
                                    </a>
                                </h3>

                                {{-- Match bar --}}
                                <div class="match-bar-wrap">
                                    <div class="match-bar-track">
                                        <div class="match-bar-fill" style="width:{{ $pct }}%"></div>
                                    </div>
                                    <span class="match-bar-label">{{ $pct }}% cocok</span>
                                </div>

                                {{-- Bahan yang cocok --}}
                                @if(!empty($matched))
                                    <div class="matched-badges">
                                        @foreach($matched as $m)
                                            <span class="matched-badge">
                                                <i class="bi bi-check2 me-1"></i>{{ $m }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="d-flex gap-2 mt-auto pt-3">
                                    <a href="{{ route('recipes.show', $recipe) }}"
                                       class="btn-cp-primary flex-grow-1 text-center py-2">
                                        Lihat Resep
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endif

@endsection

@push('styles')
<style>
    /* ── Hero ─────────────────────────────────────────────────── */
    .wcib-hero {
        background: linear-gradient(135deg, var(--cp-pink-light) 0%, var(--cp-beige) 60%, var(--cp-cream) 100%);
        padding: 3rem 0 2.5rem;
        border-bottom: 2px solid var(--cp-border);
    }

    .wcib-badge {
        display: inline-flex;
        align-items: center;
        background: rgba(242,167,181,.2);
        border: 1.5px solid var(--cp-pink);
        border-radius: 30px;
        padding: .3rem .9rem;
        font-size: .75rem;
        font-weight: 700;
        color: var(--cp-pink-dark);
        letter-spacing: .06em;
        text-transform: uppercase;
        margin-bottom: .75rem;
    }

    .wcib-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.6rem;
        font-weight: 700;
        color: var(--cp-brown);
        line-height: 1.15;
        margin-bottom: .75rem;
    }

    .wcib-title-accent { color: var(--cp-pink-dark); }

    .wcib-subtitle {
        font-size: .97rem;
        color: var(--cp-muted);
        max-width: 460px;
        line-height: 1.7;
    }

    /* ── Illustration ─────────────────────────────────────────── */
    .wcib-illustration {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1.2rem;
        padding: 1.5rem;
        background: rgba(255,255,255,.6);
        border: 1.5px solid var(--cp-border);
        border-radius: 24px;
    }

    .wcib-pantry {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: .5rem;
    }

    .pantry-item {
        width: 44px;
        height: 44px;
        background: #fff;
        border: 1.5px solid var(--cp-border);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        box-shadow: 0 2px 6px var(--cp-shadow);
    }

    .wcib-arrow-hint {
        font-size: 2rem;
        color: var(--cp-pink);
        animation: arrowPulse 1.5s ease-in-out infinite;
    }

    @keyframes arrowPulse {
        0%,100% { transform: translateX(0); opacity: 1; }
        50%      { transform: translateX(6px); opacity: .7; }
    }

    .wcib-result-preview {
        font-size: 4rem;
        filter: drop-shadow(0 4px 8px rgba(122,82,48,.15));
    }

    /* ── Form card ────────────────────────────────────────────── */
    .wcib-form-card {
        background: #fff;
        border: 1.5px solid var(--cp-border);
        border-radius: 24px;
        padding: 2rem 2.25rem;
        box-shadow: 0 4px 20px var(--cp-shadow);
    }

    .wcib-form-header {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.75rem;
    }

    .wcib-form-header-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, var(--cp-pink-light), var(--cp-beige));
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
        box-shadow: 0 2px 8px var(--cp-shadow);
    }

    .wcib-form-title {
        font-size: 1.15rem;
        margin: 0 0 .2rem;
        color: var(--cp-brown);
    }

    .wcib-form-sub {
        font-size: .83rem;
        color: var(--cp-muted);
        margin: 0;
    }

    /* ── Input grid ───────────────────────────────────────────── */
    .wcib-inputs-grid { display: flex; flex-direction: column; gap: .75rem; }

    .wcib-input-row {
        display: flex;
        align-items: center;
        gap: .85rem;
    }

    .wcib-input-number {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, var(--cp-pink), var(--cp-pink-dark));
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .8rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .wcib-input-wrap {
        flex: 1;
        position: relative;
    }

    .wcib-input {
        width: 100%;
        border: 1.5px solid var(--cp-border);
        border-radius: 12px;
        padding: .6rem 2.2rem .6rem 1rem;
        font-family: 'Lato', sans-serif;
        font-size: .93rem;
        color: var(--cp-text);
        background: var(--cp-white);
        transition: border-color .2s, box-shadow .2s;
    }

    .wcib-input:focus {
        outline: none;
        border-color: var(--cp-pink);
        box-shadow: 0 0 0 .2rem rgba(242,167,181,.25);
        background: #fff;
    }

    .wcib-input-check {
        position: absolute;
        right: .75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #1D9E75;
        font-size: .9rem;
    }

    /* ── Search button ────────────────────────────────────────── */
    .btn-wcib-search {
        background: linear-gradient(135deg, var(--cp-pink), var(--cp-pink-dark));
        color: #fff;
        border: none;
        border-radius: 25px;
        padding: .65rem 2rem;
        font-weight: 700;
        font-size: .95rem;
        cursor: pointer;
        transition: transform .2s, box-shadow .2s;
        box-shadow: 0 4px 14px rgba(217,127,143,.4);
    }

    .btn-wcib-search:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(217,127,143,.55);
    }

    /* ── Tip box ──────────────────────────────────────────────── */
    .wcib-tip {
        margin-top: 1.25rem;
        background: var(--cp-cream);
        border: 1.5px solid var(--cp-beige);
        border-radius: 12px;
        padding: .85rem 1.1rem;
        font-size: .84rem;
        color: var(--cp-muted);
        line-height: 1.6;
    }

    /* ── Results header ───────────────────────────────────────── */
    .wcib-results-summary {
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: .75rem;
    }

    .wcib-results-count {
        font-size: .9rem;
        color: var(--cp-text);
        background: #F0FBF4;
        border: 1.5px solid #A8DDB5;
        border-radius: 12px;
        padding: .5rem 1rem;
    }

    .wcib-bahan-pills {
        display: flex;
        flex-wrap: wrap;
        gap: .4rem;
    }

    .bahan-pill {
        font-size: .78rem;
        font-weight: 700;
        padding: .28rem .8rem;
        background: var(--cp-pink-light);
        border: 1.5px solid var(--cp-pink);
        border-radius: 20px;
        color: var(--cp-brown);
    }

    /* ── Match badge (di atas kartu) ──────────────────────────── */
    .wcib-recipe-card { position: relative; }

    .match-badge-wrap {
        position: absolute;
        top: .7rem;
        left: .7rem;
        z-index: 2;
    }

    .match-badge {
        display: inline-flex;
        align-items: center;
        font-size: .72rem;
        font-weight: 700;
        padding: .28rem .7rem;
        border-radius: 20px;
        backdrop-filter: blur(4px);
    }

    .match-badge--perfect {
        background: rgba(29,158,117,.85);
        color: #fff;
    }

    .match-badge--good {
        background: rgba(239,159,39,.85);
        color: #fff;
    }

    .match-badge--partial {
        background: rgba(255,255,255,.92);
        color: var(--cp-brown);
        border: 1px solid var(--cp-border);
    }

    /* ── Match progress bar ───────────────────────────────────── */
    .match-bar-wrap {
        display: flex;
        align-items: center;
        gap: .6rem;
        margin: .5rem 0 .6rem;
    }

    .match-bar-track {
        flex: 1;
        height: 6px;
        background: var(--cp-beige);
        border-radius: 10px;
        overflow: hidden;
    }

    .match-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--cp-pink), var(--cp-pink-dark));
        border-radius: 10px;
        transition: width .5s ease;
    }

    .match-bar-label {
        font-size: .75rem;
        font-weight: 700;
        color: var(--cp-muted);
        white-space: nowrap;
    }

    /* ── Matched ingredient badges ────────────────────────────── */
    .matched-badges {
        display: flex;
        flex-wrap: wrap;
        gap: .35rem;
        margin-bottom: .5rem;
    }

    .matched-badge {
        font-size: .73rem;
        font-weight: 700;
        padding: .2rem .6rem;
        background: #EAF3DE;
        border: 1px solid #C0DD97;
        border-radius: 12px;
        color: #3B6D11;
    }

    @media (max-width: 576px) {
        .wcib-title { font-size: 1.9rem; }
        .wcib-form-card { padding: 1.25rem 1rem; }
        .wcib-results-summary { flex-direction: column; align-items: flex-start; }
    }
</style>
@endpush

@push('scripts')
<script>
    document.getElementById('wcibForm').addEventListener('submit', function () {
        const btn = document.getElementById('wcibSubmit');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sedang mencari...';
    });

    // Real-time check icon saat user mengetik
    document.querySelectorAll('.wcib-input').forEach(input => {
        input.addEventListener('input', function () {
            const wrap = this.closest('.wcib-input-wrap');
            let icon = wrap.querySelector('.wcib-input-check');
            if (this.value.trim()) {
                if (!icon) {
                    icon = document.createElement('i');
                    icon.className = 'bi bi-check-circle-fill wcib-input-check';
                    wrap.appendChild(icon);
                }
            } else {
                if (icon) icon.remove();
            }
        });
    });
</script>
@endpush