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

.spinner-circle {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  background: conic-gradient(#F1BDB2 0deg, #FFFF 0deg); 
  transition: background 0.5s ease;
}

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
  font-size: 20px;
  margin-bottom: 2px;
}

.spinner-text .count {
  font-family: 'Source Serif Pro', serif;
  color: #9F6B46;
  font-weight: bold;
  font-size: 45px;
  line-height: 1;
}
.spinner-text .small-text {
    font-size: 15px;
    color: #CAAE99;
    
}
.spinner-wrapper {
  position: absolute;
  bottom: 10px;
  right: 10px;
  z-index: 10; 
}
.map-container svg {
  width: 100%;
  max-width: 600px;
  height: auto;
}

.selected-pref {
    fill: #ffb08a !important;
    stroke: #cc6644;
    stroke-width: 1.5;
    transition: all 0.3s ease;
}
.has-post {
  fill: #F1BDB2;
  transition: fill 0.3s;
}
.tooltip {
  position: absolute;
  padding: 5px 10px;
  background-color: #333;
  color: #fff;
  border-radius: 5px;
  font-size: 0.9em;
  display: none;
  pointer-events: none; /* ホバーを妨げない */
  white-space: nowrap;
  z-index: 10;
}



@media (max-width: 600px) {
    html, body {
    overflow-x: hidden; 
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
    transform: translateX(0) scale(0.8);
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

</style>

    {{-- Profile area --}}
<div class="container">
    <div class="row mt-2 profile-row p-0">
        <x-profile 
          :user=$user
          :prefectures=$prefectures
          :allBadges=$allBadges
          :earnedBadgeIds=$earnedBadgeIds
          :latestBadge=$latestBadge
        />

        {{-- Post area --}}
        <div class="col-md-8">
            <div class="row mt-3 mb-2">
                <div class="col-12">
                    @if ($posts->isNotEmpty())
                        <div class="row g-3">
                            @foreach ($posts as $post)
                              @php
                                  $mediaItems = $post->media->take(3);
                              @endphp
                                <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class="card border-0 p-0 shadow-sm rounded-2 overflow-hidden">
                                        <div class="card-header border-0 p-0">

                                            <a href="{{ route('post.show', $post->id) }}" class="d-block position-relative">
                                                @if ($mediaItems->count() > 1)
                                                    <div id="carouselPost{{ $post->id }}" 
                                                        class="carousel slide" 
                                                        data-bs-ride="carousel">
                                                        <div class="carousel-inner">
                                                            @foreach ($mediaItems as $index => $media)
                                                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                                  {{-- image --}}
                                                                  @if ($media->type === 'image')
                                                                      <img  src="{{ asset('storage/' . $media->path) }}"
                                                                                alt="Post image" 
                                                                        class="d-block w-100 post-image"
                                                                        style="width: 100%; height: auto; object-fit: cover;">
                                                                  @endif
                                                                  {{-- video --}}
                                                                  @if ($media->type === 'video')
                                                                    <video
                                                                      src="{{ asset('storage/' . $media->path) }}"
                                                                      muted
                                                                      playsinline
                                                                      class="d-block w-100"
                                                                      style="object-fit: cover; aspect-ratio: 1/1;">
                                                                    </video>
                                                                  @endif
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
                                                @elseif($mediaItems->count() === 1)
                                                    @php
                                                        $media = $mediaItems->first();
                                                    @endphp
                                                    {{-- image --}}
                                                    @if ($media->type === 'image')
                                                        <img src="{{ asset('storage/' . $media->path) }}" 
                                                        alt="Post image {{ $post->id }}" 
                                                        class="post-image"
                                                        style="width: 100%; height: auto; object-fit: cover;">
                                                    @endif
                                                    {{-- video --}}
                                                    @if ($media->type === 'video')
                                                        <video
                                                            src="{{ asset('storage/' . $media->path) }}"
                                                            muted
                                                            playsinline
                                                            class="d-block w-100"
                                                            style="object-fit: cover; aspect-ratio: 1/1;">
                                                        </video>
                                                    @endif
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="d-flex flex-column justify-content-center align-items-center text-center"
                            style="min-height: 60vh;">
                            <i class="fa-regular fa-image mb-3" style="font-size: 9rem; color:#B0A695;"></i>
                            <h3 class="fw-semibold" style="color:#776B5D;">
                              {{ __('messages.profile.no_post') }}
                            </h3>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="{{ asset('js/profile-map.js') }}"></script>
@stack('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        profileMap({
            userId: {{ $user->id }},
            prefectures: @json($prefectures)
        });
    });
</script>

