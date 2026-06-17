<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Comment;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'recipe_id' => 'required|exists:recipes,id',
            'score'     => 'required|integer|min:1|max:5',
            'body'      => 'nullable|string|max:1000',
        ], [
            'score.required' => 'Pilih bintang terlebih dahulu.',
            'body.max'       => 'Komentar maksimal 1000 karakter.',
        ]);

        // Update kalau sudah pernah rating, buat baru kalau belum
        Rating::updateOrCreate(
            ['recipe_id' => $request->recipe_id, 'user_id' => auth()->id()],
            ['score' => $request->score]
        );

        // Kalau ada komentar, simpan ke tabel comments
        if (!empty($request->body)) {
            // Cek apakah user sudah pernah komentar di resep ini lewat form rating
            $existing = Comment::where('recipe_id', $request->recipe_id)
                ->where('user_id', auth()->id())
                ->whereNull('parent_id')
                ->where('from_rating', true)
                ->first();

            if ($existing) {
                $existing->update(['body' => $request->body]);
            } else {
                Comment::create([
                    'recipe_id'   => $request->recipe_id,
                    'user_id'     => auth()->id(),
                    'parent_id'   => null,
                    'body'        => $request->body,
                    'from_rating' => true,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Terimakasih atas penilaiannya!');
    }
}