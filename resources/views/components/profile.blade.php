@props([
    'user',
    'prefectures' => [],
    'allBadges' => [],
    'earnedBadgeIds' => [],
])

<div class="col-md-4">
    <div class="d-flex align-items-start profile-row flex-wrap">
        {{-- avatar --}}
        <div class="avatar-wrapper position-relative d-inline-block me-3 mb-3">
            @if ($user->avatar)
                <img src="{{ $user->avatar }}" 
                     alt="{{ $user->name }}" 
                     class="rounded-circle shadow-sm mb-3"
                     style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #9F6B46;">
            @else
                <i class="fa-solid fa-circle-user text-secondary mb-3"
                   style="font-size: 110px; border: 5px solid #9F6B46; border-radius: 50%;"></i>
            @endif
        </div>

        {{-- name + post / follow / following --}}
        <div class="flex-grow-1 text-start">
            <h3 style="margin-left: 15px;">{{ $user->name }}</h3>

            <div class="d-flex justify-content-between text-center fw-semibold flex-wrap number">
                <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none flex-fill">
                    <div class="fs-5 fw-bold">{{ $user->posts->count() }}</div>
                    <div class="small">{{ __('messages.profile.posts') }}</div>
                </a>

                <a href="{{ route('profile.followers', $user->id) }}" class="text-decoration-none flex-fill">
                    <div class="fs-5 fw-bold">{{ $user->followers->count() }}</div>
                    <div class="small">{{ __('messages.profile.followers') }}</div>
                </a>

                <a href="{{ route('profile.following', $user->id) }}" class="text-decoration-none flex-fill">
                    <div class="fs-5 fw-bold">{{ $user->following->count() }}</div>
                    <div class="small">{{ __('messages.profile.following') }}</div>
                </a>
            </div>
        </div>
    </div>

    {{-- country / introduction --}}
    <div class="mb-2">
        <h4>
            <span>{{ __('messages.profile.country') }}</span>
            {{ $user->country }}
        </h4>

        @if ($user->introduction)
            <p class="fw-semibold mb-3" style="color:#9F6B46;">
                {{ $user->introduction }}
            </p>
        @endif
    </div>

    {{-- follow / DM --}}
    <div class="row mb-4 justify-content-center">

        @if (Auth::id() === $user->id)
            <div class="col-auto px-2">
                <a href="{{ route('profile.edit') }}"
                   class="btn btn-outline shadow-sm" 
                   style="font-weight:bold; width:190px;">
                    {{ __('messages.profile.left_btn') }}
                </a>
            </div>
            <div class="col-auto">
                <a href="{{ route('favorite') }}" 
                   class="btn btn-pink shadow-sm" 
                   style="font-weight:bold; width:190px;">
                    {{ __('messages.profile.right_btn') }}
                </a>
            </div>
        @else
            <div class="col-auto px-2">
                @if ($user->isFollowed())
                    <form action="{{ route('follow.destroy', $user->id) }}" method="post">
                        @csrf @method('DELETE')
                        <button type="submit" 
                            class="btn btn-cancel shadow-sm" 
                            style="font-weight:bold; width:180px;">
                            {{ __('messages.profile.following2') }}
                        </button>
                    </form>
                @else
                    <form action="{{ route('follow.store', $user->id) }}" method="post">
                        @csrf
                        <button type="submit" 
                            class="btn btn-outline shadow-sm"
                            style="font-weight:bold; width:180px;">
                            {{ __('messages.profile.follow') }}
                        </button>
                    </form>
                @endif
            </div>

            <div class="col-auto">
                <form action="{{ route('conversations.start') }}" method="post">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $user->id }}">
                    <button type="submit" 
                        class="btn btn-pink shadow-sm"
                        style="font-weight:bold; width:180px;">
                        {{ __('messages.profile.dm') }}
                    </button>
                </form>
            </div>
        @endif
    </div>

    {{-- Badges --}}
    <div class="d-flex flex-wrap gap-3 mb-3">
        <p class="fw-bold text-center">Your <br> &nbsp; Badges</p>

        @foreach ($allBadges as $badge)
            <div class="d-flex flex-column align-items-center">
                <img 
                    src="{{ asset($badge->image_path) }}" 
                    alt="{{ $badge->name }}"
                    class="brand"
                    style="width: 50px; height:50px;
                        @if(!in_array($badge->id, $earnedBadgeIds))
                            filter: grayscale(100%); opacity: 0.3;
                        @endif
                    ">
                <p class="mb-0 text-center" style="color: #CAAE99; font-size:10px;">
                    {{ $badge->name }}
                </p>
            </div>
        @endforeach
    </div>

    {{-- MAP --}}
    <div class="row">
        <div class="map-container rounded-2 ms-2">
            <p class="fw-bold h5 click-map text-center mt-3">
                {{ __('messages.profile.map_title1') }}
                <span>{{ __('messages.profile.map_title2') }}</span>
            </p>

            <a href="{{ route('map.show', $user->id) }}" class="trip-map-a">
                <div id="map" style="width: 100%; height: 350px;"></div>
            </a>

            <div class="spinner-wrapper">
                <div class="spinner-outer">
                    @foreach ($prefectures as $pref)
                        @if ($pref->has_post)
                            <div class="spinner-fill" data-prefecture="{{ $pref->name }}"></div>
                        @endif
                    @endforeach

                    <div class="spinner-text">
                        <p class="label">{{ __('messages.profile.completed') }}</p>
                        <p class="count">
                            {{ collect($prefectures)->where('has_post', true)->count() }}
                            <span>/47</span>
                        </p>
                        <p class="small-text">{{ __('messages.profile.prefecture') }}</p>
                    </div>
                </div>
            </div>

            <div id="spinner-tooltip" class="tooltip"></div>
        </div>
    </div>
</div>