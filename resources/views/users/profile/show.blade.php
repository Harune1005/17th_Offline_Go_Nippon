@extends('layouts.app')

@section('title', 'Profile ')

@section('content')

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
                                    <div class="card  post-card border-0 p-0 shadow rounded-2 overflow-hidden">
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

