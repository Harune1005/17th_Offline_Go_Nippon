@extends('layouts.app')

@section('content')
<div class="container">

    <form action="#" method="get">
        <div class="row align-items-end">
            <div class="col-12 col-md-4 mb-3 mb-md-0">
                <input type="text" name="search" class="form-control" placeholder="Search...">
            </div>

            <div class="col-12 col-md-8">
                <div class="row g-2  align-items-end">
                    <div class="col-6 col-md-5 mb-3 mb-md-0">
                        <label for="" class="form-label">Prefecture</label>
                        <select name="prefecture" class="form-select text-muted">
                            <option value="" selected disabled hidden>Select</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-5 mb-3 mb-md-0">
                        <label for="" class="form-label">Category</label>
                        <select name="category" class="form-select text-muted">
                            <option value="" selected disabled hidden>Select</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-2 d-grid">
                        <button type="submit" class="btn btn-outline w-100">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="article mt-5">
        <div class="row">
            {{-- sidebar --}}
            <div class="col-12 col-md-4 mb-5">
                <div class="card shadow-sm border-0">
                    <div id="carouselRanking" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            {{-- category carousel --}}
                            <div class="carousel-item active">
                                <div class="card-header border-0" style="background: rgba(159, 107, 70, 0.3);">
                                    <h5 class="mb-0 fw-bold text-center">🏆 Category Ranking</h5>
                                </div>
                                <ul class="list-group list-group-flush mx-5">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>
                                            <i class="fa-brands fa-web-awesome"></i> 1. 
                                            <br>
                                            &nbsp;
                                            >>>
                                            <a href="" class="text-decoration-none">Travel</a>
                                        </span>
                                        <div class="badge rounded-pill">
                                            <span class="" style="background: rgb(236, 239, 255);">123</span>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>
                                            <i class="fa-brands fa-web-awesome"></i> 2. 
                                            <br>
                                            &nbsp;
                                            >>>
                                            <a href="" class="text-decoration-none">Food</a>
                                        </span>
                                        <div class="badge rounded-pill">
                                            <span class="" style="background: rgb(236, 239, 255);">98</span>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>
                                            <i class="fa-brands fa-web-awesome"></i> 3. 
                                            <br>
                                            &nbsp;
                                            >>>
                                            <a href="" class="text-decoration-none">Culture</a>
                                        </span>
                                        <div class="badge rounded-pill">
                                            <span class="" style="background: rgb(236, 239, 255);">78</span>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>
                                            <i class="fa-brands fa-web-awesome"></i> 4. 
                                            <br>
                                            &nbsp;
                                            >>>
                                            <a href="" class="text-decoration-none">Nature</a>
                                        </span>
                                        <div class="badge rounded-pill">
                                            <span class="" style="background: rgb(236, 239, 255);">45</span>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>
                                            <i class="fa-brands fa-web-awesome"></i> 5. 
                                            <br>
                                            &nbsp;
                                            >>>
                                            <a href="" class="text-decoration-none">Shopping</a>
                                        </span>
                                        <div class="badge rounded-pill">
                                            <span class="" style="background: rgb(236, 239, 255);">23</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            {{-- prefecture carousel --}}
                            <div class="carousel-item">
                                <div class="card-header border-0">
                                    <h5 class="mb-0 fw-bold text-center">🏆 Prefecture Ranking</h5>
                                </div>
                                <ul class="list-group list-group-flush mx-5">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>
                                            <i class="fa-brands fa-web-awesome"></i> 1. 
                                            <br>
                                            &nbsp;
                                            >>>
                                            <a href="" class="text-decoration-none">Tokyo</a>
                                        </span>
                                        <div class="badge rounded-pill">
                                            <span class="" style="background: rgb(236, 239, 255);">123</span>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>
                                            <i class="fa-brands fa-web-awesome"></i> 2. 
                                            <br>
                                            &nbsp;
                                            >>>
                                            <a href="" class="text-decoration-none">Kyoto</a>
                                        </span>
                                        <div class="badge rounded-pill">
                                            <span class="" style="background: rgb(236, 239, 255);">66</span>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>
                                            <i class="fa-brands fa-web-awesome"></i> 3. 
                                            <br>
                                            &nbsp;
                                            >>>
                                            <a href="" class="text-decoration-none">Okinawa</a>
                                        </span>
                                        <div class="badge rounded-pill">
                                            <span class="" style="background: rgb(236, 239, 255);">54</span>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>
                                            <i class="fa-brands fa-web-awesome"></i> 4. 
                                            <br>
                                            &nbsp;
                                            >>>
                                            <a href="" class="text-decoration-none">Fukuoka</a>
                                        </span>
                                        <div class="badge rounded-pill">
                                            <span class="" style="background: rgb(236, 239, 255);">45</span>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>
                                            <i class="fa-brands fa-web-awesome"></i> 5. 
                                            <br>
                                            &nbsp;
                                            >>>
                                            <a href="" class="text-decoration-none">Kanagawa</a>
                                        </span>
                                        <div class="badge rounded-pill">
                                            <span class="" style="background: rgb(236, 239, 255);">12</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselRanking" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselRanking" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-8">
                <div class="container">
                    {{-- sort --}}
                    <div class="sort mb-4">
                        <ul class="nav nav-tabs">
                            <li class="nav-item text-center border topround custom-tab">
                                <button class="btn m-0">Recommend</button>
                            </li>
                            <li class="nav-item text-center border topround custom-tab">
                                <button class="btn m-0">Most liked</button>
                            </li>
                            <li class="nav-item text-center border topround custom-tab">
                                <button class="btn m-0">Newest</button>
                            </li>
                        </ul>
                    </div>

                    <div class="row g-4">
                        {{-- post --}}
                        <div class="col-12 col-md-6 d-flex justify-content-center mb-3">
                            <div class="card border-0 shadow-lg w-100">
                                <div class="card-body p-0">
                                        {{-- @if () --}}
                                            <div id="carouselExample-1" class="carousel slide" data-bs-ride="carousel">
                                                <div class="carousel-inner">
                                                    {{-- @foreach () --}}
                                                        <div class="carousel-item active">
                                                            <a href="#">
                                                                <img src="https://images.pexels.com/photos/33229965/pexels-photo-33229965.jpeg" class="d-block w-100 uniform-img" style="height: 350px; object-fit: cover;" alt="">
                                                            </a>
                                                        </div>

                                                        <div class="carousel-item">
                                                            <a href="#">
                                                                <img src="https://images.pexels.com/photos/34123164/pexels-photo-34123164.jpeg" class="d-block w-100 uniform-img" style="height: 350px; object-fit: cover;" alt="">
                                                            </a>
                                                        </div>
                                                    {{-- @endforeach --}}
                                                </div>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample-1" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon"></span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample-1" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon"></span>
                                                </button>
                                            </div>
                                        {{-- @elseif()
                                            <a href="#">
                                                <img src="" class="w-100 uniform-img" alt="">
                                            </a>
                                        @endif --}}
                                </div>
                                <div class="card-footer bg-white border-0">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="fs-5 mb-0">Title</span>
                                        <div>
                                            <a href="#" class="text-decoration-none"><span>♡ 123</span></a>
                                            &nbsp;
                                            <a href="#" class="text-decoration-none"><span>☆</span></a>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="small mb-0">Oct-3-2025</span>
                                        <div class="badge bg-opacity-50" style="background: rgb(236, 239, 255);"><span>Category</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 d-flex justify-content-center mb-3">
                            <div class="card border-0 shadow-lg w-100">
                                <div class="card-body p-0">
                                        {{-- @if () --}}
                                            <div id="carouselExample-1" class="carousel slide" data-bs-ride="carousel">
                                                <div class="carousel-inner">
                                                    {{-- @foreach () --}}
                                                        <div class="carousel-item active">
                                                            <a href="#">
                                                                <img src="https://images.pexels.com/photos/33229965/pexels-photo-33229965.jpeg" class="d-block w-100 uniform-img" style="height: 350px; object-fit: cover;" alt="">
                                                            </a>
                                                        </div>

                                                        <div class="carousel-item">
                                                            <a href="#">
                                                                <img src="https://images.pexels.com/photos/34123164/pexels-photo-34123164.jpeg" class="d-block w-100 uniform-img" style="height: 350px; object-fit: cover;" alt="">
                                                            </a>
                                                        </div>
                                                    {{-- @endforeach --}}
                                                </div>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample-1" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon"></span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample-1" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon"></span>
                                                </button>
                                            </div>
                                        {{-- @elseif()
                                            <a href="#">
                                                <img src="" class="w-100 uniform-img" alt="">
                                            </a>
                                        @endif --}}
                                </div>
                                <div class="card-footer bg-white border-0">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="fs-5 mb-0">Title</span>
                                        <div>
                                            <a href="#" class="text-decoration-none"><span>♡ 123</span></a>
                                            &nbsp;
                                            <a href="#" class="text-decoration-none"><span>☆</span></a>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="small mb-0">Oct-3-2025</span>
                                        <div class="badge bg-opacity-50" style="background: rgb(236, 239, 255);"><span>Category</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 d-flex justify-content-center mb-3">
                            <div class="card border-0 shadow-lg w-100">
                                <div class="card-body p-0">
                                        {{-- @if () --}}
                                            <div id="carouselExample-1" class="carousel slide" data-bs-ride="carousel">
                                                <div class="carousel-inner">
                                                    {{-- @foreach () --}}
                                                        <div class="carousel-item active">
                                                            <a href="#">
                                                                <img src="https://images.pexels.com/photos/33229965/pexels-photo-33229965.jpeg" class="d-block w-100 uniform-img" style="height: 350px; object-fit: cover;" alt="">
                                                            </a>
                                                        </div>

                                                        <div class="carousel-item">
                                                            <a href="#">
                                                                <img src="https://images.pexels.com/photos/34123164/pexels-photo-34123164.jpeg" class="d-block w-100 uniform-img" style="height: 350px; object-fit: cover;" alt="">
                                                            </a>
                                                        </div>
                                                    {{-- @endforeach --}}
                                                </div>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample-1" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon"></span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample-1" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon"></span>
                                                </button>
                                            </div>
                                        {{-- @elseif()
                                            <a href="#">
                                                <img src="" class="w-100 uniform-img" alt="">
                                            </a>
                                        @endif --}}
                                </div>
                                <div class="card-footer bg-white border-0">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="fs-5 mb-0">Title</span>
                                        <div>
                                            <a href="#" class="text-decoration-none"><span>♡ 123</span></a>
                                            &nbsp;
                                            <a href="#" class="text-decoration-none"><span>☆</span></a>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="small mb-0">Oct-3-2025</span>
                                        <div class="badge bg-opacity-50" style="background: rgb(236, 239, 255);"><span>Category</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 d-flex justify-content-center mb-3">
                            <div class="card border-0 shadow-lg w-100">
                                <div class="card-body p-0">
                                        {{-- @if () --}}
                                            <div id="carouselExample-1" class="carousel slide" data-bs-ride="carousel">
                                                <div class="carousel-inner">
                                                    {{-- @foreach () --}}
                                                        <div class="carousel-item active">
                                                            <a href="#">
                                                                <img src="https://images.pexels.com/photos/33229965/pexels-photo-33229965.jpeg" class="d-block w-100 uniform-img" style="height: 350px; object-fit: cover;" alt="">
                                                            </a>
                                                        </div>

                                                        <div class="carousel-item">
                                                            <a href="#">
                                                                <img src="https://images.pexels.com/photos/34123164/pexels-photo-34123164.jpeg" class="d-block w-100 uniform-img" style="height: 350px; object-fit: cover;" alt="">
                                                            </a>
                                                        </div>
                                                    {{-- @endforeach --}}
                                                </div>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample-1" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon"></span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample-1" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon"></span>
                                                </button>
                                            </div>
                                        {{-- @elseif()
                                            <a href="#">
                                                <img src="" class="w-100 uniform-img" alt="">
                                            </a>
                                        @endif --}}
                                </div>
                                <div class="card-footer bg-white border-0">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="fs-5 mb-0">Title</span>
                                        <div>
                                            <a href="#" class="text-decoration-none"><span>♡ 123</span></a>
                                            &nbsp;
                                            <a href="#" class="text-decoration-none"><span>☆</span></a>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="small mb-0">Oct-3-2025</span>
                                        <div class="badge bg-opacity-50" style="background: rgb(236, 239, 255);"><span>Category</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
