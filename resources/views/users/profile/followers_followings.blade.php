@extends('layouts.app')

@section('content')
<style>
    div{
        color:#9F6B46;
    }
    span{
        color:#CAAE99;
    }

    .card{
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);   
    }

    .post-image{
        width: 100%;
        aspect-ratio:1 / 1;
        oblect-fit:cover;
    }

        .map-container {
    position: relative;
    width: 420px;
    height: 350px;
    background-color: #E6F4FA;
    overflow: hidden;
    }

    
    path {
        stroke: #333;
        stroke-width: 0.5;
        fill: #ccc;
    }
    path:hover {
        fill: #F1BDB2;
    }

    .spinner-outer {
    position: relative;
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background: transparent;
    }
    .spinner-wrapper {
    position: absolute;
    bottom: 10px;
    right: 10px;
    z-index: 10;
    }

    .spinner-circle {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: conic-gradient(#F1BDB2 0deg, #FFFF 0deg); 
    transition: background 0.5s ease;
    }

    .spinner-text  {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;

    }

    .spinner-text p {
    margin: 0;
    }

    .spinner-text .small-text {
    font-size: 15px;
    color: #CAAE99;
    
}
    .spinner-text .label {
    font-family: 'Source Serif Pro', serif;
    color: #9F6B46;
    font-weight: 600;
    font-size: 20px;
    }

    .spinner-text .count {
    font-family: 'Source Serif Pro', serif;
    color: #9F6B46;
    font-weight: bold;
    font-size: 45px;
    line-height: 1;
    }

@media (max-width: 600px) {
        html, body {
        overflow-x: hidden; 
    }

    .col-12.col-md-4 {
        margin-right: auto !important;
        margin-left: auto !important;
    }

    .trip-map-a{
        padding-right:0%;
        padding-left: 0.5rem;
    }
    .trip-map-a,
    .profile-row,
    .click-map {
        padding-left: 0 !important;
        padding-right: 10 !important;
        margin-left: auto !important;
        margin-right: auto !important;
    }

    .btn {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }

    .col-auto{
        padding: 0;
    }
    .phone {
        font-size: 12px;
        padding: 0;
    }

    .name{
        padding-left: 2rem;
    }
    .number{
        padding-left: 2rem;
    }
    .profile-row{
    padding-left: 0.5rem;
    }
    .spinner-wrapper {
        bottom: 5px;
        right: 30px;
        transform: translateX(10%) scale(0.9);
    }
    
    .btn{
        margin-left:0.5rem;
        margin-right:0.5rem;
    }
    .click-map{
        margin-left: 1rem;
        padding-right: 0;
        padding-left: 1rem;
    }
    .search-area{
        margin-top: 1.5rem;
    }
    .map-container{
        margin-left: 0;
    }
    .all-badges{
        width: 50px;
        height: 50px;
    }
    .badge-name{
        color: #CAAE99; 
        font-size:10px;
    }

    .tooltip-wrapper {
        margin: 0 auto; 
    }
 }

</style>

<div class="container">
    <div class="row mt-2  profile-row p-0">
        <div class="col-md-4">
            {{-- profile --}}
            <div class="d-flex align-items-start  profile-row flex-wrap ">
                <div class=" avatar-wrapper position-relative d-inline-block me-3 mb-3">
                    @if ($user->avatar)
                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle shadow-sm mb-3" style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #9F6B46;">
                    @else
                        <i class="fa-solid fa-circle-user text-secondary mb-3" style="font-size: 110px; border: 5px solid #9F6B46; border-radius: 50%; 
                        padding:0;" ></i>
                    @endif
                    <img  src="{{ asset($latestBadge->image_path) }}" 
                          alt="{{ $latestBadge->name }}"
                          title="{{ $latestBadge->key}}"
                          class="brand latest-badge position-absolute">
                </div>
                <div class="flex-grow-1 text-start">
                    <h3 style="margin-left: 15px;">{{ $user->name }}</h3>

                    <div class="d-flex justify-content-between text-center fw-semibold flex-wrap number">
                        <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none flex-fill">
                            <div class="fs-5 fw-bold">{{ $user->posts->count() }}</div>
                            <div class="small">
                                {{ __('messages.profile.posts') }}
                            </div>
                        </a>
                        <a href="{{ route('profile.followers', $user->id) }}" class="text-decoration-none flex-fill">
                            <div class="fs-5 fw-bold">{{ $user->followers->count() }}</div>
                            <div class="small">
                                {{ __('messages.profile.followers') }}
                            </div>
                        </a>
                        <a href="{{ route('profile.following', $user->id) }}" class="text-decoration-none flex-fill">
                            <div class="fs-5 fw-bold">{{ $user->following->count() }}</div>
                            <div class="small">
                                {{ __('messages.profile.following') }}
                            </div>
                        </a>
                    </div>
                </div>          
            </div>

            <div class="mb-2">
                <h4><span> {{ __('messages.profile.country') }}</span> {{ $user->country }}</h4>
                @if ($user->introduction)
                    <p class="fw-semibold mb-3" style="color:#9F6B46;">
                        {{ $user->introduction }}
                    </p>
                @endif
            </div>

            <div class="row mb-4 justify-content-center">
                @if (Auth::user()->id === $user->id)
                    <div class="col-auto px-2">
                        <a href="{{ route('profile.edit') }}" 
                            class="btn btn-outline shadow-sm" style="font-weight:bold; width:190px; transition:0.3s;">
                            {{ __('messages.profile.left_btn') }}
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('favorite') }}" 
                            class="btn btn-pink shadow-sm" style="font-weight:bold; width:190px;">
                            {{ __('messages.profile.right_btn') }}
                        </a>
                    </div>
                @else
                    <div class="col-auto px-2">
                        @if ($user->isFollowed())
                            <form action="{{ route('follow.destroy', $user->id) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                               <button type="submit" 
                                    class="btn btn-cancel shadow-sm" style=" font-weight:bold; width:180px;">
                                    {{ __('messages.profile.following2') }}
                                </button>
                            </form>
                        @else
                            <form action="{{ route('follow.store', $user->id) }}" method="post" class="d-inline">
                                @csrf
                                <button type="submit" 
                                        class="btn btn-outline shadow-sm" style="font-weight:bold; width:180px; transition:0.3s;">
                                    {{ __('messages.profile.follow') }}
                                </button>
                            </form>
                        @endif
                    </div>

                    <div class="col-auto">
                        <a href="¥" 
                            class="btn btn-pink shadow-sm" style="font-weight:bold; width:180px;">
                            {{ __('messages.profile.dm') }}
                        </a>
                    </div>
                @endif
            </div>
            {{-- Badge --}}
            <h5 class="fw-bold text-center mb-3">------------ Your Badges ------------</h5>

            <div class="d-flex flex-wrap gap-3 mb-3">

                @foreach ($allBadges as $badge)
                    <div class="tooltip-wrapper d-flex flex-column display-content-center align-items-center"
                        data-tooltip="{{ $badge->key }}">
                        <img 
                            src="{{ asset($badge->image_path) }}" 
                            alt="{{ $badge->name }}" 
                            class="brand all-badges"
                            style="
                                @if(!in_array($badge->id, $earnedBadgeIds)) 
                                    filter: grayscale(100%); opacity: 0.3;
                                @endif
                            ">
                        <p class="mb-0 text-center badge-name">
                            {{ $badge->name }}
                        </p>
                    </div>
                @endforeach
            </div>

            {{-- map --}}
           <div class="row">
                <div class="map-container rounded-2 ">
                    <p class="fw-bold h5 click-map text-center mt-3">Click map <span>to view full map</span></p>

                    <a href="{{ route('map.show', $user->id) }}" class="trip-map-a">
                        <div id="map" style="width: 100%; height: 350px;"></div>
                    </a>
                    <div class="spinner-wrapper">
                        <div class="spinner-outer">
                            <div class="spinner-fill"></div>
                            <div class="spinner-text">
                                <p class="label">Completed</p>
                                <p class="count">5
                                     <span style="font-size: 20px">/47</span>
                                </p>
                                <p class="small-text">Prefectures</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-profile 
            :user="$user"
            :prefectures="$prefectures"
            {{-- :allBadges="$allBadges" --}}
            {{-- :earnedBadgeIds="$earnedBadgeIds" --}}
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
                <div class="tab-content shadow p-3" id="followTabsContent">
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
                                                    class="rounded-circle me-4 align-items-center" style="width:60px; height:60px;">
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
                                                class="rounded-circle me-4 align-items-center" style="width:60px; height:60px;">
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

        <div class="col d-none d-md-block">
            <div class="shadow p-3 m-3">
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
                                        class="rounded-circle me-4 align-items-center" style="width:60px; height:60px;">
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

{{-- <script>
    const prefectures = @json($prefectures ?? []); 
</script>



<script>
const prefectureNameMap = {
  "北海道": "Hokkaido",
  "青森県": "Aomori",
  "岩手県": "Iwate",
  "宮城県": "Miyagi",
  "秋田県": "Akita",
  "山形県": "Yamagata",
  "福島県": "Fukushima",
  "茨城県": "Ibaraki",
  "栃木県": "Tochigi",
  "群馬県": "Gunma",
  "埼玉県": "Saitama",
  "千葉県": "Chiba",
  "東京都": "Tokyo",
  "神奈川県": "Kanagawa",
  "新潟県": "Niigata",
  "富山県": "Toyama",
  "石川県": "Ishikawa",
  "福井県": "Fukui",
  "山梨県": "Yamanashi",
  "長野県": "Nagano",
  "岐阜県": "Gifu",
  "静岡県": "Shizuoka",
  "愛知県": "Aichi",
  "三重県": "Mie",
  "滋賀県": "Shiga",
  "京都府": "Kyoto",
  "大阪府": "Osaka",
  "兵庫県": "Hyogo",
  "奈良県": "Nara",
  "和歌山県": "Wakayama",
  "鳥取県": "Tottori",
  "島根県": "Shimane",
  "岡山県": "Okayama",
  "広島県": "Hiroshima",
  "山口県": "Yamaguchi",
  "徳島県": "Tokushima",
  "香川県": "Kagawa",
  "愛媛県": "Ehime",
  "高知県": "Kochi",
  "福岡県": "Fukuoka",
  "佐賀県": "Saga",
  "長崎県": "Nagasaki",
  "熊本県": "Kumamoto",
  "大分県": "Oita",
  "宮崎県": "Miyazaki",
  "鹿児島県": "Kagoshima",
  "沖縄県": "Okinawa"
};

     const userId = {{ $user->id ?? 'null' }};
    window.onload = function() {
      const form = document.querySelector('form');
      const baseWidth = 675;
      const baseHeight = 670;
      let svg;
    
      const projection = d3.geoMercator()
        .center([133, 42]) 
        .translate([baseWidth / 2, baseHeight / 2]);
    
      const path = d3.geoPath().projection(projection);
    
      function adjustProjectionScale() {
      const container = document.querySelector(".map-container");
      const cw = container.clientWidth;
      const ch = container.clientHeight;
      const scaleFactor = Math.min(cw / baseWidth, ch / baseHeight);
      let baseScale = 3000 * scaleFactor;

      if (window.innerWidth < 600) {
        // スマホ
        projection
          .center([133.0, 43.0]) 
          .scale(baseScale * 1.0) 
          .translate([cw / 2, ch / 2.3]); 

      } else {
        //  PC
        projection
          .center([133.0, 42.0]) 
          .scale(baseScale)
          .translate([cw / 2, ch / 2]);
      }
    }
    
    function colorPrefectures(prefectures) {
    prefectures.forEach(pref => {
        const area = document.querySelector(`#pref-${pref.code}`);
        if (area) {
            area.style.fill = pref.has_post ? "#F1BDB2" : "#dcdcdc";
        }
    });

    updateSpinner(prefectures);
}

      function renderMap(data) {

        svg.selectAll(".prefecture")
          .data(data.features.filter(d => d.properties.nam_ja !== "沖縄県"))
          .enter()
          .append("path")
          .attr("class", "prefecture")
          .attr("d", path)
          .attr("id", d => {
            const engName = prefectureNameMap[d.properties.nam_ja];
            const prefData = prefectures.find(p => p.name === engName);
            return prefData ? `pref-${prefData.code}` : null;
          })
          .attr("fill", d => {
            const engName = prefectureNameMap[d.properties.nam_ja];
            const prefData = prefectures.find(p => p.name === engName);
            return prefData && prefData.has_post ? "#F1BDB2" : "#dcdcdc";
          })          
          .attr("stroke", "#333")
          .on("mouseover", function() { d3.select(this).attr("fill", "#ff7f50"); })
          .on("mouseout", function() { d3.select(this).attr("fill", "#dcdcdc"); })
          .on("click", function(event, d) {
            const prefName = d.properties.nam_ja;
            const engName = prefectureNameMap[prefName];
            const prefData = prefectures.find(p => p.name === engName);
            if(prefData){
              loadPosts(prefData.id, engName);
            }
          });
    
        // 沖縄のpath描画
        const okinawaProjection = d3.geoMercator()
          .center([127.6, 26.2])
          .scale(5000)
          .translate([130, 130]); // ← 左上枠の位置調整
        const okinawaPath = d3.geoPath().projection(okinawaProjection);
        const okinawa = data.features.filter(d => d.properties.nam_ja === "沖縄県");
        svg.selectAll(".okinawa")
          .data(okinawa)
          .enter()
          .append("path")
          .attr("class", "okinawa")
          .attr("d", okinawaPath)
          .attr("id", d => {
            const engName = prefectureNameMap[d.properties.nam_ja];
            const prefData = prefectures.find(p => p.name === engName);
            return prefData ? `pref-${prefData.code}` : null;
          })
          .attr("fill", "#ffdcb2")
          .attr("stroke", "#666")
          .attr("stroke-width", 0.5)
          .on("mouseover", function() { d3.select(this).attr("fill", "#ffb37f"); })
          .on("mouseout", function() { d3.select(this).attr("fill", "#ffdcb2"); })
          .on("click", function(event, d) {
            const prefName = d.properties.nam_ja;
            const prefData = prefectures.find(p => p.name === prefName);
            if(prefData){
                loadPosts(prefData.id, prefName);
            }
          });
          prefectures.forEach(pref => {
            if(pref.has_post){
                const prefElement = document.querySelector(`#pref-${pref.code}`);
                if(prefElement){
                    prefElement.style.fill = "#F1BDB2";
                    prefElement.style.transition = "fill 0.3s";
                }
            }
          });

        svg.append("line")
        .attr("x1", 240)
        .attr("y1", 20)
        .attr("x2", 240)
        .attr("y2", 240)
        .attr("stroke", "#666")
        .attr("stroke-width", 1);

        svg.append("line")
        .attr("x1", 20)
        .attr("y1", 240)
        .attr("x2", 240)
        .attr("y2", 240)
        .attr("stroke", "#666")
        .attr("stroke-width", 1);
      }
    
      function drawMap() {
        d3.select("#map").selectAll("*").remove();
        svg = d3.select("#map")
          .append("svg")
          .attr("viewBox", `0 0 ${baseWidth} ${baseHeight}`)
          .attr("preserveAspectRatio", "xMidYMid meet")
          .style("width", "100%")
          .style("height", "100%");
    
        adjustProjectionScale();
    
        d3.json("{{ asset('geojson/japan.geojson') }}").then(renderMap);
      }

      function colorPrefectures(prefectures) {
    prefectures.forEach(pref => {
        const area = document.querySelector(`#pref-${pref.code}`);
        if (area) {
            area.style.fill = pref.has_post ? "#F1BDB2" : "#dcdcdc";
        }
    });

    updateSpinner(prefectures);
}

    drawMap();

    const userId = {{ $user->id ?? 'null' }};
    
    fetch(`/prefectures/${userId}/posts`)
      .then(response => response.json())
      .then(prefectures => {
        prefectures.forEach(pref => {
          const area = document.querySelector(`#pref-${pref.code}`); 
          if (area && pref.has_post) {
            area.style.fill = "#F1BDB2";
          }
        });

      updateSpinner(prefectures);
    })
    .catch(error => console.error('Error loading prefectures:', error));

        drawMap();
    function updateSpinner(prefectures) {
        
      const completed = prefectures.filter(p => p.has_post).length;
      console.log(prefectures);
      const total = 47;
      const degree = (360 / total) * completed; 

      const spinnerOuter = document.querySelector('.spinner-outer');
      spinnerOuter.style.background = `conic-gradient(#F1BDB2 0deg ${degree}deg, #FFF ${degree}deg 360deg)`;

      const countElement = document.querySelector('.spinner-text .count');
      countElement.innerHTML = `${completed}<span style="font-size: 27px">/47</span>`;
    }

            let resizeTimeout;
            window.addEventListener("resize", () => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(() => {
                drawMap();
                }, 400);
            });

            form.addEventListener('submit', function(e) {
    e.preventDefault();

    const url = this.action + '?' + new URLSearchParams(new FormData(this)).toString();

    fetch(url)
        .then(res => res.text())
        .then(html => {
            // サーチ結果差し替え
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const searchResults = doc.querySelector('.search-result-container');
            const targetContainer = document.querySelector('.search-result-container');

            if(searchResults && targetContainer){
                targetContainer.innerHTML = searchResults.innerHTML;
            }

            // マップ再描画
            drawMap();

            // 色付け
            fetch(`/prefectures/${userId}/posts`)
                .then(res => res.json())
                .then(prefectures => colorPrefectures(prefectures));
        });
});


   };
</script>
     --}}