@extends('layouts.app')

@section('title', 'Ranking Post')

@section('content')
<div class="container-fluid p-0 mt-0">
    <div class="row align-items-center justify-content-center text-center mb-5"
        style="
            background-image: url('{{ asset($headerImage ?? 'default.jpeg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 300px;
            position: relative;
        ">
        <div style="
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 1;
        "></div>

        <h1 class="display-1 fw-bold text-white" style="z-index: 2; position: relative;">
            {{ strtoupper($title ?? 'RANKING') }}
        </h1>
    </div>
</div>

<div class="container">
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
                                                        style="object-fit: cover;"
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

                                <div class="carousel-indicators">
                                    @foreach ($images as $index => $image)
                                        <button type="button"
                                                data-bs-target="#carouselPost{{ $post->id }}"
                                                data-bs-slide-to="{{ $index }}"
                                                class="{{ $index === 0 ? 'active' : '' }}"
                                                aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                                                aria-label="Slide {{ $index + 1 }}">
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                        @elseif(count($images) === 1)
                            <a href="{{ route('post.show', $post->id) }}">
                                <div class="ratio ratio-1x1">
                                    <img 
                                        src="{{ asset('storage/' . $images[0]) }}"
                                        class="d-block w-100 h-100"
                                        style="object-fit: cover;"
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
                                @if ($post->isLiked())
                                <form action="{{ route('like.destroy', $post->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm p-0">
                                        <i class="fa-solid fa-heart me-1"  style="color: #9F6B46"></i>
                                    </button>
                                    <span class="fw-bold" style="color: #9F6B46">{{ $post->likes->count() }}</span>
                                </form>
                            @else
                                <form action="{{ route('like.store', $post->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-sm p-0">
                                        <i class="fa-regular fa-heart"  style="color: #9F6B46"></i>
                                    </button>
                                    <span class="fw-bold"  style="color: #9F6B46">{{ $post->likes->count() }}</span>
                                </form>
                            @endif
                                {{-- FAVORITE --}}
                                <form action="#" method="post">
                                    <button type="submit" class="btn btn-sm p-0">
                                        <i class="fa-solid fa-star me-1" style="color: #9F6B46"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small mb-0">{{ $post->created_at->format('Y-m-d') }}</span>

                            {{-- CATEGORY --}}
                            <div class="d-flex flex-wrap gap-1">
                                @foreach ($post->categories as $category)
                                    <span class="badge border" style="color: #9F6B46; background-color: rgb(236, 239, 255)">
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
    </div>
</div>
@endsection
