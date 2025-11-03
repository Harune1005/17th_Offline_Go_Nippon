@extends('layouts.app') 

@section('title', 'Admin: Categories') 

@section('content')
@vite(['public/css/admin.css'])

<div class="category-page">

  <!-- === ナビゲーション === -->
  <nav>
    <a href="{{ route('admin.users') }}">User</a>
    <a href="{{ route('admin.posts') }}">Post</a>
    <a href="{{ route('admin.categories') }}" class="active">Category</a>
  </nav>

  <!-- === 検索バー === -->
  <div class="search-bar">
    <form action="{{ route('admin.categories.store') }}" method="post">
      @csrf
      <input type="text" name="name" placeholder="Add a category..." value="{{ old('name') }}">
      <button type="submit"><i class="fa-solid fa-plus"></i> Add</button>
    </form>
    @error('name')
      <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
  </div>

  <!-- === ユーザー一覧テーブル === -->
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Count</th>
          <th>Last Update</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
            @foreach ($all_categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->categoryPost()->count() }}</td>
                <td>{{ $category->updated_at}}</td>
                <td>
                    <div class="d-flex gap-2 p-0">
                            <button class="btn" data-bs-toggle="modal" data-bs-target="#edit-category-{{ $category->id }}" >
                                <i class="edit fa-solid fa-pen"></i>
                            </button>
                        @include('admin.categories.modal.edit')
                            <button class="btn" data-bs-toggle="modal" data-bs-target="#delete-category-{{ $category->id }}">
                                <i class="delete fa-solid fa-trash-can"></i>
                            </button>
                         @include('admin.categories.modal.delete')
                    </div>
                </td>
            </tr>
            @endforeach
            @if ( $uncategorised_count > 0)
            <tr>
                <td></td>
                <td>
                    Uncategorised
                </td>
                <td>
                    {{ $uncategorised_count }}
                </td>
                <td></td>
                <td></td>
            </tr>
           @endif
        </tbody>
    </table>

  <!-- === ページネーション === -->
    <div class="d-flex justify-content-center">
        {{ $all_categories->links('vendor.pagination.custom') }}
    </div>

</div>
@endsection

