@extends('layouts.app') 

@section('title', 'User Management') 

@section('content')
{{-- ================= ユーザー管理ページ ================= --}}
@vite(['public/css/admin.css'])


<div class="user-page">

  {{-- === ナビゲーション === --}}
  <nav>
    <a href="#" class="active">User</a>
    <a href="#">Post</a>
    <a href="#">Category</a>
  </nav>

  {{-- === 検索バー === --}}
  <div class="search-bar">
    <input type="text" placeholder="Search by Name...">
    <button>Search</button>
  </div>

  {{-- === ユーザー一覧テーブル === --}}
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Profile</th>
        <th>Image</th>
        <th>Name</th>
        <th>Email</th>
        <th>Country</th>
        <th>Status</th>
        <th>Last Login</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td><div class="profile-icon">👤</div></td>
        <td>Mark</td>
        <td><a href="#" class="name-link">Otto</a></td>
        <td>@mdo</td>
        <td>Philippines</td>
        <td><span class="status-active">● </span>Active</td>
        <td>2025-10-06 13:25</td>
        <td class="text-end">
          <div class="dropdown">
            <button class="btn-dropdown" type="button">
              <i class="fa-solid fa-ellipsis"></i>
            </button>
            <ul class="dropdown-menu">
              <li>
                <button class="dropdown-item text-success">
                  <i class="fa-solid fa-user-check me-2"></i>Activate
                </button>
              </li>
              <li>
                <button class="dropdown-item text-danger">
                  <i class="fa-solid fa-user-slash me-2"></i>Deactivate
                </button>
              </li>
            </ul>
          </div>
        </td>
      </tr>
      <td>2</td>
        <td><div class="profile-icon">👤</div></td>
        <td>Jacob</td>
        <td><a href="#" class="name-link">Thornton</a></td>
        <td>@mdo</td>
        <td>USA</td>
        <td><span class="status-active">● </span>Active</td>
        <td>2025-10-06 13:25</td>
        <td class="text-end">
            <div class="dropdown">
            <button class="btn-dropdown" type="button">
                <i class="fa-solid fa-ellipsis"></i>
            </button>
            <ul class="dropdown-menu">
                <li><button class="dropdown-item text-success"><i class="fa-solid fa-user-check me-2"></i>Activate</button></li>
                <li><button class="dropdown-item text-danger"><i class="fa-solid fa-user-slash me-2"></i>Deactivate</button></li>
            </ul>
            </div>
        </td>
        </tr>
        <tr>
        <td>3</td>
        <td><div class="profile-icon">👤</div></td>
        <td>Larry</td>
        <td><a href="#" class="name-link">the Bird</a></td>
        <td>@mdo</td>
        <td>Australia</td>
        <td><span class="status-inactive">● </span>Inactive</td>
        <td>2025-10-06 13:25</td>
        <td class="text-end">
            <div class="dropdown">
            <button class="btn-dropdown" type="button">
                <i class="fa-solid fa-ellipsis"></i>
            </button>
            <ul class="dropdown-menu">
                <li><button class="dropdown-item text-success"><i class="fa-solid fa-user-check me-2"></i>Activate</button></li>
                <li><button class="dropdown-item text-danger"><i class="fa-solid fa-user-slash me-2"></i>Deactivate</button></li>
            </ul>
            </div>
        </td>
        </tr>
    </tbody>
  </table>

  {{-- === ページネーション === --}}
  <div class="pagination">
    <button>&lt;</button>
    <button class="active">1</button>
    <button>2</button>
    <button>3</button>
    <button>4</button>
    <button>&gt;</button>
  </div>

</div>

@endsection
    