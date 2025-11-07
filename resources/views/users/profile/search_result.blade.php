@if ($searchResults->isEmpty())
    <p class="text-center fw-bold mt-3" style="color: #9F6B46; font-size: 1.2rem;">
        No users found.
    </p>
@else
    @foreach ($searchResults as $result)
        <div class="d-flex align-items-center rounded-3 p-3 mt-3" style="height: 100px;">
            <a href="{{ route('profile.show', $result->id) }}" class="text-decoration-none">
                @if ($result->avatar)
                    <img src="{{ $result->avatar }}" alt="{{ $result->name }}"
                        class="rounded-circle me-4 align-items-center"
                        style="width:75px; height:75px;">
                @else
                    <i class="fa-solid fa-circle-user text-secondary d-block text-center icon-md me-4"
                    style="font-size:60px;"></i>
                @endif
            </a>

            <div class="d-flex flex-column align-items-start">
                <h6 class="mb-0 fw-bold">{{ $result->name }}</h6>
            </div>

            <div class="d-flex align-items-center justify-content-center ms-auto">
                @if ($result->id !== Auth::id())
                    @if ($result->isFollowed())
                        <form action="{{ route('follow.destroy', $result->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn m-0 following-btn">Following</button>
                        </form>
                    @else
                        <form action="{{ route('follow.store', $result->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn m-0 follow-btn">Follow</button>
                        </form>
                    @endif
                @endif
            </div>
        </div>
    @endforeach
@endif
