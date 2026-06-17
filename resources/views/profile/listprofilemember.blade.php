@extends('layouts.app')

@section('title', 'Daftar Member — CakePedia')

@push('styles')
<style>
    .members-hero {
        background: linear-gradient(135deg, var(--cp-pink-light) 0%, var(--cp-beige) 60%, var(--cp-cream) 100%);
        padding: 3.5rem 0 2.5rem;
        border-bottom: 2px solid var(--cp-border);
        position: relative;
        overflow: hidden;
    }
    .members-hero::before {
        content: '👥';
        position: absolute;
        font-size: 9rem;
        opacity: 0.06;
        right: 4%;
        top: 50%;
        transform: translateY(-50%);
    }
    .members-hero-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--cp-brown);
        margin-bottom: 0.4rem;
    }
    .members-hero-sub {
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
    .members-table {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        border: 1.5px solid var(--cp-border);
    }
    .members-table table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }
    .members-table thead {
        background: var(--cp-cream);
    }
    .members-table thead th {
        padding: 1rem 1.25rem;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--cp-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1.5px solid var(--cp-border);
    }
    .members-table tbody tr {
        border-bottom: 1px solid var(--cp-border);
        transition: background 0.15s;
    }
    .members-table tbody tr:last-child {
        border-bottom: none;
    }
    .members-table tbody tr:hover {
        background: var(--cp-cream);
    }
    .members-table tbody td {
        padding: 1rem 1.25rem;
        font-size: 0.9rem;
        color: var(--cp-brown);
        vertical-align: middle;
    }
    .member-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--cp-pink), var(--cp-pink-dark));
        color: #fff;
        font-weight: 700;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .member-email {
        font-size: 0.8rem;
        color: var(--cp-muted);
    }
    .badge-member {
        background: var(--cp-pink-light);
        color: var(--cp-pink-dark);
        border-radius: 20px;
        padding: 0.2rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 700;
    }
    .members-empty {
        text-align: center;
        padding: 4rem 1rem;
        color: var(--cp-muted);
    }
</style>
@endpush

@section('content')

<section class="members-hero">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb" style="font-size:0.82rem;">
                <li class="breadcrumb-item">
                    <a href="{{ route('recipes.index') }}" style="color:var(--cp-pink-dark);">
                        <i class="bi bi-house-heart me-1"></i>Beranda
                    </a>
                </li>
                <li class="breadcrumb-item active" style="color:var(--cp-muted);">Daftar Member</li>
            </ol>
        </nav>
        <h1 class="members-hero-title">
            <i class="bi bi-people me-2" style="color:var(--cp-pink-dark);"></i>Daftar Member
        </h1>
        <p class="members-hero-sub">Semua akun member yang terdaftar di CakePedia.</p>
    </div>
</section>

<div class="container py-5">

    <div class="mb-4">
        <span class="stat-pill">
            <i class="bi bi-people-fill" style="color:var(--cp-pink-dark);"></i>
            {{ $members->total() }} member terdaftar
        </span>
    </div>

    <div class="members-table">
        @if($members->isEmpty())
            <div class="members-empty">
                <div style="font-size:3rem; margin-bottom:1rem; opacity:0.4;">👤</div>
                <p>Belum ada member yang terdaftar.</p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Member</th>
                        <th>Bergabung</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $index => $member)
                        <tr>
                            <td style="color:var(--cp-muted); font-size:0.82rem;">
                                {{ $members->firstItem() + $index }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="member-avatar">
                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight:700;">{{ $member->name }}</div>
                                        <div class="member-email">{{ $member->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="color:var(--cp-muted); font-size:0.85rem;">
                                {{ $member->created_at->format('d M Y') }}
                            </td>
                            <td>
                                <span class="badge-member">Member</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    @if($members->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $members->links() }}
        </div>
    @endif

</div>

@endsection