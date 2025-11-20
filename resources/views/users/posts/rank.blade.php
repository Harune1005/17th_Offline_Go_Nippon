@extends('layouts.app')

@section('title', 'Ranking Post')

@section('content')
@php $mainClass = ''; @endphp
<div class="container-fluid p-0 mt-0">
    <div class="row align-items-center justify-content-center text-center mb-5"
        style="
            background-image: url('{{ asset($headerImage ?? 'default.jpeg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 360px;
            position: relative;
        ">
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.6); z-index: 1;"></div>

        <h1 class="display-1 fw-bold text-white" style="z-index: 2; position: relative;">
            {{ strtoupper($title ?? 'RANKING') }}
        </h1>
    </div>
</div>

<div class="container">
    <div class="mx-auto mb-3">
        <div class="nav-tabs-wrapper">
            <ul class="nav nav-tabs d-flex flex-nowrap custom-tabs text-center">

                @php $query = request()->all(); @endphp

                <li class="nav-item tab-item">
                    <a href="{{ route('ranking.post', array_merge($query, ['order' => 'newest'])) }}"
                    class="tab-btn {{ $order === 'newest' ? 'active' : '' }}">
                        Newest
                    </a>
                </li>

                <li class="nav-item tab-item">
                    <a href="{{ route('ranking.post', array_merge($query, ['order' => 'most_liked'])) }}"
                    class="tab-btn {{ $order === 'most_liked' ? 'active' : '' }}">
                        Most liked
                    </a>
                </li>

                <li class="nav-item tab-item">
                    <a href="{{ route('ranking.post', array_merge($query, ['order' => 'recommend'])) }}"
                    class="tab-btn {{ $order === 'recommend' ? 'active' : '' }}">
                        Recommend
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="row">      
        @forelse ($posts as $post)
            <div class="col-12 col-md-4 d-flex justify-content-center mb-4">
                <div class="card border-0 shadow-sm w-100">
                    <div class="card-body p-0">
                        @php
                            $images = $post->images->pluck('image')->take(3)->toArray();
                        @endphp
                        @if (count($images) > 1)
                            <div id="carouselPost{{ $post->id }}" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach ($images as $index => $image)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <a href="{{ route('post.show', $post->id) }}">
                                                <div class="ratio ratio-1x1">
                                                    <img 
                                                        src="{{ asset('storage/' . $image) }}" 
                                                        class="d-block w-100 h-100"
                                                        style="object-fit: cover;border-top-left-radius: 5px; border-top-right-radius: 5px;"
                                                        alt="Post Image {{ $index + 1 }}">
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>

                                <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carouselPost{{ $post->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>

                                <button class="carousel-control-next" type="button"
                                        data-bs-target="#carouselPost{{ $post->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        @elseif(count($images) === 1)
                            <a href="{{ route('post.show', $post->id) }}">
                                <div class="ratio ratio-1x1">
                                    <img 
                                        src="{{ asset('storage/' . $images[0]) }}"
                                        class="d-block w-100 h-100"
                                        style="object-fit: cover; border-top-left-radius: 5px; border-top-right-radius: 5px;"
                                        alt="Post Image">
                                </div>
                            </a>
                        @endif
                    </div>

                    <div class="card-footer bg-white border-0">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fs-5 mb-0">{{ $post->title }}</span>
                            <div class="d-flex align-items-center gap-2">
                                {{-- LIKE --}}
                                <button class="like-button btn btn-sm p-0" data-post-id="{{ $post->id }}" data-liked="{{ $post->isLiked() ? 'true' : 'false' }}">
                                    @if ($post->isLiked())
                                        <i class="fa-solid fa-heart me-1" style="color:#F1BDB2; font-size:18px;"></i>
                                    @else
                                        <i class="fa-regular fa-heart me-1" style="color:#9F6B46; font-size:18px;"></i>
                                    @endif
                                </button>
                                <span class="like-count fw-bold" style="color:#9F6B46">{{ $post->likes->count() }}</span>
                                {{-- FAVORITE --}}
                                <button class="btn btn-sm shadow-none favorite-btn" data-post-id="{{ $post->id }}" data-favorited="{{ $post->isFavorited() ? 'true' : 'false' }}">
                                    @if ($post->isFavorited())
                                        <i class="fa-solid fa-star text-warning" style="font-size: 18px;"></i>
                                    @else
                                        <i class="fa-regular fa-star" style="font-size: 18px;"></i>
                                    @endif
                                </button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="mb-0">{{ $post->created_at->format('Y-m-d') }}</span>

                            {{-- CATEGORY --}}
                            <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                                @foreach ($post->categories as $category)
                                    <span class="category-name">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-5">
                <p class="fs-5 mb-0">No posts found for "{{ $title ?? 'Ranking' }}"</p>
            </div>
        @endforelse
        <div class="d-flex justify-content-center mt-4">
            {{ $posts->appends(request()->query())->links() }}
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


@endsection
