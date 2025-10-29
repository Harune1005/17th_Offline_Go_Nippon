@extends('layouts.app')

@section('content')
<style>
    .col-md-4{
        font-family: 'Source Serif Pro', serif;
    }
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


    @media (max-width: 600px) {
        html, body {
        overflow-x: hidden; /* 横スクロール禁止 */
    }

    .col-md-4{
        padding-right:0;
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

    /* ボタンのマージン調整 */
    .btn {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }

    /* スピナーの位置調整も微修正（右にはみ出ることがあるため） */
    .spinner-wrapper {
        right: 10%;
        transform: translateX(0) scale(0.9);
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

    }
        .map-container {
    position: relative;
    width: 100%;
    height: 350px;
    background-color: #E6F4FA;
    border-radius: 20px;
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




    /* 外円 */
    .spinner-outer {
    position: relative;
    width: 130px;
    height: 130px;
    }

    .spinner-outer::before {
    content: '';
    position: absolute;
    inset: 0;
    border: 15px solid #FFFF;
    border-radius: 50%;
    }


    .spinner-outer::after {
    content: '';
    position: absolute;
    inset: 0;
    border: 15px solid transparent;
    border-top-color: #F1BDB2;
    border-radius: 50%;
    animation: spin 1.5s linear infinite;
    }


    /* 中央のテキスト */
    .spinner-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    }

    .spinner-text p {
    margin: 0;
    }

    .spinner-text .label {
    font-family: 'Source Serif Pro', serif;
    color: #9F6B46;
    font-weight: 600;
    font-size: 15px;
    }

    .spinner-text .count {
    font-family: 'Source Serif Pro', serif;
    color: #9F6B46;
    font-weight: bold;
    font-size: 32px;
    }
    .spinner-wrapper {
    position: absolute;
    bottom: 10px;
    right: 10px;
    z-index: 10; /* 地図の上に出す */
    }

</style>

<div class="container">
    <div class="row mt-2 justify-content-center">
        <div class="col d-none d-md-block">
            {{-- profile --}}
            <div class="d-flex align-items-start ps-2 profile-row flex-wrap">
                <div class="me-3 mb-3">
                    @if ($user->avatar)
                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle shadow-sm mb-3" style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #9F6B46;">
                    @else
                        <i class="fa-solid fa-circle-user text-secondary mb-3" style="font-size: 110px; border: 5px solid #9F6B46; border-radius: 50%; 
                        padding:0;" ></i>
                    @endif
                </div>
                <div class="flex-grow-1 text-start">
                    <h3 style="margin-left: 15px;">{{ $user->name }}</h3>

                    <div class="d-flex justify-content-between text-center fw-semibold flex-wrap number">
                        <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none flex-fill">
                            <div class="fs-5 fw-bold">{{ $user->posts->count() }}</div>
                            <div class="small">Posts</div>
                        </a>
                        <a href="{{ route('profile.followers', $user->id) }}" class="text-decoration-none flex-fill">
                            <div class="fs-5 fw-bold">{{ $user->followers->count() }}</div>
                            <div class="small">{{ $user->followers->count() == 1 ? 'Follower' : 'Followers' }}</div>
                        </a>
                        <a href="{{ route('profile.following', $user->id) }}" class="text-decoration-none flex-fill">
                            <div class="fs-5 fw-bold">{{ $user->following->count() }}</div>
                            <div class="small">Following</div>
                        </a>
                    </div>
                </div>          
            </div>

            <div class="mb-2">
                <h4><span> country:</span> {{ $user->country }}</h4>
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
                            class="btn shadow-sm"
                            style="background-color:#F1BDB2; color:white; font-weight:bold; width:190px; border:2px solid #F1BDB2; transition:0.3s;"
                            onmouseover="this.style.backgroundColor='transparent'; this.style.color='#F1BDB2';"
                            onmouseout="this.style.backgroundColor='#F1BDB2'; this.style.color='white';">
                            Edit profile
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="#" 
                            class="btn shadow-sm"
                            style="background-color:white; color:#F1BDB2; font-weight:bold; width:190px; border:2px solid #F1BDB2; transition:0.3s;"
                            onmouseover="this.style.backgroundColor='#F1BDB2'; this.style.color='white';"
                            onmouseout="this.style.backgroundColor='white'; this.style.color='#F1BDB2';">
                            Favorite
                        </a>
                    </div>
                @else
                    <div class="col-auto px-2">
                        @if ($user->isFollowed())
                            <form action="{{ route('follow.destroy', $user->id) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                               <button type="submit" 
                                    class="btn shadow-sm"
                                    style="background-color:#B0B0B0; color:white; font-weight:bold; width:180px; border:2px solid #B0B0B0; transition:0.3s;"
                                    onmouseover="this.style.backgroundColor='white'; this.style.color='#B0B0B0';"
                                    onmouseout="this.style.backgroundColor='#B0B0B0'; this.style.color='white';">
                                    Following
                                </button>
                            </form>
                        @else
                            <form action="{{ route('follow.store', $user->id) }}" method="post" class="d-inline">
                                @csrf
                                <button type="submit" 
                                        class="btn shadow-sm"
                                        style="background-color:#F1BDB2; color:white; font-weight:bold; width:180px; border:2px solid #F1BDB2; transition:0.3s;"
                                        onmouseover="this.style.backgroundColor='transparent'; this.style.color='#F1BDB2';"
                                        onmouseout="this.style.backgroundColor='#F1BDB2'; this.style.color='white';">
                                    Follow
                                </button>
                            </form>
                        @endif
                    </div>

                    <div class="col-auto">
                        <a href="¥" 
                            class="btn editbtn shadow-sm"
                            style="background-color:white; color:#F1BDB2; font-weight:bold; width:180px; border:2px solid #F1BDB2; transition:0.3s;"
                            onmouseover="this.style.backgroundColor='#F1BDB2'; this.style.color='white';"
                            onmouseout="this.style.backgroundColor='white'; this.style.color='#F1BDB2';">
                            DM
                        </a>
                    </div>
                @endif
            </div>
            
            {{-- map --}}
           <div class="row">
                <p class="fw-bold h5 click-map text-center">Click map <span>to view full map</span></p>
                <div class="map-container">
                    <a href="#" class="trip-map-a">
                        <div id="map" style="width: 100%; height: 350px;"></div>
                    </a>
                    <div class="spinner-wrapper">
                        <div class="spinner-outer">
                            <div class="spinner-text">
                                <p class="label">Completed</p>
                                <p class="count">5 <span style="font-size: 20px">/47</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="mx-auto" style="max-width: 500px;">
                <form action="{{ route('follow.search', $user->id) }}" method="GET" class="d-flex mb-3">
                    <input type="text" name="search" value="{{ $keyword ?? '' }}" placeholder="Search User ...." class="d-flex form-control me-2" style="width: 75%;">
                    <input type="hidden" name="tab" value="{{ $activeTab ?? 'followers' }}">
                    <button class="btn follow-btn ms-auto">
                        <i class="fa-solid fa-magnifying-glass"></i>Search
                    </button>
                </form>

                {{-- tabs --}}
                <div class="mx-auto w-100 mb-2">
                    <ul class="nav nav-tabs border-bottom-0 justify-contenr-center" id="followTabs" role="tablist" style="height: 50px;">
                        <li class="nav-item text-center flex-fill follow-tab" role="presentation">
                            <button class="nav-link h-100 w-100 {{ $activeTab === 'followers' ? 'active' : '' }}"
                                id="followers-tab" data-bs-toggle="tab" data-bs-target="#followers" type="button" role="tab" aria-controls="followers"
                                aria-selected="{{ $activeTab === 'followers' ? 'true' : 'false' }}">
                                Followers
                            </button>
                        </li>
                        <li class="nav-item text-center flex-fill follow-tab" role="presentation">
                            <button class="nav-link h-100 w-100 {{ $activeTab === 'following' ? 'active' : '' }}"
                                id="followings-tab" data-bs-toggle="tab" data-bs-target="#followings" type="button" role="tab" aria-controls="followings"
                                aria-selected="{{ $activeTab === 'following' ? 'true' : 'false' }}">
                                Followings
                            </button>
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
                                    {{ $user->followers->count() }} Followers
                                </h2>
                            </div>

                            @foreach ($user->followers as $follower)
                                <div class="d-flex align-items-center rounded-3 p-3 mt-3" style="height: 100px;">
                                    <a href="{{ route('profile.show', $follower->id) }}" class="text-decoration-none">
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
                                                    <button type="submit" class="btn m-0 following-btn">Following</button>
                                                </form>

                                            @else
                                                <form action="{{ route('follow.store', $follower->id) }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="tab" value="followers">
                                                    <button type="submit" class="btn m-0 follow-btn">Follow</button>
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if (isset($searchResults) && $activeTab === 'followers')
                            <div class="search-result-container">
                                @include('search_result', ['searchResults' => $searchResults])
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
                                    {{ $user->following->count() }} Followings
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
                                                    <button type="submit" class="btn m-0 following-btn">Following</button>
                                                </form>
                                            @else
                                                <form action="{{ route('follow.store', $following->id) }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="tab" value="following">
                                                    <button type="submit" class="btn m-0 follow-btn">Follow</button>
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if (isset($searchResults) && $activeTab === 'following')
                            <div class="search-result-container">
                                @include('search_result', ['searchResults' => $searchResults])
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
                        <i class="fa-solid fa-user"></i> Recommend Users
                    </h2>
                </div>

                @if ($suggested_users->isNotEmpty())
                    @foreach ($suggested_users as $user)
                        <div class="d-flex align-items-center rounded-3 p-3" style="height: 100px;">
                            <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none">
                                @if ($user->avatar)
                                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}"
                                        class="rounded-circle me-4 align-items-center" style="width:60px; height:60px;">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary d-block text-center icon-md me-4" style="font-size:60px;"></i>
                                @endif
                            </a>

                            <div class="d-flex flex-column align-items-start">
                                <h6 class="mb-0 fw-bold">{{ $user->name }}</h6>
                            </div>

                            <div class="d-flex align-items-center justify-content-center ms-auto">
                                <form action="{{ route('follow.store', $user->id) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="tab" id="current-tab" value="{{ $activeTab ?? 'followers' }}">
                                    <button type="submit" class="btn m-0 follow-btn">Follow</button>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const container = document.getElementById("map");
        const width = container.clientWidth; // ← 画面幅に合わせる！
        const height = 350;
    
      const svg = d3.select("#map")
        .append("svg")
        .attr("width", width)
        .attr("height", height);
    
      // 投影法（地球を2Dに写すための設定）
      const projection = d3.geoMercator()
        .center([136.0, 38.0]) // 日本の中心あたり
        .scale(980)
        .translate([width / 2, height / 2]);
    
      const path = d3.geoPath().projection(projection);
    
      // GeoJSONを読み込んで描画
      d3.json("https://raw.githubusercontent.com/dataofjapan/land/master/japan.geojson").then(function(data) {
        svg.selectAll("path")
          .data(data.features)
          .enter()
          .append("path")
          .attr("d", path)
          .attr("fill", "#dcdcdc")
          .attr("stroke", "#333")
          .on("mouseover", function(event, d) {
            d3.select(this).attr("fill", "#ff7f50");
          })
          .on("mouseout", function(event, d) {
            d3.select(this).attr("fill", "#dcdcdc");
          })
          .on("click", function(event, d) {
            alert(d.properties.nam_ja + " がクリックされました");
          });
      });
    });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabInput = document.querySelector('input[name="tab"]') || document.getElementById('current-tab');
            const searchInput = document.querySelector('input[name="search"]');
            const tabButtons = document.querySelectorAll('#followTabs button[data-bs-toggle="tab"]');
            const followersPane = document.querySelector('#followers');
            const followingPane = document.querySelector('#followings');

            // タブ切り替え時の処理
            tabButtons.forEach(button => {
                button.addEventListener('shown.bs.tab', function (event) {
                    const activeTabId = event.target.getAttribute('data-bs-target');
                    const activeTab = activeTabId.includes('following') ? 'following' : 'followers';
                    
                    // 🔹 現在のタブを hidden input に保存（これが重要）
                    if (tabInput) tabInput.value = activeTab;

                    // 🔹 検索欄クリア
                    if (searchInput) searchInput.value = '';

                    // 🔹 通常リストを表示、検索結果を非表示
                    if (activeTab === 'followers') {
                        toggleLists(followersPane, true);
                        toggleLists(followingPane, true); // ← 前のタブも復元
                    } else {
                        toggleLists(followingPane, true);
                        toggleLists(followersPane, true);
                    }
                });
            });

            // リスト切替関数
            function toggleLists(pane, showDefault) {
                const defaultList = pane.querySelector('.default-list');
                const searchResult = pane.querySelector('.search-result-container');
                if (defaultList) defaultList.classList.toggle('d-none', !showDefault);
                if (searchResult) searchResult.classList.toggle('d-none', showDefault);
            }

            // 検索時の動作
            const searchForm = document.querySelector('form[action*="follow/search"]');
            if (searchForm) {
                searchForm.addEventListener('submit', function() {
                    const activeTab = tabInput ? tabInput.value : 'followers';
                    const pane = activeTab === 'following' ? followingPane : followersPane;
                    toggleLists(pane, false);
                });
            }
        });
    </script>
