@if ($post->Trashed())
    {{-- Activate --}}
    <div class="modal fade" id="activate-post-{{ $post->id }}">
        <div class="modal-dialog">
            <div class="modal-content">

                {{-- header --}}
                <div class="modal-header">
                    <h3 class="fs-4 fw-bold modal-title modal-font ps-0">
                        <i class="fa-solid fa-check-to-slot"></i> 
                        Visible Post
                    </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- body --}}
                <div class="modal-body d-flex justify-content-center align-items-center">
                    {{-- post has image --}}
                    @php
                        $firstImage = $post->images->first();
                    @endphp
                    @if ($firstImage)
                        @if ($post->trashed())
                            <img src="{{ asset('storage/' . $firstImage->image) }}" class="img-thumbnail mx-auto" style="width:110px; height:110px; object-fit: cover;">
                        @else
                            <a href="{{ route('post.show', $post->id) }}">
                                <img src="{{ asset('storage/' . $firstImage->image) }}" class="img-thumbnail mx-auto" style="width:110px; height:110px; object-fit: cover; max-width: none;">
                            </a>
                        @endif
                    @else
                        {{-- no image --}}
                        <div class="text-muted me-3">No Image
                        </div>
                    @endif
                    {{-- <img src="{{ asset ('storage/' .  $post->images->first()->image )}}" alt="No post" class="img-thumbnail me-3" style="width:110px; height:110px; object-fit: cover;"> --}}
                    <p class="mb-0 modal-font">Are you sure you want to visible this post?</p>
                </div>

                {{-- footer --}}
                <div class="modal-footer border-0">
                    <form action="{{route('admin.posts.activate', $post->id) }}" method="post">
                        @csrf
                        @method('PATCH')

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-outline">Activate</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@else
    {{-- Deactivate --}}
    <div class="modal fade" id="activate-post-{{ $post->id }}">
        <div class="modal-dialog">
            <div class="modal-content">

                {{-- header --}}
                <div class="modal-header">
                    <h3 class="fs-4 fw-bold modal-title modal-font ps-0">
                        <i class="fa-solid fa-ban"></i> 
                        Hide Post
                    </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- body --}}
                <div class="modal-body d-flex justify-content-center align-items-center">
                    @php
                        $firstImage = $post->images->first();
                    @endphp
                    @if ($firstImage)
                        {{-- post has image --}}
                        @if ($post->trashed())
                            <img src="{{ asset('storage/' . $firstImage->image) }}" class="img-thumbnail mx-auto" style="width:110px; height:110px; object-fit: cover;">
                        @else
                            <a href="{{ route('post.show', $post->id) }}">
                                <img src="{{ asset('storage/' . $firstImage->image) }}" class="img-thumbnail mx-auto" style="width:110px; height:110px; object-fit: cover; max-width: none;">
                            </a>
                        @endif
                    @else
                        {{-- no image --}}
                        <div class="text-muted me-3">No Image</div>
                    @endif
                    {{-- <img src="{{ asset ('storage/' .  $post->images->first()->image )}}" alt="No post" class="img-thumbnail me-3" style="width:110px; height:110px; object-fit: cover;"> --}}
                    <p class="mb-0 modal-font">Are you sure you want to hide this post?</p>
                </div>

                {{-- footer --}}
                <div class="modal-footer border-0">
                    <form action="{{route('admin.posts.deactivate', $post->id) }}" method="post">
                        @csrf
                        @method('DELETE')

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-outline">Hide</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endif