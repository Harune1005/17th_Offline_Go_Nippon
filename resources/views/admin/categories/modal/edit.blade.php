<div class="modal fade" id="edit-category-{{ $category->id }}">
    <div class="modal-dialog">
        <div class="modal-content">

            {{-- header --}}
            <div class="modal-header">
                <h3 class="fs-4 fw-bold modal-title modal-font ps-0">
                    <i class="fa-solid fa-pen text-warning"></i> 
                     {{ __('messages.category.modal_title2') }}
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('admin.categories.update', $category->id) }}" method="post">
                @csrf
                @method('PATCH')

                {{-- body --}}
                <div class="modal-body mt-3">
                    <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" id="{{ $category->id }}">

                    {{-- error --}}
                    @error('name')
                    <div class="text-danger sall">{{ $message }}</div>
                    @enderror
                </div>

                {{-- footer --}}
                <div class="modal-footer border border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('messages.category.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-outline">
                        <i class="fa-solid fa-pen"></i> 
                        {{ __('messages.category.edit') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>