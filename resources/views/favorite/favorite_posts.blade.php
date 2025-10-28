<div class="row mb-5">

    @forelse ($favorites as $favorite)

        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow m-2" style="color: #9F6B46">

                <div class="card-body ratio ratio-1x1">
                    <img src="{{ asset('storage/sample_images/' . $favorite->post->image) }}" alt="{{ $favorite->post->image }}" class="img-fluid" style=" object-fit:cover; width: 100%; height: 100%; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                </div>

                <div class="card-footer bg-white">
                    <div class="row p-1 align-items-center mb-4">
                        <div class="col-7" style="font-size: 20px; white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">{{ $favorite->post->title }}</div>
                        <div class="col-3 text-end"><i class="fa-regular fa-heart" style="font-size:18px;"></i><span style="font-size: 13px;">&nbsp;{{ $favorite->post->likes_count }}</span></div>
                        <div class="col-2 text-end">
                            <button class="btn btn-sm shadow-none favorite-btn" data-post-id="{{ $favorite->post->id }}" data-favorited="{{ $favorite->post->isFavorited() ? 'true' : 'false' }}">
                                @if ($favorite->post->isFavorited())
                                    <i class="fa-solid fa-star text-warning" style="font-size: 18px;"></i>
                                @else
                                    <i class="fa-regular fa-star" style="font-size: 18px;"></i>
                                @endif
                            </button>
                        </div>
                    </div>
                    <div class="row px-1 py-2">
                        <div class="col d-flex align-items-end" style="font-size: 13px;">{{ $favorite->post->visited_at }}</div>
                        <div class="col d-flex justify-content-end align-items-end">
                            @foreach ($favorite->post->categories as $category)
                                <div class="d-inline-block border border-0 rounded-4 text-center py-1 px-3 me-1" style="background-color:#ECF9FF">{{ $category->name }}</div>
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