<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function store(Request $request, $post_id)
    {

        $field = 'comment_body'.$post_id;

        $request->validate([
            $field => 'required|max:150',
        ],
            [
                $field.'.required' => 'You cannot submit an empty comment.',
                $field.'.max' => 'The comment must not have more than 150 characters.',
            ]);

        $this->comment->content = $request->input('comment_body'.$post_id);
        $this->comment->user_id = Auth::id();
        $this->comment->post_id = $post_id;
        $this->comment->save();

        return redirect()->route('post.show', $post_id);
    }

    public function destroy($id)
    {
        $comment = $this->comment->findOrFail($id);

        if ($comment->user_id !== Auth::id()) {
            abort(403);
        }

        $comment->delete();

        return back();
    }
}
