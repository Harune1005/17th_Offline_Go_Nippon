<div class="modal fade" id="delete-category-{{ $category->id }}">
    <div class="modal-dialog">
        <div class="modal-content">

            {{-- header --}}
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fa-solid fa-trash-can"></i> Delete Category
                </h3>
            </div>

            {{-- body --}}
            <div class="modal-body">
                <form action="{{ route('admin.categories.delete', $category->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <p>Are you sure to delete this category <span class="fw-bold">{{ $category->name }} </span> ?</p>
                    {{-- footer --}}
                    <div class="modal-footer border-0">

                            <button type="button" class="btn btn-outline btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-outline btn-sm">
                            <i class="fa-solid fa-trash-can"></i>Delete
                        </button>

                    </form>
                    </div>

            </div>
        </div>
    </div>
</div>