@php
    $replyTo = null;
    if ($comment->reply_to_user_id) {
        $user = App\Models\User::find($comment->reply_to_user_id);
        if ($user) $replyTo = $user->name;
    }

    $replyField = "comment_body_reply_{$comment->id}";
    $shouldOpenReplyForm = $errors->has($replyField);

    $shouldOpenRepliesBox = false;
    foreach ($comment->replies as $reply) {
        if ($errors->has("comment_body_reply_{$reply->id}")) {
            $shouldOpenRepliesBox = true;
            break;
        }
    }
@endphp


<div class="p-2 mb-2 bg-yellow-light rounded-3">
    {{-- ユーザー --}}
    <div class="d-flex align-items-start justify-content-between">
        <div class="d-flex align-items-start">
            <a href="{{ route('profile.show', $comment->user->id) }}">
                @if ($comment->user->avatar)
                    <img src="{{ $comment->user->avatar }}" class="rounded-circle me-2"
                         style="width:32px; height:32px; object-fit:cover;">
                @else
                    <i class="fa-solid fa-circle-user text-secondary me-2" style="font-size:32px;"></i>
                @endif
            </a>

            <a href="{{ route('profile.show', $comment->user->id) }}"
               class="text-brown text-decoration-none"
               style="position: relative; top:3px;">
                {{ $comment->user->name }}
            </a>
        </div>

        {{-- 削除 --}}
        @if ($comment->user_id === auth()->id())
            <form action="{{ route('comment.destroy', $comment->id) }}" method="POST">
                @csrf @method('DELETE')
                <button class="btn p-1 bg-transparent border-0">
                    <i class="fa-regular fa-trash-can text-danger"></i>
                </button>
            </form>
        @endif
    </div>

    {{-- 本文 --}}
    <span class="text-brown d-block"
          style="font-size:1.1rem; margin-left:40px; margin-right:10px;">
        @if($replyTo)
            <a href="{{ route('profile.show', $comment->reply_to_user_id) }}"
               class="text-decoration-none">
                <strong style="color: rgb(82,168,244);">{{ '@'.$replyTo }}&nbsp;</strong>
            </a>
        @endif

        {{ $comment->content }}
    </span>

    {{-- Reply + 投稿日時 --}}
    <div class="row">
        <div class="col mt-1">
            <button class="btn btn-link btn-sm brand p-0 text-secondary fw-bold"
                    style="margin-left:40px;"
                    onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.toggle('d-none')">
                Reply
            </button>
        </div>

        <div class="col text-end small text-secondary mt-1 mx-2">
            {{ $comment->created_at->format('M d, Y') }}
        </div>
    </div>

    {{-- 返信フォーム --}}
    <div id="reply-form-{{ $comment->id }}" class="{{ $shouldOpenReplyForm ? '' : 'd-none' }} mt-2">
        <form action="{{ route('comment.store', $comment->post_id) }}" method="POST">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
            <input type="hidden" name="reply_to_user_id" value="{{ $comment->user_id }}">

            <div class="input-group">
                <input type="text" name="{{ $replyField }}"
                       class="form-control post-input rounded-start @error($replyField) is-invalid @enderror"
                       placeholder="Reply to {{ $comment->user->name }}"
                       value="{{ old($replyField) }}">
                <button class="btn btn-brown rounded-end" type="submit">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </div>

            @error($replyField)
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </form>
    </div>

    @if (!$comment->parent_id && $comment->replies->count() > 0)
        <div class="ms-5 mt-1">
            <button class="btn btn-link p-0"
                    style="color: rgb(82,168,244);"
                    onclick="document.getElementById('reply-box-{{ $comment->id }}').classList.toggle('d-none')">
                {{ $shouldOpenRepliesBox
                    ? '--- Hide Replies ('.$comment->replies->count().') ---'
                    : '--- View Replies ('.$comment->replies->count().') ---' }}
            </button>
        </div>
    @endif

    @if ($comment->replies->count() > 0)
        <div id="reply-box-{{ $comment->id }}"
             class="{{ $shouldOpenRepliesBox || $comment->parent_id ? '' : 'd-none' }} mt-2" style="margin-left: 30px">
             
            @foreach ($comment->replies as $reply)
                @include('components.comment', ['comment' => $reply])
            @endforeach
        </div>
    @endif
</div>

