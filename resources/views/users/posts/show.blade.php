@extends('layouts.app')

@section('title', 'Show Post')

@section('content')
<style>
    /* .uniform-img {
        height: 650px; 
        object-fit: cover;
        width: 100%;
    } */

    /* .uniform-img-img {
    height: 650px;
    width: 100%;
    object-fit: cover;
    background: #000;
    } */

    /* .uniform-img-video {
    height: 650px;
    width: 100%;
    background: black; 
    } */

    .media-frame {
        width: 100%;
        height: 650px;
        background: #000;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        position: relative;
    }

    .media-frame img {
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .media-frame video {
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: auto;
        object-fit: contain;
        display: block;
    }

    @media (max-width: 768px) {

        .media-frame {
            width: 100%;
            max-width: 100vw;
            height: 100;
            max-height: calc(100vw * 1.25);  /* ← これが 4:5 の制限 */
            background: #000;
            overflow: hidden;                /* 超重要：4:5 超えたら切る */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .media-frame img{
            width: 100%;
            height: auto;
            max-height: calc(100vw * 1.25);
            object-fit: cover;
            object-position: center center;
            background: #000;
        }

        .media-frame video {
            width: 100%;
            height: auto;
            max-height: calc(100vw * 1.25);
            object-fit: cover;
            object-position: center center;
            background: #000;
        }

        #postCarousel .carousel-item {
            background: #000;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            max-height: calc(100vw * 1.25); /* 4:5 に統一 */
        }


    }

    .text-brown {
        color: #9F6B46 !important;
    }

    .btn-brown {
        background-color: #ac8161;
        color: #fff;
        border: none;
    }

    .btn-brown:hover {
        background-color: #956441;
        color: #fff
    }

    .bg-yellow-light {
        background-color: #FFFBEB!important;
    }

    .comment-section-wrapper {
        display: flex;
        flex-direction: column;
        height: 100%; 
    }

    .comment-list {
        flex: 1;
        overflow-y: auto;
        padding-right: 6px;
        min-height: 150px;
    }
</style>

    <div class="container">
        <div class="justify-content-center">
            <div class="card border shadow rounded-2 overflow-hidden">
                <div class="card-header py-3 border-bottom" style="background-color:#fbefe5;">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto d-flex align-items-center">
                            <a href="{{ route('profile.show', $post->user->id) }}">
                                 @if ($post->user->avatar)
                                    <img src="{{ $post->user->avatar }}" 
                                        alt="{{ $post->user->name }}" 
                                        class="rounded-circle me-3" 
                                        style="width:40px; height:40px; object-fit:cover;">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary me-3" style="font-size: 2rem;"></i>
                                @endif
                            </a>

                            <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none fw-bold text-brown fs-5">
                                {{ $post->user->name }}
                            </a>
                        </div>

                        <div class="col-auto d-flex align-items-center">
                           {{-- 投稿者本人なら編集・削除 --}}
                            @if (auth()->id() === $post->user_id)
                                <div class="dropdown">
                                    <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                                        <i class="fa-solid fa-ellipsis text-brown"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end shadow-sm">
                                        <a href="{{ route('post.edit', ['id' => $post->id]) }}" class="dropdown-item text-brown">
                                            <i class="fa-regular fa-pen-to-square me-2"></i>
                                            {{ __('messages.show_post.edit') }}
                                        </a>
                                        
                                        <button class="dropdown-item text-danger" data-bs-toggle="modal"
                                            data-bs-target="#delete-post-{{ $post->id }}">
                                            <i class="fa-regular fa-trash-can me-2"></i>
                                            {{ __('messages.show_post.delete') }}
                                        </button>
                                    </div>
                                     @include('users.posts.modals.delete')
                                </div>

                            {{-- 投稿者本人以外ならフォロー／フォロー解除 --}}
                            @elseif (auth()->check() && auth()->id() !== $post->user_id)
                                @if (auth()->user()->isFollowing($post->user_id))
                                    <form action="{{ route('follow.destroy', $post->user_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="return_url" value="{{ url()->full() }}">
                                        <button type="submit" class="btn btn-cancel btn-md fw-bold">Following</button>
                                    </form>
                                @else 
                                    <form action="{{ route('follow.store', $post->user_id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="return_url" value="{{ url()->full() }}">
                                        <button type="submit" class="btn btn-outline btn-md fw-bold">Follow</button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body bg-white p-0">
                    <div class="row g-0">
                       <div class="col-md-7">                              
                            @php
                                $mediaItems = $post->media;
                            @endphp

                            @if ($mediaItems->count() > 0 )
                                @if ($mediaItems->count() > 1)
                                    <div id="postCarousel{{$post->id}}" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            @foreach ($mediaItems as $index => $media)
                                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                    <div class="media-frame">
                                                        @if ($media->type === 'image')
                                                            <img src="{{ asset('storage/' . $media->path) }}" alt="image">
                                                        @else
                                                            <video src="{{ asset('storage/' . $media->path) }}" playsinline muted></video>
                                                            <div class="play-pause-btn">
                                                                <i class="fa-solid fa-play"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#postCarousel{{$post->id}}" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon"></span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#postCarousel{{$post->id}}" data-bs-slide="next">
                                            <span class="carousel-control-next-icon"></span>
                                        </button>
                                    </div>
                                @elseif($mediaItems->count() === 1)
                                    @php
                                        $media = $mediaItems->first();
                                    @endphp
                                    <div class="media-frame">
                                        @if ($media->type === 'image')
                                            <img src="{{ asset('storage/' . $media->path) }}">
                                        @else
                                            <video src="{{ asset('storage/' . $media->path) }}" playsinline muted></video>
                                            <div class="play-pause-btn">
                                                <i class="fa-solid fa-play"></i>
                                            </div>
                                        @endif
                                    </div>
                                        {{-- Image --}}
                                    {{-- @if ($media->type === 'image')
                                        <img 
                                            src="{{ asset('storage/' . $media->path) }}" 
                                            class="d-block uniform-img-img" 
                                            alt="Post image"> --}}
                                        {{-- Video --}}
                                    {{-- @elseif( $media->type === 'video')
                                        <div class="video-wrapper">
                                            <video 
                                                src="{{ asset('storage/' . $media->path) }}"
                                                class="d-block uniform-img-video show-video"
                                                playsinline
                                                muted
                                            ></video>
                                            <div class="play-pause-btn">
                                                <i class="fa-solid fa-play"></i>
                                            </div>
                                        </div>
                                    @endif --}}
                                @endif
                            @else
                                <img src="{{ asset('images/no-image.png') }}" alt="No media" class="uniform-img">   
                            @endif

                            @error('image')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-5 border-start border-brown">
                            <div class="p-4 bg-white h-100 comment-section-wrapper" style="max-height: 650px; ">
                                <h4 class="fw-bold text-brown mb-3 text-center fs-2">{{ $post->title ?? 'Title' }}</h4>
                                <div class="row align-items-center mb-3">
                                    <div class="col-auto">
                                        <p class="mb-2 text-brown" style="font-size: 1.3rem;">
                                            <i class="fa-solid fa-location-dot text-danger me-1"></i>  {{ $post->prefecture ? $post->prefecture->name : 'Unknown' }}
                                        </p> 
                                    </div>

                                    <div class="col d-flex justify-content-end align-items-center gap-3">
                                        <div class="d-flex align-items-center">
                                            <button class="like-button btn btn-sm p-0" data-post-id="{{ $post->id }}" data-liked="{{ $post->isLiked() ? 'true' : 'false' }}">
                                                @if ($post->isLiked())
                                                    <i class="fa-solid fa-heart me-1" style="color:#F1BDB2; font-size:18px;"></i>
                                                @else
                                                    <i class="fa-regular fa-heart me-1" style="color:#9F6B46; font-size:18px;"></i>
                                                @endif
                                            </button>
                                            <span class="like-count fw-bold" style="color:#9F6B46 ">{{ $post->likes->count() }}</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-sm shadow-none favorite-btn" data-post-id="{{ $post->id }}" data-favorited="{{ $post->isFavorited() ? 'true' : 'false' }}">
                                                @if ($post->isFavorited())
                                                    <i class="fa-solid fa-star text-warning" style="font-size: 18px;"></i>
                                                @else
                                                    <i class="fa-regular fa-star" style="font-size: 18px;color:#7e5638;"></i>
                                                @endif
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center justify-content-end text-brown small mb-3 gap-3">
                                  <span><i class="fa-regular fa-calendar me-1 text-info"></i>{{ $post->visited_at ? $post->visited_at->format('Y-m-d') : 'Unknown' }}</span>
                                   <span><i class="fa-solid fa-coins me-1 text-warning"></i>
                                    {{ $post->cost ?? 'Cost' }}
                                {{ __('messages.show_post.currentry') }}</span>
                                   <span>
                                    <i class="fa-regular fa-clock me-1 text-secondary"></i>
                                    {{ $post->time_hour }} {{ __('messages.show_post.hour') }}
                                    {{ $post->time_min }} {{ __('messages.show_post.min') }}
                                    @if (!$post->time_hour && !$post->time_min)
                                        Time
                                    @endif
                                    </span>

                                </div>

                                <p class="text-brown mb-3" style="font-size:1.0rem;">
                                  {{ $post->content ?? 'Title' }}
                                </p>

                                <div class="mb-3 text-end" style="display: flex; justify-content: flex-end; flex-wrap: wrap; gap: 8px;">
                                   @foreach ($post->categories as $category)
                                        <span class="category-name fw-bold">
                                            {{ $category->name }}
                                        </span>
                                    @endforeach
                                </div>

                            {{-- 親コメントフォーム --}}
                                <form action="{{ route('comment.store', $post->id) }}" method="POST" class="mb-4">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" 
                                            name="comment_body{{ $post->id }}" 
                                            class="form-control post-input rounded-start @error('comment_body'.$post->id) is-invalid @enderror" 
                                            placeholder="Add a comment..." 
                                            value="{{ old('comment_body'.$post->id) }}">

                                        <button class="btn btn-brown rounded-end">
                                            <i class="fa-solid fa-paper-plane"></i>
                                        </button>
                                    </div>

                                    @error('comment_body'.$post->id)
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </form>


                                {{-- コメント一覧 --}}
                                <div class="comment-list">
                                    @foreach ($post->comments->where('parent_id', null) as $comment)
                                        @include('components.comment', ['comment' => $comment])
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{-- For Favorite button --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const token = document.querySelector('meta[name="csrf-token"]').content;

        document.querySelectorAll('.favorite-btn').forEach(button => {
            button.addEventListener('click', async (e) => {
                e.preventDefault();

                const postId = button.dataset.postId;
                const isFavorited = button.dataset.favorited === 'true';

                const url = isFavorited
                    ? `/favorite/${postId}/destroy`
                    : `/favorite/${postId}/store`;

                const method = isFavorited ? 'DELETE' : 'POST';

                try {
                    const response = await fetch(url, {
                        method: method,
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json',
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        const icon = button.querySelector('i');

                        if (data.favorited) {
                            // ★ register
                            icon.classList.remove('fa-regular');
                            icon.classList.add('fa-solid', 'text-warning');
                            button.dataset.favorited = 'true';
                        } else {
                            // ☆ remove
                            icon.classList.remove('fa-solid', 'text-warning');
                            icon.classList.add('fa-regular');
                            icon.style.color = '#9F6B46';
                            button.dataset.favorited = 'false';
                        }
                    }
                } catch (err) {
                    console.error(err);
                }
            });
        });
    });
</script>

{{-- For Liked button --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {

        document.querySelectorAll('.like-button').forEach(button => {
            button.addEventListener('click', async () => {

                const postId = button.dataset.postId;
                const liked = button.dataset.liked === 'true';

                const url = liked 
                    ? `/like/${postId}/destroy`  // DELETE
                    : `/like/${postId}/store`; // POST same route

                const method = liked ? 'DELETE' : 'POST';

                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    }
                });

                const data = await response.json();

                if (data.success) {

                    const icon = button.querySelector('i');
                    const countElement = button.nextElementSibling;

                    if (data.liked) {
                        icon.classList.remove('fa-regular');
                        icon.classList.add('fa-solid');
                        icon.style.color = '#F1BDB2';
                    } else {
                        icon.classList.remove('fa-solid');
                        icon.classList.add('fa-regular');
                        icon.style.color = '#9F6B46';
                    }

                    countElement.textContent = data.like_count;

                    button.dataset.liked = data.liked ? 'true' : 'false';
                }
            });
        });
    });
</script>

{{-- button for video --}}
<script>
document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.media-frame').forEach(frame => {

        const video = frame.querySelector('video');
        const button = frame.querySelector('.play-pause-btn');
        const icon = button.querySelector('i');

        // 初期状態: ▶️
        icon.classList.remove('fa-pause');
        icon.classList.add('fa-play');

        // ボタンクリック
        button.addEventListener('click', () => {
            if (video.paused) {
                video.play();
                icon.classList.remove('fa-play');
                icon.classList.add('fa-pause');
            } else {
                video.pause();
                icon.classList.remove('fa-pause');
                icon.classList.add('fa-play');
            }
        });

        // 動画クリックでも再生 / 停止
        video.addEventListener('click', () => {
            if (video.paused) {
                video.play();
                icon.classList.remove('fa-play');
                icon.classList.add('fa-pause');
            } else {
                video.pause();
                icon.classList.remove('fa-pause');
                icon.classList.add('fa-play');
            }
        });

        // 動画再生が終了したら ▶️ に戻す
        video.addEventListener('ended', () => {
            icon.classList.remove('fa-pause');
            icon.classList.add('fa-play');
        });

    });

});
</script>
@endsection
