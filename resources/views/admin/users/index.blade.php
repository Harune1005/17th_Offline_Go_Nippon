@extends('layouts.app')

@section('title', 'User Management')

@section('content')
{{-- ================= ユーザー管理ページ ================= --}}
@vite(['public/css/admin.css'])


<div class="container my-4 user-page">

  <!-- === ナビゲーション === -->
  <ul class="nav nav-underline text-center w-25">
      <li class="nav-item">
          <a class="nav-link active" href="{{ route('admin.users') }}">User</a>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.posts') }}">Post</a>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.categories') }}">Category</a>
      </li>
  </ul>

  <hr>

  {{-- === 検索バー === --}}
  <div class="my-5">
    <form action="{{ route('admin.users.search') }}" class="row justify-content-center gap-2">
      @csrf
      <div class="col-5">
        <input type="text" name="search" class="form-control" placeholder="Search by Name...">
      </div>
      <div class="col-auto">
        <button class="btn btn-outline">
          <i class="fa-solid fa-magnifying-glass"></i> Search
        </button>
      </div>
    </form>
  </div>

  {{-- === ユーザー一覧テーブル === --}}
  <div class="container table-responsive">
    <table class="table table-hover align-middle text-center">
      <thead>
        <tr class="fs-5">
          <th>#</th>
          <th>Avatar</th>
          <th>Name</th>
          <th>Country</th>
          <th>Email</th>
          <th>Created at</th>
          <th>Status</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($all_users as $user)
        <tr>
          <td>{{ $user->id }}</td>
          <td>
            @if ($user->avatar)
              <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle d-block mx-auto border border-2 border-dark" style="width:45px; height:45px; object-fit: cover;">
            @else
              <i class="fa-solid fa-circle-user fa-3x d-block text-center text-secondary icon-md m-auto"></i>
            @endif
          </td>
          <td>
            @if ($user->trashed())
              {{ $user->name }}
            @else
              <a href="{{ route('profile.show', $user->id) }}" class="name-link text-decoration-none fw-bold">
                {{ $user->name }}
              </a>
            @endif
          </td>
          <td>{{ $user->country }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->created_at }}</td>
          <td>
            @if ($user->trashed())
              <i class="fa-solid fa-circle text-secondary"></i>&nbsp; Inactive
            @else
              <i class="fa-solid fa-circle text-success"></i>&nbsp; Active
            @endif
          </td>
          <td>
            {{-- @if (Auth::user()->id !== $user->id) --}}
            <div class="dropdown">
              <button class="btn-dropdown" type="button" data-bs-toggle="dropdown">
                <i class="fa-solid fa-ellipsis me-3"></i>
              </button>
              <div class="dropdown-menu admin-dropdown-menu">
                @if ($user->trashed())
                <button class="dropdown-item admin-dropdown-item text-center" data-bs-toggle="modal" data-bs-target="#activate-user-{{ $user->id }}">
                  <i class="fa-solid fa-user-check"></i> Activate {{ $user->name }}
                </button>
                @else
                <button class="dropdown-item admin-dropdown-item text-center" data-bs-toggle="modal" data-bs-target="#deactivate-user-{{ $user->id }}">
                  <i class="fa-solid fa-user-slash"></i> Deactivate {{ $user->name }}
                </button>
                @endif
              </div>
            </div>
            @include('admin.users.modal.status')
            {{-- @endif --}}
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="text-center text-muted">No users found</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  

  {{-- === ページネーション === --}}
  <div class="d-flex justify-content-center">
    {{ $all_users->links('vendor.pagination.custom') }}
  </div>

</div>
@endsection