
@extends('layouts.app')

@section('title', 'Profile ')

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

    {{-- Profile area --}}
<div class="container">
    <div class="row mt-2 profile-row p-0">
        <div class="col-md-4">
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
                        <a href="{{ route('profile.followers', ['id' => $user->id, 'tab' => 'followers']) }}" class="text-decoration-none flex-fill">
                            <div class="fs-5 fw-bold">{{ $user->followers->count() }}</div>
                            <div class="small">{{ $user->followers->count() == 1 ? 'Follower' : 'Followers' }}</div>
                        </a>

                        <a href="{{ route('profile.following', ['id' => $user->id, 'tab' => 'following']) }}" class="text-decoration-none flex-fill">
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
                            class="btn editbtn shadow-sm"
                            style="background-color:#F1BDB2; color:white; font-weight:bold; width:190px; border:2px solid #F1BDB2; transition:0.3s;"
                            onmouseover="this.style.backgroundColor='transparent'; this.style.color='#F1BDB2';"
                            onmouseout="this.style.backgroundColor='#F1BDB2'; this.style.color='white';">
                            Edit profile
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('favorite') }}" 
                            class="btn editbtn shadow-sm"
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
                                <input type="hidden" name="return_url" value="{{ url()->current() }}">
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
                                <input type="hidden" name="return_url" value="{{ url()->current() }}">
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
                        <a href="#" 
                            class="btn shadow-sm"
                            style="background-color:white; color:#F1BDB2; font-weight:bold; width:180px; border:2px solid #F1BDB2; transition:0.3s;"
                            onmouseover="this.style.backgroundColor='#F1BDB2'; this.style.color='white';"
                            onmouseout="this.style.backgroundColor='white'; this.style.color='#F1BDB2';">
                            DM
                        </a>
                    </div>
                @endif
            </div>

        {{-- Map --}}
            <div class="row">
                <p class="fw-bold h5 click-map text-center">Click map <span>to view full map</span></p>
                <div class="map-container">
                    <a href="/profile/trip-map" class="trip-map-a"> 
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

        {{-- Post area --}}
        <div class="col-md-8">
            <div class="row mt-3 mb-2">
                <div class="col-12">
                    @if ($user->posts->isNotEmpty())
                        <div class="row g-3">
                            @foreach ($user->posts as $post)
                                @if ($post->images->isNotEmpty())
                                    <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                                        <div class="card border-0 p-0 shadow-sm rounded-2 overflow-hidden">
                                            <div class="card-header border-0 p-0">
                                                <a href="{{ route('post.show', $post->id) }}" class="d-block position-relative">
                                                    @if ($post->images->count() > 1)
                                                        <div id="carouselPost{{ $post->id }}" 
                                                            class="carousel slide" 
                                                            data-bs-ride="carousel">
                                                            <div class="carousel-inner">
                                                                @foreach ($post->images as $key => $image)
                                                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                                        <img src="data:image/jpeg;base64,{{ $image->image }}" 
                                                                            alt="Post image {{ $post->id }}" 
                                                                            class="d-block w-100 post-image"
                                                                            style="width: 100%; height: auto; object-fit: cover;">
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                            <button class="carousel-control-prev" type="button"
                                                                data-bs-target="#carouselPost{{ $post->id }}" data-bs-slide="prev">
                                                                <span class="carousel-control-prev-icon"></span>
                                                            </button>
                                                            <button class="carousel-control-next" type="button"
                                                                data-bs-target="#carouselPost{{ $post->id }}" data-bs-slide="next">
                                                                <span class="carousel-control-next-icon"></span>
                                                            </button>
                                                        </div>
                                                    @else
                                                        <img src="data:image/jpeg;base64,{{ $post->images->first()->image }}" 
                                                            alt="Post image {{ $post->id }}" 
                                                            class="post-image"
                                                            style="width: 100%; height: auto; object-fit: cover;">
                                                    @endif
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="d-flex flex-column justify-content-center align-items-center text-center"
                            style="min-height: 60vh;">
                            <i class="fa-regular fa-image mb-3" style="font-size: 9rem; color:#B0A695;"></i>
                            <h3 class="fw-semibold" style="color:#776B5D;">No Posts Yet</h3>
                        </div>
                    @endif
                </div>
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
    