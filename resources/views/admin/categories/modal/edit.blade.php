<div class="modal fade" id="edit-category-{{ $category->id }}">
    <div class="modal-dialog">
        <div class="modal-content">

            {{-- header --}}
            <div class="modal-header ">
                <h3 class="modal-title">
                    <i class="fa-solid fa-pen"></i> Edit Category
                </h3>
            </div>

            {{-- body --}}
            <div class="modal-body">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <input type="text" name="name" class="form-control " value="{{ old('name', $category->name) }}" id="{{ $category->id }}">
                                    {{-- error --}}
                    @error('name')
                    <div class="text-danger sall">{{ $message }}</div>
                    @enderror

                    {{-- footer --}}
                    <div class="modal-footer border-0">


                        <button type="button" class="btn btn-outline btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-outline btn-sm">
                            <i class="fa-solid fa-pen"></i>Edit
                        </button>

                    </form>
                    </div>

            </div>
        </div>
    </div>
</div>