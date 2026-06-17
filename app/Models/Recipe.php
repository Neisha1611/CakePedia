<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    /**
     * Tabel yang digunakan oleh model ini.
     */
    protected $table = 'recipes';

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'title',
        'category',
        'ingredients',
        'instructions',
        'image_url',
    ];

    /**
     * Daftar kategori yang valid.
     */
    public static array $categories = [
        'Pastry',
        'Cookies',
        'Traditional Bites',
    ];

    /**
     * Badge warna Bootstrap untuk tiap kategori.
     */
    public function categoryBadgeClass(): string
    {
        return match ($this->category) {
            'Pastry'            => 'badge-pastry',
            'Cookies'           => 'badge-cookies',
            'Traditional Bites' => 'badge-traditional',
            default             => 'bg-secondary',
        };
    }

    /**
     * Kembalikan ingredients sebagai array baris.
     */
    public function ingredientLines(): array
    {
        return array_filter(
            array_map('trim', explode("\n", $this->ingredients))
        );
    }

    /**
     * Kembalikan instructions sebagai array langkah.
     */
    public function instructionLines(): array
    {
        return array_filter(
            array_map('trim', explode("\n", $this->instructions))
        );
    }

    // ========================================================
    // TAMBAHAN TAHAP 3: RELASI RATING & BOOKMARK
    // ========================================================

    /**
     * Relasi ke tabel Rating
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Relasi ke tabel Bookmark
     */
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    /**
     * Helper untuk menghitung rata-rata rating bintang kue
     */
    public function averageRating()
    {
        return round($this->ratings()->avg('score'), 1) ?? 0;
    }

    public function comments()
    {
        return $this->hasMany(\App\Models\Comment::class)
            ->whereNull('parent_id')
            ->with('user', 'replies.user')
            ->latest();
    }
}