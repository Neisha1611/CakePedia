<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'recipe_id' => 'required|exists:recipes,id',
            'body'      => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ], [
            'body.required' => 'Komentar tidak boleh kosong.',
            'body.max'      => 'Komentar maksimal 1000 karakter.',
        ]);

        Comment::create([
            'recipe_id' => $request->recipe_id,
            'user_id'   => auth()->id(),
            'parent_id' => $request->parent_id ?? null,
            'body'      => $request->body,
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil dikirim!');
    }

    public function destroy(Comment $comment)
    {
        // Hanya admin yang bisa hapus komentar
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
    }
}