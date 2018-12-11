<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function index()
    {
      $comments = Comment::all();
      return view('admin.comments.index', compact('comments'));
    }
    public function toogle($id)
    {
        $comment = Comment::find($id);
        $comment->toogleStatus();
        return redirect()->back();
    }
    public function delete($id)
    {
      Comment::find($id)->delete();
      return redirect()->back();
    }
}
