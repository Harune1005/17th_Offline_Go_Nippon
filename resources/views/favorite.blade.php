@extends('layouts.app')


@section('content')
 
 @vite(['resources/css/app.css', 'resources/js/app.js']) 

    {{-- search bar --}}
    <div class="container mb-5">
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
    </div>

    {{-- order tabs --}}
    <div class="container mx-auto mb-2">
        <ul class="nav nav-tabs justify-content-start flex-md-nowrap flex-wrap" style="width:100%; height:100%">
            <li class="nav-item text-center border tab-topround custom-tab col-4 col-md-auto px-0"><button class="btn m-0 w-100">Recommend</button></li>
            <li class="nav-item text-center border tab-topround custom-tab col-4 col-md-auto px-0"><button class="btn m-0 w-100">Most liked</button></li>
            <li class="nav-item text-center border tab-topround custom-tab col-4 col-md-auto px-0"><button class="btn m-0 w-100">Newest</button></li>
        </ul>
    </div>

    <div class="container w-100 mx-auto">
        <div class="row mb-5">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card shadow m-2" style="color: #9F6B46">
                    <div class="card-body ratio ratio-1x1">
                        <img src="https://images.pexels.com/photos/1407325/pexels-photo-1407325.jpeg" alt="" class="img-fluid" style="border-top-left-radius: 5px; border-top-right-radius: 5px;">
                    </div>
                    <div class="card-footer bg-white">
                        <div class="row p-1 align-items-center mb-4">
                            <div class="col-7" style="font-size: 24px;">Title</div>
                            <div class="col-3 text-end"><i class="fa-regular fa-heart" style="font-size:18px;"></i><span style="font-size: 13px;">&nbsp;112</span></div>
                            <div class="col-2 text-end"><i class="fa-regular fa-star" style="font-size: 18px;"></i></div>
                        </div>
                        <div class="row px-1 py-2">
                            <div class="col d-flex align-items-end" style="font-size: 13px;">Oct-3-2025</div>
                            <div class="col d-flex justify-content-end align-items-end">
                                <div class="d-inline-block border border-0 rounded-4 text-center py-1 px-3 me-1" style="background-color:#ECF9FF">category1</div>
                                <div class="d-inline-block border border-0 rounded-4 text-center py-1 px-3" style="background-color:#ECF9FF ">category2</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card shadow m-2" style="color: #9F6B46">
                    <div class="card-body ratio ratio-1x1">
                        <img src="https://images.pexels.com/photos/1407325/pexels-photo-1407325.jpeg" alt="" class="img-fluid" style="border-top-left-radius: 5px; border-top-right-radius: 5px;">
                    </div>
                    <div class="card-footer bg-white">
                        <div class="row p-1 align-items-center mb-4">
                            <div class="col-7" style="font-size: 24px;">Title</div>
                            <div class="col-3 text-end"><i class="fa-regular fa-heart" style="font-size: 18px;"></i><span style="font-size: 13px;">&nbsp;112</span></div>
                            <div class="col-2 text-end"><i class="fa-regular fa-star" style="font-size: 18px;"></i></div>
                        </div>
                        <div class="row px-1 py-2">
                            <div class="col d-flex align-items-end" style="font-size: 13px;">Oct-3-2025</div>
                            <div class="col d-flex justify-content-end align-items-end">
                                <div class="d-inline-block border border-0 rounded-4 text-center py-1 px-3 me-1" style="background-color:#ECF9FF">category1
                                </div>
                                <div class="d-inline-block border border-0 rounded-4 text-center py-1 px-3" style="background-color:#ECF9FF ">category2</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card shadow m-2" style="color: #9F6B46">
                    <div class="card-body ratio ratio-1x1">
                        <img src="https://images.pexels.com/photos/1407325/pexels-photo-1407325.jpeg" alt="" class="img-fluid" style="border-top-left-radius: 5px; border-top-right-radius: 5px;">
                    </div>
                    <div class="card-footer bg-white">
                        <div class="row p-1 align-items-center mb-4">
                            <div class="col-7" style="font-size: 24px;">Title</div>
                            <div class="col-3 text-end"><i class="fa-regular fa-heart" style="font-size: 18px;"></i><span style="font-size: 13px;">&nbsp;112</span></div>
                            <div class="col-2 text-end"><i class="fa-regular fa-star" style="font-size: 18px;"></i></div>
                        </div>
                        <div class="row px-1 py-2">
                            <div class="col d-flex align-items-end" style="font-size: 13px;">Oct-3-2025</div>
                            <div class="col d-flex justify-content-end align-items-end">
                                <div class="d-inline-block border border-0 rounded-4 text-center py-1 px-3 me-1" style="background-color:#ECF9FF">category1
                                </div>
                                <div class="d-inline-block border border-0 rounded-4 text-center py-1 px-3" style="background-color:#ECF9FF ">category2</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card shadow m-2" style="color: #9F6B46">
                    <div class="card-body ratio ratio-1x1">
                        <img src="https://images.pexels.com/photos/1407325/pexels-photo-1407325.jpeg" alt="" class="img-fluid" style="border-top-left-radius: 5px; border-top-right-radius: 5px;">
                    </div>
                    <div class="card-footer bg-white">
                        <div class="row p-1 align-items-center mb-4">
                            <div class="col-7" style="font-size: 24px;">Title</div>
                            <div class="col-3 text-end"><i class="fa-regular fa-heart" style="font-size: 18px;"></i><span style="font-size: 13px;">&nbsp;112</span></div>
                            <div class="col-2 text-end"><i class="fa-regular fa-star" style="font-size: 18px;"></i></div>
                        </div>
                        <div class="row px-1 py-2">
                            <div class="col d-flex align-items-end" style="font-size: 13px;">Oct-3-2025</div>
                            <div class="col d-flex justify-content-end align-items-end">
                                <div class="d-inline-block border border-0 rounded-4 text-center py-1 px-3 me-1" style="background-color:#ECF9FF">category1
                                </div>
                                <div class="d-inline-block border border-0 rounded-4 text-center py-1 px-3" style="background-color:#ECF9FF ">category2</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card shadow m-2" style="color: #9F6B46">
                    <div class="card-body ratio ratio-1x1">
                        <img src="https://images.pexels.com/photos/1407325/pexels-photo-1407325.jpeg" alt="" class="img-fluid" style="border-top-left-radius: 5px; border-top-right-radius: 5px;">
                    </div>
                    <div class="card-footer bg-white">
                        <div class="row p-1 align-items-center mb-4">
                            <div class="col-7" style="font-size: 24px;">Title</div>
                            <div class="col-3 text-end"><i class="fa-regular fa-heart" style="font-size: 18px;"></i><span style="font-size: 13px;">&nbsp;112</span></div>
                            <div class="col-2 text-end"><i class="fa-regular fa-star" style="font-size: 18px;"></i></div>
                        </div>
                        <div class="row px-1 py-2">
                            <div class="col d-flex align-items-end" style="font-size: 13px;">Oct-3-2025</div>
                            <div class="col d-flex justify-content-end align-items-end">
                                <div class="d-inline-block border border-0 rounded-4 text-center py-1 px-3 me-1" style="background-color:#ECF9FF">category1
                                </div>
                                <div class="d-inline-block border border-0 rounded-4 text-center py-1 px-3" style="background-color:#ECF9FF ">category2</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card shadow m-2" style="color: #9F6B46">
                    <div class="card-body ratio ratio-1x1">
                        <img src="https://images.pexels.com/photos/1407325/pexels-photo-1407325.jpeg" alt="" class="img-fluid" style="border-top-left-radius: 5px; border-top-right-radius: 5px;">
                    </div>
                    <div class="card-footer bg-white">
                        <div class="row p-1 align-items-center mb-4">
                            <div class="col-7" style="font-size: 24px;">Title</div>
                            <div class="col-3 text-end"><i class="fa-regular fa-heart" style="font-size: 18px;"></i><span style="font-size: 13px;">&nbsp;112</span></div>
                            <div class="col-2 text-end"><i class="fa-regular fa-star" style="font-size: 18px;"></i></div>
                        </div>
                        <div class="row px-1 py-2">
                            <div class="col d-flex align-items-end" style="font-size: 13px;">Oct-3-2025</div>
                            <div class="col d-flex justify-content-end align-items-end">
                                <div class="d-inline-block border border-0 rounded-4 text-center py-1 px-3 me-1" style="background-color:#ECF9FF">category1
                                </div>
                                <div class="d-inline-block border border-0 rounded-4 text-center py-1 px-3" style="background-color:#ECF9FF ">category2</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto w-100 mb-3">
        <ul class="nav nav-tabs justify-content-center text-center border-bottom-0">
            <li class="nav-item border p-2 pagenate-character"><i class="fa-solid fa-angle-left"></i></li>
            <li class="nav-item border p-2 pagenate-number">1</li>
            <li class="nav-item border p-2 pagenate-number">2</li>
            <li class="nav-item border p-2 pagenate-number">3</li>
            <li class="nav-item border p-2 pagenate-number">4</li>
            <li class="nav-item border p-2 pagenate-character"><i class="fa-solid fa-angle-right"></i></li>
        </ul>
    </div>

@endsection


