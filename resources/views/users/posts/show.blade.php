@extends('layouts.app')

@section('title', 'Show Post')

@section('content')
<style>
    .uniform-img {
        height: 600px; 
        object-fit: cover;
        width: 100%;
    }

    .text-brown {
        color: #9F6B46 !important;
    }

    .bg-info-light {
        background-color: #ECF9FF !important;
    }

    .btn-brown {
        background-color: #9F6B46;
        color: #fff;
        border: none;
    }

    .btn-brown:hover {
        background-color: #7e5638;
    }

    .btn-pink {
        background-color: #F1BDB2;
        color: white;
        border: 2px solid #F1BDB2;
        transition: 0.3s;
    }

    .btn-pink:hover {
        background-color: #e6a99c;
        border-color: #e6a99c;
    }

    .btn-outline-pink {
        background-color: transparent;
        color: #F1BDB2;
        border: 2px solid #F1BDB2;
        transition: 0.3s;
    }

    .btn-outline-pink:hover {
        background-color: #F1BDB2;
        color: white;
    }
    
    .form-control:focus {
        border-color: #9F6B46;
        box-shadow: 0 0 0 0.2rem rgba(159, 107, 70, 0.25);
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

    <div class="container mt-3">
        <div class="justify-content-center">
            <a href="{{ url()->previous() ?? url('/') }}" class="text-decoration-none text-brown mb-3 d-inline-block">
                <i class="fa-solid fa-angles-left"></i> back
            </a>

            <div class="card border shadow-sm rounded-2 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom border-brown">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto d-flex align-items-center">
                            <a href="{{ route('profile.show', $post->user->id) }}">
                                 @if (Auth::user()->avatar)
                                    <img src="{{ Auth::user()->avatar }}" 
                                        alt="{{ Auth::user()->name }}" 
                                        class="rounded-circle me-3" 
                                        style="width:50px; height:50px; object-fit:cover;">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary me-3" style="font-size: 2rem;"></i>
                                @endif
                            </a>

                            <a href="{{ route('profile.show', $post->user->id) }}"
                            class="text-decoration-none fw-bold text-brown">
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
                                        <i class="fa-regular fa-pen-to-square me-2"></i>Edit
                                    </a>
                                    <form action="{{ route('post.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fa-regular fa-trash-can me-2"></i>Delete
                                    </button>
                                </form>

                                </div>
                            </div>

                        {{-- 投稿者本人以外ならフォロー／フォロー解除 --}}
                        @elseif (auth()->check() && auth()->id() !== $post->user_id)
                            @if (auth()->user()->isFollowing($post->user_id))
                                <form action="{{ route('follow.destroy', $post->user_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-pink btn-md fw-bold">Following</button>
                                </form>
                            @else 
                                <form action="{{ route('follow.store', $post->user_id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-pink btn-md fw-bold">Follow</button>
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
                                    $images = $post->images->pluck('image')->toArray();
                                @endphp

                                    @if ($images && count($images) > 1)
                                        
                                        <div id="postCarousel" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                @foreach ($images as $index => $img)
                                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                        <img 
                                                            src="{{ asset('storage/' . $img) }}" 
                                                            class="d-block uniform-img" 
                                                            alt="Post image {{ $index + 1 }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#postCarousel" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon"></span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#postCarousel" data-bs-slide="next">
                                                <span class="carousel-control-next-icon"></span>
                                            </button>
                                        </div>

                                    @elseif ($images && count($images) === 1)
                                      
                                        <img 
                                            src="{{ asset('storage/' . $images[0]) }}"
                                            alt="Post image" 
                                            class="uniform-img">

                                    @else
                                       
                                        <img src="{{ asset('images/no-image.png') }}" 
                                            alt="No image" 
                                            class="uniform-img">
                                    @endif

                                    @error('image')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>


                        <div class="col-md-5 border-start border-brown">
                            <div class="p-4 bg-white h-100 comment-section-wrapper" style="max-height: 600px;">
                                <h4 class="fw-bold text-brown mb-2 text-center">{{ $post->title ?? 'Title' }}</h4>

                                <div class="row align-items-center mb-3">
                                    <div class="col-auto">
                                        <p class="mb-2 text-brown">
                                            <i class="fa-solid fa-location-dot text-danger me-1"></i>  {{ $post->prefecture ? $post->prefecture->name : 'Unknown' }}
                                        </p> 
                                    </div>

                                    <div class="col d-flex justify-content-end align-items-center gap-3">
                                        <div class="d-flex align-items-center">
                                            @if ($post->isLiked())
                                                <form action="{{ route('like.destroy', $post->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm p-0">
                                                        <i class="fa-solid fa-heart text-brown me-1"></i>
                                                        <span class="text-brown fw-bold">{{ $post->likes->count() }}</span>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('like.store', $post->id) }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm p-0">
                                                        <i class="fa-regular fa-heart text-brown"></i>
                                                        <span class="text-brown fw-bold">{{ $post->likes->count() }}</span>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fa-regular fa-star text-brown me-1"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center justify-content-end text-brown small mb-3 gap-3">
                                  <span>{{ $post->visited_at ? $post->visited_at->format('Y-m-d') : 'Unknown' }}</span>
                                   <span><i class="fa-solid fa-coins me-1 text-warning"></i>{{ $post->cost ?? 'Cost' }} Yen</span>
                                   <span>
                                    <i class="fa-regular fa-clock me-1 text-secondary"></i>
                                    {{ $post->time_hour ? $post->time_hour . 'h ' : '' }}
                                    {{ $post->time_min ? $post->time_min . 'min' : '' }}
                                    @if (!$post->time_hour && !$post->time_min)
                                        Time
                                    @endif
                                    </span>

                                </div>

                                <p class="text-brown mb-3">
                                  {{ $post->content ?? 'Title' }}
                                </p>

                                <div class="mb-3 text-end" style="display: flex; justify-content: flex-end; flex-wrap: wrap; gap: 8px;">
                                   @foreach ($post->categories as $category)
                                                <span style="
                                                    background-color:rgb(236, 239, 255);
                                                    color:#9F6B46 ;
                                                    border-radius: 12px;
                                                    padding: 2px 8px;
                                                    font-size: 13px;
                                                    font-weight: 500;
                                                ">
                                                    {{ $category->name }}
                                                </span>
                                            @endforeach
                                </div>

                            {{-- コメントフォーム --}}
                            <form action="{{ route('comment.store', $post->id) }}" method="POST" class="input-group mb-4">
                                @csrf
                                <input type="text" 
                                    name="comment_body{{ $post->id }}" 
                                    class="form-control border-brown rounded-start @error('comment_body'.$post->id) is-invalid @enderror" 
                                    placeholder="Add a comment..." 
                                    value="{{ old('comment_body'.$post->id) }}">
                                <button class="btn btn-brown rounded-end" type="submit">
                                    <i class="fa-solid fa-paper-plane"></i>
                                </button>
                                @error('comment_body'.$post->id)
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </form>

                            {{-- コメント一覧 --}}
                            <div class="comment-list">
                                @forelse ($post->comments as $comment)
                                    <div class="p-2 mb-2 bg-yellow-light rounded-3">
                                        <strong class="text-brown">{{ $comment->user->name ?? 'User' }}</strong>
                                      <span class="text-brown small d-block">{{ $comment->content }}</span>
                                        <div class="text-end small text-secondary">
                                            {{ $comment->created_at->format('M d, Y') }}
                                            @if ($comment->user_id === auth()->id())
                                                <form action="{{ route('comment.destroy', $comment->id) }}" 
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn p-0 bg-transparent border-0">
                                                        <i class="fa-regular fa-trash-can ms-2 text-danger"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-secondary small">No comments yet.</p>
                                @endforelse
                            </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
