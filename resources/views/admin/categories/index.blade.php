@extends('layouts.app') 

@section('title', 'Categories Management') 

@section('content')
@vite(['public/css/admin.css'])

<div class="category-page">

  <!-- === ナビゲーション === -->
  <nav>
    <a href="#">User</a>
    <a href="#">Post</a>
    <a href="#" class="active">Category</a>
  </nav>

  <!-- === 検索バー === -->
  <div class="search-bar">
    <input type="text" placeholder="Add a category...">
    <button class="add-button">+ Add</button>
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
        <tr>
            <td>1</td>
            <td>Mountain</td>
            <td>23</td>
            <td>2025-10-06 13:25</td>
            <td><i class="fa-regular fa-pen-to-square"></i><i class="fa-regular fa-trash-can"></i></td>
        </tr>
        <tr>
            <td>2</td>
            <td>Cafe</td>
            <td>62</td>
            <td>2025-10-06 13:25</td>
            <td><i class="fa-regular fa-pen-to-square"></i><i class="fa-regular fa-trash-can"></i></td>
        </tr>
        <tr>
            <td>3</td>
            <td>Temple</td>
            <td>45</td>
            <td>2025-10-06 13:25</td>
            <td><i class="fa-regular fa-pen-to-square"></i><i class="fa-regular fa-trash-can"></i></td>
        </tr>
        <tr>
            <td>4</td>
            <td>Tour</td>
            <td>5</td>
            <td>2025-10-06 13:25</td>
            <td><i class="fa-regular fa-pen-to-square"></i><i class="fa-regular fa-trash-can"></i></td>
        </tr>
        <tr>
            <td>5</td>
            <td>Sea</td>
            <td>13</td>
            <td>2025-10-06 13:25</td>
            <td><i class="fa-regular fa-pen-to-square"></i><i class="fa-regular fa-trash-can"></i></td>
        </tr>
        <tr>
            <td>6</td>
            <td>Culture</td>
            <td>26</td>
            <td>2025-10-06 13:25</td>
            <td><i class="fa-regular fa-pen-to-square"></i><i class="fa-regular fa-trash-can"></i></td>
        </tr>
        <tr>
            <td>7</td>
            <td>Food</td>
            <td>89</td>
            <td>2025-10-06 13:25</td>
            <td><i class="fa-regular fa-pen-to-square"></i><i class="fa-regular fa-trash-can"></i></td>
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

</div>
@endsection

