@extends('layouts.app')

@section('title', 'User Management')

@section('content')
{{-- ================= ユーザー管理ページ ================= --}}
@vite(['public/css/admin.css'])


<div class="user-page">

  {{-- === ナビゲーション === --}}
  <nav>
    <a href="{{ route('admin.users') }}" class="active">User</a>
    <a href="{{ route('admin.posts') }}">Post</a>
    <a href="{{ route('admin.categories') }}">Category</a>
  </nav>

  {{-- === 検索バー === --}}
  <div class="search-bar">
    <form action="{{ route('admin.users.search') }}">
      @csrf
      <input type="text" name="search" class="form-control form-control-sm" placeholder="Search by Name...">
      <button>Search</button>
    </form>
  </div>

  {{-- === ユーザー一覧テーブル === --}}
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Profile</th>
        <th>Name</th>
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
          <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="avatar rounded-circle d-block mx-auto">
          @else
          <i class="fa-solid fa-circle-user fa-2x d-block text-center icon-md m-auto"></i>
          @endif
        </td>
        <td>
          <a href="{{ route('profile.show', $user->id) }}" class="name-link text-decoration-none fw-bold">
              {{ $user->name }}
          </a>
        </td>
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
            <button class="btn-dropdown" type="button">
              <i class="fa-solid fa-ellipsis"></i>
            </button>
            <div class="dropdown-menu">
              @if ($user->trashed())
              <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#activate-user-{{ $user->id }}">
                <i class="fa-solid fa-user-check"></i> Activate {{ $user->name }}
              </button>
              @else
              <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deactivate-user-{{ $user->id }}">
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
  

  {{-- === ページネーション === --}}
  <div class="d-flex justify-content-center">
    {{ $all_users->links('vendor.pagination.custom') }}
  </div>

</div>
@endsection