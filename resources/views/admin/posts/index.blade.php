@extends('layouts.app') 

@section('title', 'Admin: Posts') 

@section('content')
@vite(['public/css/admin.css'])


<div class="post-page">

  <!-- ナビゲーション部分 -->
  <nav>
    <a href="{{ route('admin.users') }}">User</a>
    <a href="{{ route('admin.posts') }}" class="active">Post</a>
    <a href="{{ route('admin.categories') }}">Category</a>
  </nav>

  <!-- メインコンテンツ -->
  <main>
    <!-- フィルター部分 -->
    <div class="filters mb-3">
      <form method="GET" action="{{ route('admin.posts') }}" class="d-flex gap-3">
        <!-- Category -->
        <div class="filter-group">
          <label for="category">Category</label>
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
        <div class="filter-group">
          <label for="prefecture">Prefecture</label>
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
        <div class="search-bar-2 align-self-end">
          <button type="submit" class="btn">
            <i class="fa-solid fa-magnifying-glass"></i> Search
          </button>
        </div>
      </form>
    </div>

    <!-- 投稿一覧テーブル -->
    <table>
      <thead>
        <tr>
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
              @php
                  $images = is_string($post->image) ? json_decode($post->image, true) : $post->image;
              @endphp

              <a href="{{ route('post.show', $post->id) }}">
                  @if ($images && count($images) > 0)
                      <img src="data:image/jpeg;base64,{{ $images[0] }}" alt="{{ $post->id }}" class="table-post-image">
                  @else
                      <img src="{{ asset('images/no-image.png') }}" alt="No image" class="table-post-image">
                  @endif
              </a>
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
                    <button class="btn-dropdown btn-sm" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-ellipsis"></i>
                    </button>
                    <div class="dropdown-menu">
                        @if ($post->trashed())
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#activate-post-{{ $post->id }}">
                                <i class="fa-solid fa-check-to-slot"></i>&nbsp; Visible
                            </button>
                        @else
                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#activate-post-{{ $post->id }}">
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

    <!-- === ページネーション === -->
    <div class="d-flex justify-content-center">
        {{ $all_posts->links('vendor.pagination.custom') }}
    </div>
  </main>
</div>
@endsection