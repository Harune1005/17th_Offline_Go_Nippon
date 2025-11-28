
@forelse ($followings as $following)
    <div class="d-flex align-items-center rounded-3 p-3">
        @if ($following->following->avatar)
            <img src="{{ $following->following->avatar }}" alt="{{ $following->following->name }}" class="rounded-circle me-4 align-items-ceter" style="width:65px; height:65px;">
        @else
            <i class="fa-solid fa-user rounded-circle me-4 align-items-center" style="width:65px; height:65px; font-size:40px; display:flex; align-items:center; justify-content:center; background-color:#ccc; color:#fff;"></i>
        @endif

        <div class="d-flex align-items-center justify-content-center">
            <h6 class="mb-0 fw-bold" style="">{{ $following->following->name }}</h6>
        </div>

        <div class="d-flex align-items-center ms-auto">
            <form action="{{ route('conversations.start') }}" method="post">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $following->following->id }}">
                <button type="submit" class="btn btn-outline">
                    <i class="fa-regular fa-envelope"></i>&nbsp;{{ __('messages.dm.message') }}
                </button>
            </form>
        </div>
    </div>
@empty
    <div class="p-3 text-center text-muted">
        {{ __('messages.dm.no_user') }}
    </div>
@endforelse
