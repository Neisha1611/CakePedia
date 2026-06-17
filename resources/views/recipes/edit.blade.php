@extends('layouts.app')

@section('title', 'Edit: ' . $recipe->title)

@section('content')

    {{-- ========== HERO ========== --}}
    <section class="page-hero" style="padding:2.5rem 0 2rem;">
        <div class="container">
            <nav aria-label="breadcrumb" class="mb-2">
                <ol class="breadcrumb" style="font-size:0.82rem;">
                    <li class="breadcrumb-item">
                        <a href="{{ route('recipes.index') }}" style="color:var(--cp-pink-dark);">
                            <i class="bi bi-house-heart me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('recipes.show', $recipe) }}" style="color:var(--cp-pink-dark);">
                            {{ Str::limit($recipe->title, 30) }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" style="color:var(--cp-muted);">Edit</li>
                </ol>
            </nav>
            <h1 class="page-hero-title" style="font-size:1.9rem;">
                <i class="bi bi-pencil-square me-2" style="color:var(--cp-pink-dark);"></i>Edit Resep
            </h1>
            <p class="page-hero-sub">Perbarui informasi resep "{{ $recipe->title }}"</p>
        </div>
    </section>

    {{-- ========== FORM ========== --}}
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">

                @if ($errors->any())
                    <div class="alert-cp-error mb-4">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <strong>Mohon periksa kembali isian berikut:</strong>
                        </div>
                        <ul class="mb-0 ps-3" style="font-size:0.85rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('recipes.update', $recipe) }}" method="POST" id="editForm">
                    @csrf
                    @method('PUT')

                    {{-- ===== SECTION: Informasi Dasar ===== --}}
                    <div class="cp-card mb-4">
                        <h5 style="margin-bottom:1.5rem;">Informasi Dasar</h5>

                        <div class="mb-4">
                            <label for="title" class="form-label-cp">
                                Judul Resep <span style="color:var(--cp-pink-dark);">*</span>
                            </label>
                            <input type="text"
                                   id="title"
                                   name="title"
                                   class="form-control-cp w-100 @error('title') is-invalid @enderror"
                                   value="{{ old('title', $recipe->title) }}"
                                   maxlength="255">
                            @error('title')
                                <div class="invalid-feedback d-block" style="font-size:0.8rem; color:#C0392B;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label-cp">
                                Kategori <span style="color:var(--cp-pink-dark);">*</span>
                            </label>
                            <select id="category"
                                    name="category"
                                    class="form-select-cp w-100 @error('category') is-invalid @enderror">
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat }}"
                                        {{ old('category', $recipe->category) === $cat ? 'selected' : '' }}>
                                        @if ($cat === 'Pastry') 🥐
                                        @elseif ($cat === 'Cookies') 🍪
                                        @else 🍡
                                        @endif
                                        {{ $cat }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="invalid-feedback d-block" style="font-size:0.8rem; color:#C0392B;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    {{-- ===== SECTION: Gambar ===== --}}
                    <div class="cp-card mb-4">
                        <h5 style="margin-bottom:1.5rem;">Gambar Resep</h5>

                        <div class="mb-2">
                            <label for="image_url" class="form-label-cp">URL Gambar</label>
                            <input type="url"
                                   id="image_url"
                                   name="image_url"
                                   class="form-control-cp w-100 @error('image_url') is-invalid @enderror"
                                   placeholder="https://example.com/gambar-kue.jpg"
                                   value="{{ old('image_url', $recipe->image_url) }}">
                            @error('image_url')
                                <div class="invalid-feedback d-block" style="font-size:0.8rem; color:#C0392B;">
                                    {{ $message }}
                                </div>
                            @enderror
                            <p class="form-hint">Opsional. Biarkan kosong untuk menghapus gambar.</p>
                        </div>

                        <div id="imagePreviewWrapper"
                             style="{{ old('image_url', $recipe->image_url) ? '' : 'display:none;' }} margin-top:1rem;">
                            <p class="form-hint mb-2">Preview:</p>
                            <img id="imagePreview"
                                 src="{{ old('image_url', $recipe->image_url) }}"
                                 alt="Preview"
                                 style="width:100%; max-height:220px; object-fit:cover; border-radius:12px; border:1.5px solid var(--cp-border);">
                        </div>
                    </div>

                    {{-- ===== SECTION: Bahan-Bahan ===== --}}
                    <div class="cp-card mb-4">
                        <h5 style="margin-bottom:0.4rem;">
                            Bahan-Bahan <span style="color:var(--cp-pink-dark);">*</span>
                        </h5>
                        <p class="form-hint mb-3">Tulis satu bahan per baris.</p>

                        <textarea id="ingredients"
                                  name="ingredients"
                                  class="form-control-cp w-100 @error('ingredients') is-invalid @enderror"
                                  rows="10">{{ old('ingredients', $recipe->ingredients) }}</textarea>
                        @error('ingredients')
                            <div class="invalid-feedback d-block" style="font-size:0.8rem; color:#C0392B;">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- ===== SECTION: Cara Membuat ===== --}}
                    <div class="cp-card mb-4">
                        <h5 style="margin-bottom:0.4rem;">
                            Cara Membuat <span style="color:var(--cp-pink-dark);">*</span>
                        </h5>
                        <p class="form-hint mb-3">Tulis satu langkah per baris.</p>

                        <textarea id="instructions"
                                  name="instructions"
                                  class="form-control-cp w-100 @error('instructions') is-invalid @enderror"
                                  rows="12">{{ old('instructions', $recipe->instructions) }}</textarea>
                        @error('instructions')
                            <div class="invalid-feedback d-block" style="font-size:0.8rem; color:#C0392B;">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- ===== ACTION BUTTONS ===== --}}
                    <div class="d-flex gap-3 justify-content-end flex-wrap mb-3">
                        <a href="{{ route('recipes.show', $recipe) }}" class="btn-cp-outline">
                            <i class="bi bi-x-lg me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn-cp-primary" id="updateBtn">
                            <i class="bi bi-check2-circle me-2"></i>Simpan Perubahan
                        </button>
                    </div>

                </form>

                {{-- Form hapus di LUAR form edit --}}
                <form action="{{ route('recipes.destroy', $recipe) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus resep ini secara permanen?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-cp-danger">
                        <i class="bi bi-trash3 me-2"></i>Hapus Resep
                    </button>
                </form>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    const imageUrlInput  = document.getElementById('image_url');
    const imagePreview   = document.getElementById('imagePreview');
    const previewWrapper = document.getElementById('imagePreviewWrapper');

    function updatePreview() {
        const url = imageUrlInput.value.trim();
        if (url) {
            imagePreview.src = url;
            previewWrapper.style.display = 'block';
            imagePreview.onerror = () => { previewWrapper.style.display = 'none'; };
        } else {
            previewWrapper.style.display = 'none';
        }
    }

    imageUrlInput.addEventListener('input', updatePreview);

    document.getElementById('editForm').addEventListener('submit', function () {
        const btn = document.getElementById('updateBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
    });
</script>
@endpush