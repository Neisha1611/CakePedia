<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    // Konstruktor untuk memastikan hanya user logged in yang bisa akses bookmark
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Menampilkan halaman koleksi resep milik user
    public function index()
    {
        $userId = Auth::id();
        $bookmarkedRecipes = Recipe::whereHas('bookmarks', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->paginate(9);

        return view('recipes.bookmarks', compact('bookmarkedRecipes'));
    }

    // Logika Simpan atau Hapus Bookmark (Toggle)
    public function toggle(Request $request)
    {
        $request->validate([
            'recipe_id' => 'required|exists:recipes,id'
        ]);

        $userId = Auth::id();
        $recipeId = $request->recipe_id;

        $existingBookmark = Bookmark::where('user_id', $userId)
                                    ->where('recipe_id', $recipeId)
                                    ->first();

        if ($existingBookmark) {
            $existingBookmark->delete();
            return redirect()->back()->with('success', 'Resep berhasil dihapus dari Koleksi Saya.');
        } else {
            Bookmark::create([
                'user_id' => $userId,
                'recipe_id' => $recipeId
            ]);
            return redirect()->back()->with('success', 'Resep berhasil disimpan ke Koleksi Saya!');
        }
    }
}