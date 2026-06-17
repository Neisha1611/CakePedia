<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CakePedia') — Ensiklopedia Resep Kue</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Lato:wght@300;400;700&family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --cp-pink:        #F2A7B5;
            --cp-pink-light:  #FADADD;
            --cp-pink-dark:   #D97F8F;
            --cp-beige:       #F0E0C8;
            --cp-beige-dark:  #D9C4A5;
            --cp-white:       #FAF8F5;
            --cp-cream:       #FEF9F0;
            --cp-brown:       #7A5230;
            --cp-brown-light: #B5835A;
            --cp-text:        #3D2B1F;
            --cp-muted:       #9E7B65;
            --cp-border:      #EDD9C0;
            --cp-shadow:      rgba(122,82,48,0.12);
            --cp-shadow-md:   rgba(122,82,48,0.18);
            --m-rounded-xxxl: 32px;
            --m-rounded-full: 100px;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Lato', sans-serif;
            background-color: var(--cp-white);
            color: var(--cp-text);
            font-weight: 300;
            line-height: 1.7;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main { flex: 1; display: flex; flex-direction: column; }

        h1, h2, h3, h4, h5 { font-family: 'Playfair Display', serif; color: var(--cp-brown); }
        a { color: var(--cp-pink-dark); text-decoration: none; }
        a:hover { color: var(--cp-brown); }

        .navbar-cakepedia { background-color: var(--cp-white); border-bottom: 2px solid var(--cp-border); padding: 0.9rem 0; box-shadow: 0 2px 12px var(--cp-shadow); }
        .navbar-brand-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .brand-icon { width: 42px; height: 42px; background: linear-gradient(135deg, var(--cp-pink), var(--cp-beige)); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; box-shadow: 0 2px 8px var(--cp-shadow); }
        .brand-text { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 700; color: var(--cp-brown); line-height: 1; }
        .brand-sub { font-family: 'Lato', sans-serif; font-size: 0.65rem; font-weight: 300; color: var(--cp-muted); letter-spacing: 0.12em; text-transform: uppercase; }

        .nav-link-cp { font-family: 'Lato', sans-serif; font-weight: 400; font-size: 0.9rem; color: var(--cp-brown) !important; padding: 0.4rem 1rem !important; border-radius: 20px; transition: background 0.2s, color 0.2s; }
        .nav-link-cp:hover, .nav-link-cp.active { background-color: var(--cp-pink-light); color: var(--cp-brown) !important; }

        .btn-nav-add { background: linear-gradient(135deg, var(--cp-pink), var(--cp-pink-dark)); color: #fff !important; border: none; border-radius: 20px; padding: 0.4rem 1.2rem; font-size: 0.88rem; font-weight: 700; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 2px 8px rgba(217,127,143,0.3); }
        .btn-nav-add:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(217,127,143,0.45); }

        .m-display { font-family: 'Montserrat', sans-serif; font-weight: 700; letter-spacing: -0.02em; line-height: 1.2; }
        .m-body { font-family: 'Montserrat', sans-serif; font-size: 16px; letter-spacing: -0.16px; line-height: 1.5; color: var(--cp-muted); }

        .card-meta-auth { border-radius: var(--m-rounded-xxxl); background-color: var(--cp-white); border: 1.5px solid var(--cp-border) !important; box-shadow: 0 10px 30px var(--cp-shadow); }

        .btn-meta-primary { background: linear-gradient(135deg, var(--cp-pink), var(--cp-pink-dark)); color: #fff !important; border-radius: var(--m-rounded-full); padding: 14px 30px; font-weight: 700; font-size: 14px; font-family: 'Montserrat', sans-serif; border: none; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 4px 14px rgba(217,127,143,0.3); }
        .btn-meta-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(217,127,143,0.45); }

        .form-meta { border: 1.5px solid var(--cp-border); border-radius: 12px; padding: 12px 16px; height: 48px; font-size: 15px; background-color: #fff; color: var(--cp-text); transition: border-color 0.2s, box-shadow 0.2s; }
        .form-meta:focus { border-color: var(--cp-pink); box-shadow: 0 0 0 0.2rem rgba(242,167,181,0.25); outline: none; }
        .form-meta::placeholder { color: #c4b9b6; }

        .footer-cp { background: linear-gradient(135deg, var(--cp-beige), var(--cp-pink-light)); border-top: 2px solid var(--cp-border); padding: 2.5rem 0 1.5rem; margin-top: auto; }
        .footer-brand { font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 700; color: var(--cp-brown); }
        .footer-desc { font-size: 0.85rem; color: var(--cp-muted); max-width: 260px; }
        .footer-copy { font-size: 0.78rem; color: var(--cp-muted); }

        .badge-pastry { background-color: #E8D5F5; color: #6A3D9A; font-weight: 700; font-size: 0.72rem; letter-spacing: 0.05em; border-radius: 12px; padding: 0.3em 0.75em; }
        .badge-cookies { background-color: var(--cp-beige); color: var(--cp-brown); font-weight: 700; font-size: 0.72rem; letter-spacing: 0.05em; border-radius: 12px; padding: 0.3em 0.75em; }
        .badge-traditional { background-color: #D4EDDA; color: #1A5C2E; font-weight: 700; font-size: 0.72rem; letter-spacing: 0.05em; border-radius: 12px; padding: 0.3em 0.75em; }

        .recipe-card { background: #fff; border: 1.5px solid var(--cp-border); border-radius: 20px; overflow: hidden; transition: transform 0.25s ease, box-shadow 0.25s ease; box-shadow: 0 2px 10px var(--cp-shadow); height: 100%; }
        .recipe-card:hover { transform: translateY(-6px); box-shadow: 0 12px 32px var(--cp-shadow-md); }
        .recipe-card-img { height: 200px; object-fit: cover; width: 100%; background-color: var(--cp-beige); }
        .recipe-card-img-placeholder { height: 200px; background: linear-gradient(135deg, var(--cp-pink-light), var(--cp-beige)); display: flex; align-items: center; justify-content: center; font-size: 3rem; }
        .recipe-card-body { padding: 1.25rem 1.4rem 1.5rem; }
        .recipe-card-title { font-family: 'Playfair Display', serif; font-size: 1.08rem; font-weight: 600; color: var(--cp-brown); margin-bottom: 0.5rem; line-height: 1.3; }

        .btn-cp-primary { background: linear-gradient(135deg, var(--cp-pink), var(--cp-pink-dark)); color: #fff; border: none; border-radius: 25px; padding: 0.55rem 1.5rem; font-weight: 700; font-size: 0.9rem; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 3px 10px rgba(217,127,143,0.35); }
        .btn-cp-primary:hover { color: #fff; transform: translateY(-2px); box-shadow: 0 6px 18px rgba(217,127,143,0.5); }
        .btn-cp-outline { background: transparent; color: var(--cp-brown); border: 1.5px solid var(--cp-beige-dark); border-radius: 25px; padding: 0.55rem 1.5rem; font-weight: 400; font-size: 0.9rem; transition: background 0.2s, border-color 0.2s; }
        .btn-cp-outline:hover { background: var(--cp-beige); border-color: var(--cp-pink); color: var(--cp-brown); }
        .btn-cp-danger { background: transparent; color: #C0392B; border: 1.5px solid #E5A09A; border-radius: 25px; padding: 0.55rem 1.5rem; font-weight: 400; font-size: 0.9rem; transition: background 0.2s; }
        .btn-cp-danger:hover { background: #FDECEA; color: #922B21; }

        .btn-eye { position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--cp-muted); cursor: pointer; padding: 0; font-size: 1rem; line-height: 1; }
        .btn-eye:hover { color: var(--cp-brown); }

        .form-control-cp, .form-select-cp { border: 1.5px solid var(--cp-border); border-radius: 12px; padding: 0.65rem 1rem; font-family: 'Lato', sans-serif; background-color: #fff; color: var(--cp-text); transition: border-color 0.2s, box-shadow 0.2s; }
        .form-control-cp:focus, .form-select-cp:focus { border-color: var(--cp-pink); box-shadow: 0 0 0 0.2rem rgba(242,167,181,0.25); outline: none; }
        .form-control-cp.is-invalid, .form-select-cp.is-invalid { border-color: #dc3545; }
        .form-label-cp { font-weight: 700; font-size: 0.85rem; color: var(--cp-brown); margin-bottom: 0.4rem; letter-spacing: 0.03em; }
        .form-hint { font-size: 0.78rem; color: var(--cp-muted); margin-top: 0.3rem; }

        .alert-cp-success { background-color: #F0FBF4; border: 1.5px solid #A8DDB5; border-radius: 14px; color: #1B6B38; font-size: 0.9rem; padding: 0.9rem 1.2rem; }
        .alert-cp-error { background-color: #FEF0EF; border: 1.5px solid #F5B7B1; border-radius: 14px; color: #922B21; font-size: 0.9rem; padding: 0.9rem 1.2rem; }

        .cp-divider { display: flex; align-items: center; gap: 1rem; margin: 2rem 0; }
        .cp-divider::before, .cp-divider::after { content: ''; flex: 1; height: 1px; background: var(--cp-border); }
        .cp-divider-icon { color: var(--cp-pink); font-size: 1.2rem; }

        .page-hero { background: linear-gradient(135deg, var(--cp-pink-light) 0%, var(--cp-beige) 50%, var(--cp-cream) 100%); padding: 3.5rem 0 2.5rem; border-bottom: 2px solid var(--cp-border); position: relative; overflow: hidden; }
        .page-hero::before { content: '🎂'; position: absolute; font-size: 8rem; opacity: 0.07; right: 5%; top: 50%; transform: translateY(-50%); }
        .page-hero-title { font-family: 'Playfair Display', serif; font-size: 2.2rem; font-weight: 700; color: var(--cp-brown); margin-bottom: 0.4rem; }
        .page-hero-sub { font-size: 0.95rem; color: var(--cp-muted); }

        .filter-bar { background: #fff; border: 1.5px solid var(--cp-border); border-radius: 16px; padding: 1rem 1.25rem; box-shadow: 0 2px 8px var(--cp-shadow); }
        .filter-chip { display: inline-block; padding: 0.35rem 1rem; border-radius: 20px; border: 1.5px solid var(--cp-border); font-size: 0.82rem; font-weight: 700; cursor: pointer; text-decoration: none; color: var(--cp-brown); background: var(--cp-white); transition: background 0.2s, border-color 0.2s; }
        .filter-chip:hover, .filter-chip.active { background: var(--cp-pink-light); border-color: var(--cp-pink); color: var(--cp-brown); }

        .cp-card { background: #fff; border: 1.5px solid var(--cp-border); border-radius: 20px; padding: 2rem 2.25rem; box-shadow: 0 2px 10px var(--cp-shadow); }

        .ingredient-list { list-style: none; padding: 0; margin: 0; }
        .ingredient-list li { padding: 0.55rem 0; border-bottom: 1px dashed var(--cp-border); font-size: 0.92rem; color: var(--cp-text); display: flex; align-items: flex-start; gap: 0.6rem; }
        .ingredient-list li:last-child { border-bottom: none; }
        .ingredient-list li::before { content: '✦'; color: var(--cp-pink-dark); flex-shrink: 0; font-size: 0.7rem; margin-top: 0.3rem; }

        .instruction-list { list-style: none; padding: 0; margin: 0; counter-reset: step-counter; }
        .instruction-list li { counter-increment: step-counter; display: flex; gap: 1rem; padding: 0.9rem 0; border-bottom: 1px dashed var(--cp-border); font-size: 0.93rem; }
        .instruction-list li:last-child { border-bottom: none; }
        .instruction-list li::before { content: counter(step-counter); display: flex; align-items: center; justify-content: center; min-width: 30px; height: 30px; background: var(--cp-pink); color: #fff; border-radius: 50%; font-weight: 700; font-size: 0.8rem; flex-shrink: 0; margin-top: 0.1rem; }

        .detail-img { border-radius: 20px; width: 100%; object-fit: cover; max-height: 420px; box-shadow: 0 4px 20px var(--cp-shadow-md); }
        .detail-img-placeholder { border-radius: 20px; width: 100%; height: 320px; background: linear-gradient(135deg, var(--cp-pink-light), var(--cp-beige)); display: flex; align-items: center; justify-content: center; font-size: 5rem; box-shadow: 0 4px 20px var(--cp-shadow-md); }

        .pagination .page-link { border: 1.5px solid var(--cp-border); color: var(--cp-brown); border-radius: 10px !important; margin: 0 2px; font-size: 0.87rem; }
        .pagination .page-link:hover { background-color: var(--cp-pink-light); border-color: var(--cp-pink); }
        .pagination .page-item.active .page-link { background: linear-gradient(135deg, var(--cp-pink), var(--cp-pink-dark)); border-color: var(--cp-pink-dark); color: #fff; }

        .empty-state { text-align: center; padding: 4rem 1rem; }
        .empty-state-icon { font-size: 4rem; margin-bottom: 1rem; opacity: 0.5; }

        @media (max-width: 768px) {
            .page-hero-title { font-size: 1.6rem; }
            .cp-card { padding: 1.25rem 1rem; }
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- ========== NAVBAR ========== --}}
    <nav class="navbar navbar-expand-lg navbar-cakepedia sticky-top">
        <div class="container">
            <a class="navbar-brand-logo" href="{{ route('recipes.index') }}">
                <div class="brand-icon">🍰</div>
                <div>
                    <div class="brand-text">CakePedia</div>
                    <div class="brand-sub">Ensiklopedia Resep Kue</div>
                </div>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav ms-auto align-items-center gap-1">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link nav-link-cp {{ request()->routeIs('recipes.index') ? 'active' : '' }}"
                                href="{{ route('recipes.index') }}">
                                <i class="bi bi-house-heart me-1"></i>Beranda
                            </a>
                        </li>

                        {{-- What Can I Bake? HANYA untuk member --}}
                        @if(auth()->user()->role !== 'admin')
                        <li class="nav-item">
                            <a class="nav-link nav-link-cp {{ request()->routeIs('what-can-i-bake') ? 'active' : '' }}"
                                href="{{ route('what-can-i-bake') }}">
                                <i class="bi bi-magic me-1"></i>What Can I Bake?
                            </a>
                        </li>
                        @endif

                        {{-- Tambah Resep HANYA untuk Admin --}}
                        @if(auth()->user()->role === 'admin')
                        <li class="nav-item ms-2 me-2">
                            <a class="nav-link-cp btn-nav-add" href="{{ route('recipes.create') }}">
                                <i class="bi bi-plus-lg me-1"></i>Tambah Resep
                            </a>
                        </li>
                        @endif

                        {{-- Dropdown Profil --}}
                        <li class="nav-item dropdown ms-2">
                            <a class="nav-link dropdown-toggle fw-bold px-3 py-2" href="#" data-bs-toggle="dropdown"
                               style="background-color: var(--cp-beige); color: var(--cp-brown); border-radius: 20px; font-size: 0.9rem;">
                                Halo, {{ explode(' ', auth()->user()->name)[0] }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm"
                                style="border-radius: 16px; border: 1.5px solid var(--cp-border) !important;">

                                {{-- Profil Saya — semua role, selalu paling atas --}}
                                <li>
                                    <a class="dropdown-item py-2 text-dark" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person-gear me-2" style="color:var(--cp-pink-dark);"></i>Profil Saya
                                    </a>
                                </li>

                                {{-- Koleksi Saya — hanya member --}}
                                @if(auth()->user()->role !== 'admin')
                                <li>
                                    <a class="dropdown-item py-2 text-dark" href="{{ route('bookmarks.index') }}">
                                        <i class="bi bi-bookmark-heart text-danger me-2"></i>Koleksi Saya
                                    </a>
                                </li>
                                @endif

                                {{-- Daftar Member — hanya admin --}}
                                @if(auth()->user()->role === 'admin')
                                <li>
                                    <a class="dropdown-item py-2 text-dark" href="{{ route('admin.members') }}">
                                        <i class="bi bi-people me-2" style="color:var(--cp-pink-dark);"></i>Daftar Member
                                    </a>
                                </li>
                                @endif

                                <li><hr class="dropdown-divider" style="border-color: var(--cp-border);"></li>

                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 fw-bold" style="color: #C0392B;">
                                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- ========== FLASH MESSAGES ========== --}}
    @if (session('success'))
        <div class="container mt-3">
            <div class="alert-cp-success d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="container mt-3">
            <div class="alert-cp-error d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    {{-- ========== MAIN CONTENT ========== --}}
    <main>
        @yield('content')
    </main>

    {{-- ========== FOOTER ========== --}}
    <footer class="footer-cp">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="footer-brand mb-1">🍰 CakePedia</div>
                    <p class="footer-desc mb-0">
                        Kumpulan resep kue terbaik — dari pastry Prancis, cookies renyah,
                        hingga camilan tradisional Nusantara.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="footer-copy mb-0">
                        &copy; {{ date('Y') }} CakePedia
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const alerts = document.querySelectorAll('[data-bs-dismiss="alert"]');
            setTimeout(() => {
                alerts.forEach(btn => {
                    const alert = btn.closest('[role="alert"]');
                    if (alert) {
                        alert.style.transition = 'opacity 0.5s';
                        alert.style.opacity = '0';
                        setTimeout(() => alert.remove(), 500);
                    }
                });
            }, 4000);
        });
    </script>

    @stack('scripts')
</body>
</html>