@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row mt-2  profile-row p-0">
        <x-profile 
            :user="$user"
            :prefectures="$prefectures"
            :allBadges="$allBadges"
            :earnedBadgeIds="$earnedBadgeIds"
            :latestBadge="$latestBadge"
        />

        <div class="col-12 col-md-4 search-area">
            <div class="mx-auto" style="max-width: 500px;">
                <form action="{{ route('follow.search', $user->id) }}" method="GET" class="d-flex mb-3">
                    <input type="text" name="search" value="{{ $keyword ?? '' }}" placeholder="{{ __('messages.follow.search') }}" class="d-flex form-control me-2" style="width: 75%;">
                    <input type="hidden" name="tab" value="{{ $activeTab ?? 'followers' }}">
                    <button class="btn btn-outline ms-auto">
                        <i class="fa-solid fa-magnifying-glass"></i> {{ __('messages.follow.btn') }}
                    </button>
                </form>

                {{-- tabs --}}
                <div class="mx-auto w-100 mb-2">
                    <ul class="nav nav-tabs border-bottom-0 justify-content-center" id="followTabs" role="tablist" style="height: 50px;">
                        <li class="nav-item text-center flex-fill follow-tab" role="presentation">
                            <a href="{{ route('profile.followers', $user->id) }}" 
                            class="nav-link d-flex align-items-center justify-content-center h-100 w-100 {{ $activeTab === 'followers' ? 'active' : '' }}"
                            role="tab" aria-controls="followers"
                            aria-selected="{{ $activeTab === 'followers' ? 'true' : 'false' }}">
                                {{ __('messages.follow.follower') }}
                            </a>
                        </li>
                        <li class="nav-item text-center flex-fill follow-tab" role="presentation">
                            <a href="{{ route('profile.following', $user->id) }}"
                            class="nav-link d-flex align-items-center justify-content-center h-100 w-100 {{ $activeTab === 'following' ? 'active' : '' }}"
                            role="tab" aria-controls="following"
                            aria-selected="{{ $activeTab === 'following' ? 'true' : 'false' }}">
                                {{ __('messages.follow.following') }}
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- content of tabs --}}
                <div class="tab-content shadow p-3" style="background-color: #fffbf7" id="followTabsContent">
                    {{-- ▼ Followersタブ --}}
                    <div class="tab-pane fade {{ $activeTab === 'followers' ? 'show active' : '' }}"
                        id="followers" role="tabpanel" aria-labelledby="followers-tab">
                        <div class="default-list {{ isset($searchResults) && $activeTab === 'followers' ? 'd-none' : '' }}">
                            <div class="d-flex justify-content-center align-items-center text-center mt-2 w-50 mx-auto rounded"
                                style="color:#ffffff; background-color: #9F6B46; height:50px;">
                                <h2 class="mb-0" style="font-size:20px;">
                                    {{ $user->followers->count() }} {{ __('messages.follow.follower') }}
                                </h2>
                            </div>

                            @foreach ($user->followers as $follower)
                                <div class="d-flex align-items-center rounded-3 p-3 mt-3" style="height: 100px;">
                                        <a href="{{ route('profile.show', $follower->id) }}" class="text-decoration-none avatar-wrapper position-relative d-inline-block">
                                            @if ($follower->avatar)
                                                <img src="{{ $follower->avatar }}" alt="{{ $follower->name }}"
                                                    class="rounded-circle me-4 align-items-center" style="width:60px; height:60px; object-fit:cover;">
                                            @else
                                                <i class="fa-solid fa-circle-user text-secondary d-block text-center icon-md me-4" style="font-size:60px;"></i>
                                            @endif
                                        </a>
                                        
                                    <div class="d-flex flex-column align-items-start">
                                        <h6 class="mb-0 fw-bold">{{ $follower->name }}</h6>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center ms-auto">
                                        @if ($follower->id !== Auth::id())
                                            @if ($follower->isFollowed())
                                                <form action="{{ route('follow.destroy', $follower->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="tab" value="followers">
                                                    <input type="hidden" name="return_url" value="{{ url()->full() }}">
                                                    <button type="submit" class="btn m-0 following-btn">{{ __('messages.follow.following') }}</button>
                                                </form>


                                            @else
                                                <form action="{{ route('follow.store', $follower->id) }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="tab" value="followers">
                                                    <input type="hidden" name="return_url" value="{{ url()->full() }}">
                                                    <button type="submit" class="btn m-0 follow-btn">{{ __('messages.follow.follow') }}</button>
                                                </form>

                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if (isset($searchResults) && $activeTab === 'followers')
                            <div class="search-result-container">
                                @include('users.profile.search_result', ['searchResults' => $searchResults])
                            </div>
                        @endif
                    </div>

                    {{-- ▼ Followingタブ --}}
                    <div class="tab-pane fade {{ $activeTab === 'following' ? 'show active' : '' }}"
                        id="followings" role="tabpanel" aria-labelledby="followings-tab">
                        <div class="default-list {{ isset($searchResults) && $activeTab === 'following' ? 'd-none' : '' }}">
                            <div class="d-flex justify-content-center align-items-center text-center mt-2 w-50 mx-auto rounded"
                                style="color:#ffffff; background-color: #9F6B46; height:50px;">
                                <h2 class="mb-0" style="font-size:20px;">
                                    {{ $user->following->count() }} {{ __('messages.follow.following') }}
                                </h2>
                            </div>

                            @foreach ($user->following as $following)
                                <div class="d-flex align-items-center rounded-3 p-3 mt-3" style="height: 100px;">
                                    <a href="{{ route('profile.show', $following->id) }}" class="text-decoration-none">
                                        @if ($following->avatar)
                                            <img src="{{ $following->avatar }}" alt="{{ $following->name }}"
                                                class="rounded-circle me-4 align-items-center" style="width:60px; height:60px; object-fit:cover;">
                                        @else
                                            <i class="fa-solid fa-circle-user text-secondary d-block text-center icon-md me-4" style="font-size:60px;"></i>
                                        @endif
                                    </a>

                                    <div class="d-flex flex-column align-items-start">
                                        <h6 class="mb-0 fw-bold">{{ $following->name }}</h6>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center ms-auto">
                                        @if ($following->id !== Auth::id())
                                            @if ($following->isFollowed())
                                                <form action="{{ route('follow.destroy', $following->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="tab" value="following">
                                                    <button type="submit" class="btn m-0 following-btn">{{ __('messages.follow.following') }}</button>
                                                </form>
                                            @else
                                                <form action="{{ route('follow.store', $following->id) }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="tab" value="following">
                                                    <button type="submit" class="btn m-0 follow-btn">{{ __('messages.follow.follow') }}</button>
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if (isset($searchResults) && $activeTab === 'following')
                            <div class="search-result-container">
                                @include('users.profile.search_result', ['searchResults' => $searchResults])
                            </div>
                        @endif
                    </div>
                </div> 
            </div>
        </div>

        <div class="col d-none d-md-block" >
            <div class="shadow p-3 m-3" style="background-color: #fffbf7">
                <div class="d-flex justify-content-center align-items-center text-center mt-2 w-100 mx-auto mb-4">
                    <h2 class="mb-0" style="font-size:20px;">
                        <i class="fa-solid fa-user"></i> {{ __('messages.follow.recommend') }}
                    </h2>
                </div>

                @if ($suggested_users->isNotEmpty())
                    @foreach ($suggested_users as $user_suggested)
                        <div class="d-flex align-items-center rounded-3 p-3" style="height: 100px;">
                            <a href="{{ route('profile.show', $user_suggested->id) }}" class="text-decoration-none">
                                @if ( $user_suggested->avatar)
                                    <img src="{{  $user_suggested->avatar }}" alt="{{  $user_suggested->name }}"
                                        class="rounded-circle me-4 align-items-center" style="width:60px; height:60px; object-fit:cover;">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary d-block text-center icon-md me-4" style="font-size:60px;"></i>
                                @endif
                            </a>

                            <div class="d-flex flex-column align-items-start">
                                <h6 class="mb-0 fw-bold">{{  $user_suggested->name }}</h6>
                            </div>

                            <div class="d-flex align-items-center justify-content-center ms-auto">
                                <form action="{{ route('follow.store', $user_suggested->id) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="tab" id="current-tab" value="{{ $activeTab ?? 'followers' }}">
                                    <button type="submit" class="btn m-0 follow-btn">
                                        {{ __('messages.follow.follow') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center mt-3" style="color:#9F6B46; font-weight:bold;">
                        No recommended users
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

<script src="{{ asset('js/follower-map.js') }}"></script>
@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function(){
    followerMap({
        userId: {{ $user->id }},
        prefectures: @json($prefectures)
    });
});
</script>
@endpush

