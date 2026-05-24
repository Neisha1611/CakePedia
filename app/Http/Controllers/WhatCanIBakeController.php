<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WhatCanIBakeController extends Controller
{
    /**
     * GET /what-can-i-bake
     *
     * Tampilkan form input bahan-bahan.
     * Jika request memiliki query 'ingredients[]', langsung proses juga
     * (mendukung GET agar URL bisa di-share/bookmark).
     */
    public function index(Request $request): View
    {
        $results      = collect();
        $matchDetails = [];      // [ recipe_id => ['matched' => [...], 'score' => int] ]
        $searched     = false;
        $inputBahans  = [];

        if ($request->has('ingredients')) {
            // ── Sanitasi & filter input kosong ─────────────────────
            $rawInputs   = $request->input('ingredients', []);
            $inputBahans = array_values(
                array_filter(
                    array_map('trim', $rawInputs),
                    fn ($b) => $b !== ''
                )
            );

            if (!empty($inputBahans)) {
                $searched = true;

                // ── Query: ambil resep yang mengandung MINIMAL 1 bahan ──
                //   Kita pakai orWhere + LIKE untuk setiap bahan
                $query = Recipe::query();

                $query->where(function ($q) use ($inputBahans) {
                    foreach ($inputBahans as $bahan) {
                        // Cari bahan di kolom 'ingredients' (case-insensitive di SQLite)
                        $q->orWhere('ingredients', 'LIKE', "%{$bahan}%");
                    }
                });

                $rawResults = $query->get();

                // ── Hitung skor kesesuaian untuk setiap resep ───────
                //   Skor  = jumlah bahan input yang cocok di resep tsb.
                //   Ini dipakai untuk sorting: paling banyak cocok → teratas
                foreach ($rawResults as $recipe) {
                    $matched = [];
                    foreach ($inputBahans as $bahan) {
                        if (stripos($recipe->ingredients, $bahan) !== false) {
                            $matched[] = $bahan;
                        }
                    }
                    $matchDetails[$recipe->id] = [
                        'matched' => $matched,
                        'score'   => count($matched),
                    ];
                }

                // ── Sort: resep dengan skor tertinggi di atas ───────
                $results = $rawResults->sortByDesc(
                    fn ($r) => $matchDetails[$r->id]['score']
                )->values();
            }
        }

        return view('recipes.what-can-i-bake', compact(
            'results',
            'matchDetails',
            'searched',
            'inputBahans'
        ));
    }
}