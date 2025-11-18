@extends('layouts.app') 

@section('title', 'Admin: Categories') 

@section('content')
@vite(['public/css/admin.css'])

<div class="container my-4 category-page">

    <!-- === ナビゲーション === -->
    <ul class="nav nav-underline text-center w-25">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.users') }}">User</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.posts') }}">Post</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('admin.categories') }}">Category</a>
        </li>
    </ul>

    <hr>

    <!-- === カテゴリー追加フォーム === -->
    <div class="my-5">
        <form action="{{ route('admin.categories.store') }}" method="post" class="row justify-content-center gap-2">
            @csrf
              <div class="col-5">
                  <input type="text" name="name" class="form-control flex-grow-1" placeholder="Add a category..." value="{{ old('name') }}">
              </div>
              <div class="col-auto">
                <button type="submit" class="btn btn-outline">
                    <i class="fa-solid fa-plus"></i> Add
                </button>
              </div>
            </div>


        </form>
        @error('name')
        <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- === カテゴリー一覧テーブル === -->
    <div class="container table-responsive">
        <table class="table table-hover align-middle text-center">
            <thead>
                <tr class="fs-5">
                    <th>#</th>
                    <th>Name</th>
                    <th>Count</th>
                    <th>Last Update</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($all_categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td class="text-truncate" style="max-width: 150px;">{{ $category->name }}</td>
                    <td>{{ $category->categoryPost()->count() }}</td>
                    <td>{{ $category->updated_at->format('Y-m-d H:i') }}</td>
                    <td class="text-end">
                        <div class="d-flex flex-wrap gap-1 justify-content-center">
                            <button class="btn btn-sm btn-warning w-25" data-bs-toggle="modal" data-bs-target="#edit-category-{{ $category->id }}">
                                <i class="fa-solid fa-pen mx-auto"></i>
                            </button>
                            @include('admin.categories.modal.edit')

                            <button class="btn btn-sm btn-danger w-25" data-bs-toggle="modal" data-bs-target="#delete-category-{{ $category->id }}">
                                <i class="fa-solid fa-trash-can mx-auto"></i>
                            </button>
                            @include('admin.categories.modal.delete')
                        </div>
                    </td>
                </tr>
                @endforeach

                @if ($uncategorised_count > 0)
                <tr class="table-secondary">
                    <td>-</td>
                    <td>Uncategorised</td>
                    <td>{{ $uncategorised_count }}</td>
                    <td>-</td>
                    <td></td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- === ページネーション === -->
    <div class="d-flex justify-content-center mt-3">
        {{ $all_categories->links('vendor.pagination.custom') }}
    </div>

</div>
@endsection