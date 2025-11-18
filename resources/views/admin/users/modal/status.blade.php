@if ($user->trashed())
    {{-- Activate --}}
    <div class="modal fade" id="activate-user-{{ $user->id }}">
        <div class="modal-dialog">
            <div class="modal-content">

                {{-- header --}}
                <div class="modal-header">
                    <h3 class="fs-4 fw-bold modal-title modal-font ps-0">
                        <i class="fa-solid fa-user-check"></i> 
                        Activate User
                    </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- body --}}
                <div class="modal-body d-flex justify-content-center align-items-center">
                    @if ($user->avatar)
                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle me-3 border border-2 border-dark" style="width:45px; height:45px; object-fit: cover;">
                    @else
                        <i class="fa-solid fa-circle-user fa-3x d-block text-center text-secondary icon-md me-3"></i>
                    @endif
                    <p class="mb-0 modal-font">Are you sure you want to activate <span class="fs-5 fw-bold text-decoration-underline">{{ $user->name }}</span> ?</p>
                </div>

                {{-- footer --}}
                <div class="modal-footer border-0">
                    <form action="{{route('admin.users.activate', $user->id) }}" method="post">
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
    {{-- deactivate --}}
    <div class="modal fade" id="deactivate-user-{{ $user->id }}">
        <div class="modal-dialog">
            <div class="modal-content">

                {{-- header --}}
                <div class="modal-header">
                    <h3 class="fs-4 fw-bold modal-title modal-font ps-0">
                        <i class="fa-solid fa-user-slash"></i> 
                        Deactivate User
                    </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- body --}}
                <div class="modal-body d-flex justify-content-center align-items-center">
                    @if ($user->avatar)
                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle me-3 border border-2 border-dark" style="width:45px; height:45px; object-fit: cover;">
                    @else
                        <i class="fa-solid fa-circle-user fa-3x d-block text-center text-secondary icon-md me-3"></i>
                    @endif
                    <p class="mb-0 modal-font">Are you sure you want to deactivate <span class="fs-5 fw-bold text-decoration-underline">{{ $user->name }}</span> ?</p>
                </div>

                {{-- footer --}}
                <div class="modal-footer border-0">
                    <form action="{{ route('admin.users.deactivate', $user->id) }}" method="post">
                        @csrf
                        @method('DELETE')

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-outline">Deactivate</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endif

