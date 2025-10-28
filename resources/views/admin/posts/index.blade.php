@extends('layouts.app') 

@section('title', 'Post Management') 

@section('content')
@vite(['public/css/admin.css'])


<div class="post-page">

  <!-- ナビゲーション部分 -->
  <nav>
    <a href="#">User</a>
    <a href="#" class="active">Post</a>
    <a href="#">Category</a>
  </nav>

  <!-- メインコンテンツ -->
  <main>
    <!-- フィルター部分 -->
    <div class="filters">
      <div class="filter-group">
        <label for="category">Category</label>
        <select id="category">
          <option value="">select</option>
        </select>
      </div>
      <div class="filter-group">
        <label for="prefecture">Prefecture</label>
        <select id="prefecture">
          <option value="">select</option>
        </select>
      </div>
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
        <tr>
          <td>1</td>
          <td><img src="https://images.unsplash.com/photo-1554797589-7241bb691973?w=200" class="post-img" alt="Tokyo Tower"></td>
          <td><span class="tag">Tower</span></td>
          <td>Tokyo</td>
          <td>Mark</td>
          <td><div class="status"><div class="status-dot"></div>Visible</div></td>
          <td class="text-end">
            <div class="dropdown">
            <button class="btn-dropdown" type="button">
                <i class="fa-solid fa-ellipsis"></i>
            </button>
            <ul class="dropdown-menu">
                <li>
                  <button class="dropdown-item text-danger" data-bs-toggle="modal" ><i class="fa-solid fa-ban text-danger"></i>Hide</button>
                </li>
            </ul>
            </div>
        </td>
        </tr>
        <tr>
          <td>2</td>
          <td><img src="https://images.unsplash.com/photo-1554797589-7241bb691973?w=200" class="post-img" alt="Kyoto Temple"></td>
          <td><span class="tag">Temple</span></td>
          <td>Kyoto</td>
          <td>Jacob</td>
          <td><div class="status"><div class="status-dot"></div>Visible</div></td>
          <td class="text-end">
            <div class="dropdown">
            <button class="btn-dropdown" type="button">
                <i class="fa-solid fa-ellipsis"></i>
            </button>
            <ul class="dropdown-menu">
                <li>
                  <button class="dropdown-item text-danger" data-bs-toggle="modal" ><i class="fa-solid fa-ban text-danger"></i>Hide</button>
                </li>
            </ul>
            </div>
          </td>
        </tr>
        <tr>
          <td>3</td>
          <td><img src="https://images.unsplash.com/photo-1549692520-acc6669e2f0c?w=200" class="post-img" alt="Mt. Fuji"></td>
          <td><span class="tag">Mountain</span></td>
          <td>Yamanashi</td>
          <td>Larry</td>
          <td><div class="status"><div class="status-dot"></div>Visible</div></td>
          <td class="text-end">
            <div class="dropdown">
            <button class="btn-dropdown" type="button">
                <i class="fa-solid fa-ellipsis"></i>
            </button>
            <ul class="dropdown-menu">
                <li>
                  <button class="dropdown-item text-danger" data-bs-toggle="modal" ><i class="fa-solid fa-ban text-danger"></i>Hide</button>
                </li>
            </ul>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- === ページネーション === -->
    <div class="pagination">
        <button>&lt;</button>
        <button class="active">1</button>
        <button>2</button>
        <button>3</button>
        <button>4</button>
        <button>&gt;</button>
    </div>
  </main>

</div>

@endsection