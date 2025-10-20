@extends('layouts.app')

@section('title', 'Show Post')

@section('content')
<style>
    .uniform-img {
        height: 600px; 
        object-fit: cover;
        width: 100%;
    }

    .text-brown {
        color: #9F6B46 !important;
    }

    .bg-info-light {
        background-color: #ECF9FF !important;
    }

    .btn-brown {
        background-color: #9F6B46;
        color: #fff;
        border: none;
    }

    .btn-brown:hover {
        background-color: #7e5638;
    }

    .btn-pink {
        background-color: #F1BDB2;
        color: white;
        border: 2px solid #F1BDB2;
        transition: 0.3s;
    }

    .btn-pink:hover {
        background-color: #e6a99c;
        border-color: #e6a99c;
    }

    .btn-outline-pink {
        background-color: transparent;
        color: #F1BDB2;
        border: 2px solid #F1BDB2;
        transition: 0.3s;
    }

    .btn-outline-pink:hover {
        background-color: #F1BDB2;
        color: white;
    }
    
    .form-control:focus {
        border-color: #9F6B46;
        box-shadow: 0 0 0 0.2rem rgba(159, 107, 70, 0.25);
    }

    .bg-yellow-light {
        background-color: #FFFBEB!important;
    }

    body {
        font-family: 'Source Serif Pro', serif;
    }

    .comment-section-wrapper {
        display: flex;
        flex-direction: column;
        height: 100%; 
    }

    .comment-list {
        flex: 1;
        overflow-y: auto;
        padding-right: 6px;
        min-height: 150px;
    }

</style>

    <div class="container mt-5">
        <div class="justify-content-center">
            <a href="#" class="text-decoration-none text-brown mb-2 d-inline-block">
                <i class="fa-solid fa-angles-left"></i> back
            </a>

            <div class="card border shadow-sm rounded-2 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom border-brown">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto d-flex align-items-center">
                            <a href="">
                                {{-- @if () --}}
                                    <img src="https://placehold.co/40x40" alt="user" class="rounded-circle me-3">
                                {{-- @else --}}
                                    {{-- <i class="fa-solid fa-circle-user text-secondary me-3"></i> --}}
                                {{-- @endif --}}
                            </a>
                            
                            <a href=""
                            class="text-decoration-none fw-bold text-brown">USER NAME</a>
                        </div>

                        <div class="col-auto d-flex align-items-center">
                            {{-- @if () --}}
                                <div class="dropdown">
                                    <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                                        <i class="fa-solid fa-ellipsis text-brown"></i>
                                    </button>
                                    
                                    <div class="dropdown-menu dropdown-menu-end shadow-sm">
                                        <a href="#" class="dropdown-item text-brown">
                                            <i class="fa-regular fa-pen-to-square me-2"></i>Edit
                                        </a>
                                        <button class="dropdown-item text-danger" data-bs-toggle="modal"
                                                data-bs-target="#delete-post-{{}}">
                                                <i class="fa-regular fa-trash-can me-2"></i> Delete
                                        </button>
                                    </div>
                                    {{-- include modal --}}

                                </div>
                            {{-- @else --}}
                                {{-- @if () --}}
                                    {{-- <form action="" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-outline-pink btn-md fw-bold">Following</button>
                                    </form> --}}
                                {{-- @else --}}
                                    {{-- <form action="" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-pink btn-md fw-bold">Follow</button>
                                    </form> --}}
                                {{-- @endif --}}
                            {{-- @endif --}}
                        </div>
                    </div>
                </div>

                <div class="card-body bg-white p-0">
                    <div class="row g-0">
                        <div class="col-md-7">
                            {{-- @if () --}}
                                <div id="postCarousel" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="https://static.retrip.jp/article/112968/images/112968a9d27826-a3ad-4652-8b27-e6fcd1c19087_m.jpg" 
                                                class="d-block uniform-img" alt="image 1">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="https://cdn.camp-fire.jp/jbimages/8616928d-a240-4573-b2ec-6f23614558f9.jpg" 
                                                class="d-block uniform-img" alt="image 2">
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#postCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#postCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </button>
                                </div>
                            {{-- @else --}}
                                {{-- Single Image --}}
                                {{-- <img src="" 
                                    alt="Post image {{  }}" 
                                    class="uniform-img"> --}} 
                            {{-- @endif --}}           
                        </div>

                        <div class="col-md-5 border-start border-brown">
                            <div class="p-4 bg-white h-100 comment-section-wrapper" style="max-height: 600px;">
                                <h4 class="fw-bold text-brown mb-2 text-center">Arakurayamasengen Park</h4>

                                <div class="row align-items-center mb-3">
                                    <div class="col-auto">
                                        <p class="mb-2 text-brown">
                                            <i class="fa-solid fa-location-dot text-danger me-1"></i> Yamanashi
                                        </p> 
                                    </div>

                                    <div class="col d-flex justify-content-end align-items-center gap-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fa-regular fa-heart text-brown me-1"></i>
                                            <span class="text-brown fw-bold">250</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fa-regular fa-star text-brown me-1"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center justify-content-end text-brown small mb-3 gap-3">
                                    <span><i class="fa-regular fa-calendar me-1 text-info"></i>Apr 10, 2025</span>
                                    <span><i class="fa-solid fa-coins me-1 text-warning"></i>1000 YEN</span>
                                    <span><i class="fa-regular fa-clock me-1 text-secondary"></i>50 minute</span>
                                </div>

                                <p class="text-brown mb-3">
                                    Approximately 650 cherry trees are planted in the park, and in the spring a cherry blossom festival is held, attracting many visitors.
                                </p>

                                <div class="mb-3 text-end">
                                    <span class="badge bg-info-light text-brown fw-normal">Category</span>
                                    <span class="badge bg-info-light text-brown fw-normal">Category</span>
                                    <span class="badge bg-info-light text-brown fw-normal">Category</span>
                                </div>

                                <div class="input-group mb-4">
                                    <input type="text" class="form-control border-brown rounded-start" placeholder="Add a comment...">
                                    <button class="btn btn-brown rounded-end">
                                        <i class="fa-solid fa-paper-plane"></i>
                                    </button>
                                </div>

                                <div class="comment-list">
                                    <div class="p-2 mb-2 bg-yellow-light rounded-3">
                                        <a href="" class="text-decoration-none"><strong class="text-brown">Pochi</strong></a>
                                        <span class="text-brown small d-block">It's so beautiful! I'd love to go there someday.</span>
                                        <div class="text-end small text-secondary">Aug 20, 2025 <i class="fa-solid fa-comments ms-2 text-brown"></i><i class="fa-regular fa-trash-can ms-2 text-danger"></i></div>
                                    </div>
                                    <div class="p-2 mb-2 bg-yellow-light rounded-3">
                                        <strong class="text-brown">Hana</strong>
                                        <span class="text-brown small d-block">It's so beautiful! I'd love to go there someday.</span>
                                        <div class="text-end small text-secondary">Aug 20, 2025 <i class="fa-solid fa-comments ms-2 text-brown"></i><i class="fa-regular fa-trash-can ms-2 text-danger"></i></div>
                                    </div>
                                    <div class="p-2 mb-2 bg-yellow-light rounded-3">
                                        <strong class="text-brown">Hana</strong>
                                        <span class="text-brown small d-block">It's so beautiful! I'd love to go there someday.</span>
                                        <div class="text-end small text-secondary">Aug 20, 2025 <i class="fa-solid fa-comments ms-2 text-brown"></i><i class="fa-regular fa-trash-can ms-2 text-danger"></i></div>
                                    </div>
                                    <div class="p-2 mb-2 bg-yellow-light rounded-3">
                                        <strong class="text-brown">Hana</strong>
                                        <span class="text-brown small d-block">It's so beautiful! I'd love to go there someday.</span>
                                        <div class="text-end small text-secondary">Aug 20, 2025 <i class="fa-solid fa-comments ms-2 text-brown"></i><i class="fa-regular fa-trash-can ms-2 text-danger"></i></div>
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
