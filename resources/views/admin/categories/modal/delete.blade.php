<div class="modal fade" id="delete-category-{{ $category->id }}">
    <div class="modal-dialog">
        <div class="modal-content">

            {{-- header --}}
            <div class="modal-header">
                <h3 class="fs-5 modal-title ps-0">
                    <i class="fa-solid fa-trash-can"></i>
                     Delete Category
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

 
            <form action="{{ route('admin.categories.delete', $category->id) }}" method="post">
                @csrf
                @method('DELETE')

                {{-- body --}}
                <div class="modal-body mt-3">
                    <p class="text-center">Are you sure to delete this category <span class="fw-bold">{{ $category->name }} </span> ?</p>
                </div>

                {{-- footer --}}
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-outline">
                    <i class="fa-solid fa-trash-can"></i> Delete</button>
                </div>
            </form> 
        </div>
    </div>
</div>