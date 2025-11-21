@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('ranking.post') }}" method="get">
        <div class="row align-items-end">
            <div class="col-12 col-md-4 mb-3 mb-md-0">
                <input type="text" name="search" class="form-control" placeholder="Search...">
            </div>

            <div class="col-12 col-md-8">
                <div class="row g-2  align-items-end">
                    <div class="col-6 col-md-5 mb-3 mb-md-0">
                        <label for="prefecture" class="form-label">Prefecture</label>
                        <select name="prefecture_id" class="form-select text-muted">
                            <option value="" selected hidden>Select</option>
                            @foreach ($prefectures as $prefecture)
                                <option value="{{ $prefecture->id }}">{{ $prefecture->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6 col-md-5 mb-3 mb-md-0">
                        <label for="category" class="form-label">Category</label>
                        <select name="category_id" class="form-select text-muted">
                            <option value="" selected hidden>Select</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-2 d-grid">
                        <button type="submit" class="btn btn-outline w-100">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="article mt-5">
        <div class="row">
            {{-- sidebar --}}
            <div class="col-12 col-md-4 mb-5">
                <div class="card shadow-sm border-0">
                    <div id="carouselRanking" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            {{-- Category Ranking --}}
                            <div class="carousel-item active">
                                <div class="card-header border-0" style="background: #fbefe5;">
                                    <h5 class="mb-0 fw-bold text-center">Category Ranking</h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    @forelse ($categoryRanked as $item)
                                        <li class="list-group-item rank-group-item d-flex justify-content-between align-items-center px-5"
                                        style="
                                        background-image: url('{{ asset($item['image']) }}');">

                                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(150, 150, 150, 0.35); z-index: 1;"></div>

                                            <span class="rank-text d-flex justify-content-center align-items-center fs-4 text-white" style="position: relative; z-index: 2;">
                                                <i class="fa-solid fa-crown text-white"></i> &nbsp;{{ $item['rank'] }}.
                                                &nbsp;
                                                <a href="{{ route('ranking.post', ['category_id' => $item['id']]) }}" class="text-decoration-none fs-4 ms-3 text-white">
                                                    {{ $item['name'] }}
                                                </a>
                                            </span>
                                            <div class="badge rounded-pill" style="position: relative; z-index:2;">
                                               <span style="font-weight: bold; font-size: 2em; color:#FFFF">{{ $item['count'] }}</span>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="list-group-item rank-group-item text-center text-muted">No data</li>
                                    @endforelse
                                </ul>
                            </div>

                            {{-- Prefecture Ranking --}}
                            <div class="carousel-item">
                                <div class="card-header border-0" style="background:#fbefe5;">
                                    <h5 class="mb-0 fw-bold text-center">Prefecture Ranking</h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    @forelse ($prefectureRanked as $item)
                                        <li class="list-group-item rank-group-item d-flex justify-content-between align-items-center px-5"
                                        style="
                                        background-image: url('{{ asset($item['image']) }}');
                                        background-size: cover;
                                        background-position: center;
                                        background-repeat: no-repeat;
                                        position: relative; 
                                        ">
                                         <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(150, 150, 150, 0.35); z-index: 1;"></div>
                                         <span class="rank-text d-flex justify-content-center align-items-center fs-4 text-white" style="position: relative; z-index: 2";>
                                                <i class="fa-solid fa-crown text-white"></i> &nbsp;{{ $item['rank'] }}.
                                                &nbsp;
                                                <a href="{{ route('ranking.post', ['prefecture_id' => $item['prefecture_id']]) }}" class="text-decoration-none fs-4 ms-3 text-white">
                                                    {{ $item['prefecture_name'] }}
                                                </a>
                                            </span>
                                            <div class="badge rounded-pill" style="position: relative; z-index:2;">
                                                <span style="font-weight: bold; font-size: 2em; color:#FFFF">{{ $item['count'] }}</span>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="rank-group-item text-center text-muted">No data</li>
                                    @endforelse
                                </ul>
                            </div>

                        </div>

                        {{-- carousel controls --}}
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselRanking" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselRanking" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-8">
                <div class="container">
                    {{-- sort --}}
                   <div class="mx-auto mb-3">
                        <div class="nav-tabs-wrapper">
                            <ul class="nav nav-tabs d-flex flex-nowrap custom-tabs text-center">
                                <li class="nav-item tab-item">
                                    <a href="{{ route('home', ['order' => 'newest']) }}" class="tab-btn {{ request('order') === 'newest' || !request()->has('order') ? 'active' : '' }}">
                                        Newest
                                    </a>
                                </li>
                                <li class="nav-item tab-item">
                                    <a href="{{ route('home', ['order' => 'most_liked']) }}" class="tab-btn {{ request('order') === 'most_liked' ? 'active' : '' }}">
                                        Most liked
                                    </a>
                                </li>
                                <li class="nav-item tab-item">
                                    <a href="{{ route('home', ['order' => 'recommend']) }}" class="tab-btn {{ request('order') === 'recommend' ? 'active' : '' }}">
                                        Recommend
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                   
                    <div class="row g-4 mt-3">
                        @forelse ($posts as $post)
                            <div class="col-12 col-md-6 d-flex justify-content-center">
                                <div class="card border-0 shadow-sm w-100">
                                    <div class="card-body p-0">
                                        @php
                                            $images = $post->images->pluck('image')->take(3)->toArray();
                                        @endphp

                                        @if (count($images) > 0)
                                            {{-- 画像が2枚以上 → カルーセル --}}
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
                                                                            style="object-fit: cover; border-top-left-radius: 5px; border-top-right-radius: 5px;"
                                                                            alt="Post Image {{ $index + 1 }}">
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    {{-- 前後ボタン --}}
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

                                            {{-- 1枚のみ --}}
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
                                        @else
                                            <div class="text-center py-5 text-muted">No image available.</div>
                                        @endif
                                    </div>

                                    <div class="card-footer bg-white border-0">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fs-5 mb-0">{{ $post->title ?? 'Title' }}</span>
                                            <div class="d-flex align-items-center gap-2">
                                                <button class="like-button btn btn-sm p-0" data-post-id="{{ $post->id }}" data-liked="{{ $post->isLiked() ? 'true' : 'false' }}">
                                                    @if ($post->isLiked())
                                                        <i class="fa-solid fa-heart me-1" style="color:#F1BDB2; font-size:18px;"></i>
                                                    @else
                                                        <i class="fa-regular fa-heart me-1" style="color:#9F6B46; font-size:18px;"></i>
                                                    @endif
                                                </button>
                                                <span class="like-count fw-bold" style="color:#9F6B46">{{ $post->likes->count() }}</span>
                                                <button class="btn btn-sm shadow-none favorite-btn" data-post-id="{{ $post->id }}" data-favorited="{{ $post->isFavorited() ? 'true' : 'false' }}">
                                                    @if ($post->isFavorited())
                                                        <i class="fa-solid fa-star text-warning" style="font-size: 18px;"></i>
                                                    @else
                                                        <i class="fa-regular fa-star" style="font-size: 18px;color:#9F6B46"></i>
                                                    @endif
                                                </button>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>{{ $post->visited_at ? $post->visited_at->format('Y-m-d') : 'Unknown' }}</span>
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
                            <div class="text-center py-5 text-muted">
                                <h5>No posts available</h5>
                                <a href="{{ route('post.create') }}" class="text-decoration-none"> Share your first photo!</a>
                            </div>
                        @endforelse
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $posts->appends(['order' => request('order')])->links() }}
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
@endsection