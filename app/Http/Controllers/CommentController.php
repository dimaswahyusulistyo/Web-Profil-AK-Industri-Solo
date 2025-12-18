<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::latest()->get();
        return view('admin.comments.index', compact('comments'));
    }

    public function approve(Comment $comment)
    {
        $comment->update(['is_approved' => true]);
        return back()->with('success','Komentar disetujui');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return back()->with('success','Komentar dihapus');
    }
}
