<div class="row mb-5">

    @forelse ($favorites as $favorite)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card border-0 shadow m-2">
                <div class="card-body p-0">
                    @php
                        $mediaItems = $favorite->post->media->take(3);
                    @endphp
                    @if ($mediaItems->count() > 0)
                        {{-- multiple media --}}
                        @if ($mediaItems->count() > 1)
                            <div id="carouselPost{{ $favorite->post->id }}" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach ($mediaItems as $index => $media)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <a href="{{ route('post.show', $favorite->post->id) }}">
                                                <a href="{{ route('post.show', $favorite->post->id) }}">
                                                    <div class="ratio ratio-1x1">
                                                        {{-- image --}}
                                                        @if ($media->type === 'image')
                                                            <img 
                                                            src="{{ asset('storage/' . $media->path) }}" 
                                                            class="d-block w-100 h-100"
                                                            style="object-fit: cover; border-top-left-radius: 5px; border-top-right-radius: 5px;"
                                                            alt="Post Image {{ $index + 1 }}">
                                                        @endif
                                                        {{-- video --}}
                                                        @if ($media->type === 'video')
                                                             <video
                                                                src="{{ asset('storage/' . $media->path) }}"
                                                                class="d-block w-100 h-100"
                                                                muted
                                                                autoplay
                                                                playsinline
                                                                style="object-fit: cover; border-top-left-radius: 5px; border-top-right-radius: 5px;"
                                                            ></video>
                                                        @endif
                                                    </div>
                                                </a>
                                                
                                            </a>
                                        </div>
                                    @endforeach
                                </div>

                                <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carouselPost{{ $favorite->post->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>

                                <button class="carousel-control-next" type="button"
                                        data-bs-target="#carouselPost{{ $favorite->post->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>

                            </div>
                        {{-- single media --}}
                        @else
                            <a href="{{ route('post.show', $favorite->post->id) }}">
                                <div class="card-body ratio ratio-1x1">
                                    @if ($mediaItems[0]->type === 'image')
                                        <img src="{{ asset('storage/' . $mediaItems[0]->path) }}" 
                                        class="d-block w-100 h-100" 
                                        style="object-fit: cover; border-top-left-radius: 5px; border-top-right-radius: 5px;" alt="Post Image">
                                    @else
                                        <video
                                            src="{{ asset('storage/' . $mediaItems[0]->path) }}"
                                            class="d-block w-100 h-100"
                                            muted
                                            playsinline
                                            autoplay
                                            loop
                                            style="object-fit: cover; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                                        </video>
                                    @endif
                                </div>
                            </a>
                        @endif
                    @else
                        <div class="text-center py-5 text-muted">No media available.</div>
                    @endif
                </div>

                <div class="card-footer bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fs-5 mb-0">{{ $favorite->post->title ?? 'Title' }}</span>
                        <div class="d-flex align-items-center gap-2">
                            <button class="like-button btn btn-sm p-0" data-post-id="{{ $favorite->post->id }}" data-liked="{{ $favorite->post->isLiked() ? 'true' : 'false' }}">
                                @if ($favorite->post->isLiked())
                                    <i class="fa-solid fa-heart me-1" style="color:#F1BDB2; font-size:18px;"></i>
                                @else
                                    <i class="fa-regular fa-heart me-1" style="color:#9F6B46; font-size:18px;"></i>
                                @endif
                            </button>
                            <span class="like-count fw-bold" style="color:#9F6B46">{{ $favorite->post->likes->count() }}</span>
                            
                            <button class="btn btn-sm shadow-none favorite-btn" data-post-id="{{ $favorite->post->id }}" data-favorited="{{ $favorite->post->isFavorited() ? 'true' : 'false' }}">
                                @if ($favorite->post->isFavorited())
                                    <i class="fa-solid fa-star text-warning" style="font-size: 18px;"></i>
                                @else
                                    <i class="fa-regular fa-star" style="font-size: 18px;"></i>
                                @endif
                            </button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>{{ $favorite->post->visited_at ? $favorite->post->visited_at->format('Y-m-d') : 'Unknown' }}</span>
                        <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                            @foreach ($favorite->post->categories as $category)
                                <div class="category-name">{{ $category->name }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        {{-- If the user doesn't have any favorite  --}}
        <div class="text-center mt-5">
            <h2>There is no favorite post.</h2>
        </div>
    @endforelse
</div>