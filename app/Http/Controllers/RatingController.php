<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'recipe_id' => 'required|exists:recipes,id',
            'score' => 'required|integer|min:1|max:5',
        ]);

        Rating::create([
            'recipe_id' => $request->recipe_id,
            'score' => $request->score,
        ]);

        return redirect()->back()->with('success', 'Terima kasih atas rating bintangnya!');
    }
}