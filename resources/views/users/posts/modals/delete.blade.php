<div class="modal fade" id="delete-post-{{ $post->id }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 10px; overflow: hidden;">

            <!-- Modal Header -->
            <div class="modal-header" style="background-color:#b4a08b; color: #fff; border-bottom: none;">
                <h3 class="h5 modal-title mb-0">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i> Delete Post
                </h3>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body text-center">
                <p class="fw-bold text-muted fs-5">Are you sure you want to delete this post?</p>
                @php
                    $media = $post->media->first();
                @endphp
                <div class="mt-3">
                    @if ($media)
                        {{-- image --}}
                        @if ($media->type === 'image')
                            <img src="{{ asset('storage/' . $media->path) }}" 
                                alt="Post {{ $post->id }}"
                                class="rounded shadow-sm mb-2"
                                style="border: 3px solid #B0A695; max-width: 100%; height: auto; display:block; margin:0 auto;">
                        {{-- video with thumbnail --}}
                        @elseif($media->type === 'video' && $media->thumbnail_path)
                            <img src="{{ asset('storage/' . $media->thumbnail_path) }}"
                                alt="Video Thumbnail"
                                class="rounded shadow-sm mb-2"
                                style="border: 3px solid #B0A695; max-width: 100%; height: auto; display:block; margin:0 auto;">
                        {{-- video without thumbnail --}}
                        @elseif($media->type === 'video')
                            <video
                                src="{{ asset('storage/' . $media->path) }}"
                                class="rounded shadow-sm mb-2"
                                muted
                                playsinline
                                style="border: 3px solid #B0A695; max-width: 100%; height: auto;display:block; margin:0 auto;">
                            </video>
                        @endif
                    @else
                        <i class="fa-regular fa-image mb-3" style="font-size: 4rem; color:#B0A695;"></i>
                    @endif

                    <p class="mt-1 text-muted fst-italic fs-4">{{ $post->title }}</p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer" style="background-color: #f4eeea; border-top: none;">
                <button type="button" class="btn btn-cancel me-3" style="border-radius: 8px;" data-bs-dismiss="modal">
                    Cancel
                </button>
                <form action="{{ route('post.destroy', $post->id) }}" method="post" class="m-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline" style="border-radius: 8px;">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
