@if ($post->Trashed())
    {{-- Activate --}}
    <div class="modal fade" id="activate-post-{{ $post->id }}">
        <div class="modal-dialog">
            <div class="modal-content">

                {{-- header --}}
                <div class="modal-header ">
                    <h5 class="modal-title ">
                        <i class="fa-solid fa-check-to-slot"></i> Visible Post
                    </h5>
                </div>

                {{-- body --}}
                <div class="modal-body">
                    Are you sure you want to visible this post?
                    <span>
                         <img src="{{$post->image}}" alt="{{ $post->id }}" class="image-lg" >
                    </span>
                </div>

                {{-- footer --}}
                <div class="modal-footer border-0">
                    <form action="{{route('admin.posts.activate', $post->id) }}" method="post">
                        @csrf
                        @method('PATCH')

                        <button type="button" class="btn btn-outline btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-outline btn-sm">Activate</button>
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
                <div class="modal-header border">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-ban"></i> Hide Post
                    </h5>
                </div>

                {{-- body --}}
                <div class="modal-body">
                    Are you sure you want to hide this post?
                    <span>
                         <img src="{{$post->image}}" alt="{{ $post->id }}" class="image-lg" >
                    </span>
                </div>

                {{-- footer --}}
                <div class="modal-footer border-0">
                    <form action="{{route('admin.posts.deactivate', $post->id) }}" method="post">
                        @csrf
                        @method('DELETE')

                        <button type="button" class="btn btn-outline btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-outline btn-sm">Hide</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endif