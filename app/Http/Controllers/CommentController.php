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
        $postField = 'comment_body'.$post_id;

        $isReply = $request->filled('parent_id');

        if (! $isReply) {

            $request->validate([
                $postField => 'required|max:150',
            ], [
                $postField.'.required' => 'You cannot submit an empty comment.',
                $postField.'.max' => 'The comment must not have more than 150 characters.',
            ]);

            Comment::create([
                'post_id' => $post_id,
                'user_id' => Auth::id(),
                'content' => $request->$postField,
            ]);

            return redirect()->route('post.show', $post_id);
        }

        $replyField = 'comment_body_reply_'.$request->parent_id;

        $request->validate([
            $replyField => 'required|max:150',
            'parent_id' => 'required|integer|exists:comments,id',
            'reply_to_user_id' => 'nullable|integer|exists:users,id',
        ], [
            $replyField.'.required' => 'Reply cannot be empty.',
            $replyField.'.max' => 'The reply must not exceed 150 characters.',
        ]);

        Comment::create([
            'post_id' => $post_id,
            'user_id' => Auth::id(),
            'content' => $request->$replyField,
            'parent_id' => $request->parent_id,
            'reply_to_user_id' => $request->reply_to_user_id,
        ]);

        return redirect()->route('post.show', $post_id)
            ->with('open_reply', $request->parent_id);
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
