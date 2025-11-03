@if ($user->trashed())
    {{-- Activate --}}
    <div class="modal fade" id="activate-user-{{ $user->id }}">
        <div class="modal-dialog">
            <div class="modal-content">

                {{-- header --}}
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-user-check"></i> Activate User
                    </h5>
                </div>

                {{-- body --}}
                <div class="modal-body">
                    Are you sure you want to activate <span class="fw-bold">{{ $user->name }}</span> ?
                </div>

                {{-- footer --}}
                <div class="modal-footer border-0">
                    <form action="{{route('admin.users.activate', $user->id) }}" method="post">
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
    {{-- deactivate --}}
    <div class="modal fade" id="deactivate-user-{{ $user->id }}">
        <div class="modal-dialog">
            <div class="modal-content">

                {{-- header --}}
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-user-slash"></i> Deactivate User
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- body --}}
                <div class="modal-body">
                    Are you sure you want to deactivate <span class="fw-bold">{{ $user->name }}</span> ?
                </div>

                {{-- footer --}}
                <div class="modal-footer border-0">
                    <form action="{{ route('admin.users.deactivate', $user->id) }}" method="post">
                        @csrf
                        @method('DELETE')

                        <button type="button" class="btn btn-outline btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-outline btn-sm">Deactivate</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endif

