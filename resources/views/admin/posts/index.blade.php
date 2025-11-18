@extends('layouts.app') 

@section('title', 'Admin: Posts') 

@section('content')
@vite(['public/css/admin.css'])


<div class="container my-4 post-page">

  <!-- ナビゲーション部分 -->
  <ul class="nav nav-underline text-center w-25">
      <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.users') }}">User</a>
      </li>
      <li class="nav-item">
          <a class="nav-link active" href="{{ route('admin.posts') }}">Post</a>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.categories') }}">Category</a>
      </li>
  </ul>

  <hr>

    <!-- フィルター部分 -->
    <div class="container my-5">
      <form method="GET" action="{{ route('admin.posts') }}" class="d-flex justify-content-center gap-3">
        <!-- Category -->
        <div class="w-25">
          <label for="category" class="form-label">Category</label>
          <select name="category" id="category" class="form-select">
            <option value="">All</option>
            @foreach ($categories as $category)
              <option value="{{ $category->id }}" {{ $selectedCategory == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
              </option>
            @endforeach
          </select>
        </div>

        <!-- Prefecture -->
        <div class="w-25">
          <label for="prefecture" class="form-label">Prefecture</label>
          <select name="prefecture" id="prefecture" class="form-select">
            <option value="">All</option>
            @foreach ($prefectures as $prefecture)
              <option value="{{ $prefecture->id }}" {{ $selectedPrefecture == $prefecture->id ? 'selected' : '' }}>
                {{ $prefecture->name }}
              </option>
            @endforeach
          </select>
        </div>

        <!-- 検索ボタン -->
        <div class="align-self-end">
          <button type="submit" class="btn btn-outline">
            <i class="fa-solid fa-magnifying-glass"></i> Search
          </button>
        </div>
      </form>
    </div>

    <!-- 投稿一覧テーブル -->
    <div class="container table-responsive">
    <table class="table table-hover align-middle text-center">
      <thead>
        <tr class="fs-5">
          <th>#</th>
          <th>POST</th>
          <th>CATEGORY</th>
          <th>PREFECTURE</th>
          <th>OWNER</th>
          <th>STATUS</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($all_posts as $post)
          <tr>
            <td>{{ $post->id }}</td>
            <td>
              @if ($post->trashed())
                <img src="{{ asset ('storage/' .  $post->images->first()->image )}}" class="img-thumbnail mx-auto" style="width:110px; height:110px; object-fit: cover;">
              @else
                <a href="{{ route('post.show', $post->id) }}">
                  <img src="{{ asset ('storage/' .  $post->images->first()->image )}}" class="img-thumbnail mx-auto" style="width:110px; height:110px; object-fit: cover;">
                </a>
              @endif

            </td>
            <td>
              <div class="col">
                @forelse ($post->categoryPost as $category_post)
                  <div class="tag">{{ $category_post->category->name ?? 'Uncategorised' }}</div>
                @empty
                  <div class="tag">Uncategorised</div>
                @endforelse
              </div>
            </td>
            <td>{{ $post->prefecture->name ?? 'Unknown' }}</td>
            <td>{{ $post->user->name }}</td>
            <td>
              @if ($post->trashed())
                <i class="fa-solid fa-circle text-secondary"></i>&nbsp; Hide
              @else
                <i class="fa-solid fa-circle text-success"></i>&nbsp; Visible
              @endif
            </td>
            <td>
            {{-- @if (Auth::user()->id !== $post->user->id) --}}
                <div class="dropdown">
                    <button class="btn-dropdown" type="button" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-ellipsis me-3"></i>
                    </button>
                    <div class="dropdown-menu admin-dropdown-menu">
                        @if ($post->trashed())
                            <button class="dropdown-item admin-dropdown-item text-center" data-bs-toggle="modal" data-bs-target="#activate-post-{{ $post->id }}">
                                <i class="fa-solid fa-check-to-slot"></i>&nbsp; Visible
                            </button>
                        @else
                        <button class="dropdown-item admin-dropdown-item text-center" data-bs-toggle="modal" data-bs-target="#activate-post-{{ $post->id }}">
                            <i class="fa-solid fa-ban"></i>&nbsp; Hide
                        </button>
                        @endif
                    </div>
                </div>
            {{-- @endif --}}
            @include('admin.posts.modal.status')
          </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center text-muted">No posts found</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    </div>

    <!-- === ページネーション === -->
    <div class="d-flex justify-content-center">
        {{ $all_posts->links('vendor.pagination.custom') }}
    </div> 
</div>
@endsection