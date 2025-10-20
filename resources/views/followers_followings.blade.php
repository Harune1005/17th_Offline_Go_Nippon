<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Followers$Followings</title>
    <!-- bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- fontawesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js']) 
</head>
<body>
    <div class="container">
        <div class="row mt-3 justify-content-center">
            <div class="col d-none d-md-block"></div>

            <div class="col-12 col-md-4">
                <div class="mx-auto" style="max-width: 500px;">
                    <div class="d-flex mb-3">
                        <input type="text" name="" placeholder="Search User ...." class="d-flex form-control me-2" style="width: 75%;">
                        <button class="btn custom-btn ms-auto"><i class="fa-solid fa-magnifying-glass"></i>Search</button>
                    </div>

                    <div class="mx-auto w-100 mb-2">
                        <ul class="nav nav-tabs border-bottom-0 justify-contenr-center" style="height: 50px;">
                            <li class="nav-item text-center rounded flex-fill follow-tab">
                                <button class="btn m-0 h-100 w-100">Followings</button>
                            </li>
                            <li class="nav-item text-center rounded flex-fill follow-tab">
                                <button class="btn m-0 h-100 w-100">Followers</button>
                            </li>
                        </ul>
                    </div>

                    <div class="shadow p-3">
                        <div class="d-flex justify-content-center align-items-center text-center mt-2 w-50 mx-auto rounded" style="color:#ffffff ; background-color: #9F6B46; height:50px;">
                            <h2 class="mb-0" style="font-size:24px;">120 Followings</h2>
                        </div>
                        <div class="d-flex align-items-center rounded-3 p-3" style="height: 100px;">
                            <img src="https://images.pexels.com/photos/415829/pexels-photo-415829.jpeg" alt="user" class="rounded-circle me-4 align-items-ceter" style="width:75px; height:75px;">
                            <div class="d-flex flex-column align-items-start">
                                <h6 class="mb-0 fw-bold">USER 1</h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center ms-auto">
                                <button class="btn m-0 following-btn">Following</button>
                            </div>
                        </div>
                        <div class="d-flex align-items-center rounded-3 p-3" style="height: 100px;">
                            <img src="https://images.pexels.com/photos/415829/pexels-photo-415829.jpeg" alt="user" class="rounded-circle me-4 align-items-ceter" style="width:75px; height:75px;">
                            <div class="d-flex flex-column align-items-start">
                                <h6 class="mb-0 fw-bold">USER 2</h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center ms-auto">
                                <button class="btn m-0 following-btn">Following</button>
                            </div>
                        </div>
                        <div class="d-flex align-items-center rounded-3 p-3" style="height: 100px;">
                            <img src="https://images.pexels.com/photos/415829/pexels-photo-415829.jpeg" alt="user" class="rounded-circle me-4 align-items-ceter" style="width:75px; height:75px;">
                            <div class="d-flex flex-column align-items-start">
                                <h6 class="mb-0 fw-bold">USER 3</h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center ms-auto">
                                <button class="btn m-0 following-btn">Following</button>
                            </div>
                        </div>
                        <div class="d-flex align-items-center rounded-3 p-3" style="height: 100px;">
                            <img src="https://images.pexels.com/photos/415829/pexels-photo-415829.jpeg" alt="user" class="rounded-circle me-4 align-items-ceter" style="width:75px; height:75px;">
                            <div class="d-flex flex-column align-items-start">
                                <h6 class="mb-0 fw-bold">USER 4</h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center ms-auto">
                                <button class="btn m-0 following-btn">Following</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col d-none d-md-block">
                <div class="shadow p-3 m-5">
                    <div class="d-flex justify-content-center align-items-center text-center mt-2 w-100 mx-auto mb-4" >
                        <h2 class="mb-0" style="font-size:24px;"><i class="fa-solid fa-user"></i> Recommend Users</h2>
                    </div>
                    <div class="d-flex align-items-center rounded-3 p-3" style="height: 100px;">
                        <img src="https://images.pexels.com/photos/34046748/pexels-photo-34046748.jpeg" alt="user" class="rounded-circle me-4 align-items-ceter" style="width:75px; height:75px;">
                        <div class="d-flex flex-column align-items-start">
                            <h6 class="mb-0 fw-bold">USER</h6>
                        </div>
                        <div class="d-flex align-items-center justify-content-center ms-auto">
                            <button class="btn m-0 follow-btn">Follow</button>
                        </div>
                    </div>
                    <div class="d-flex align-items-center rounded-3 p-3" style="height: 100px;">
                        <img src="https://images.pexels.com/photos/34046748/pexels-photo-34046748.jpeg" alt="user" class="rounded-circle me-4 align-items-ceter" style="width:75px; height:75px;">
                        <div class="d-flex flex-column align-items-start">
                            <h6 class="mb-0 fw-bold">USER</h6>
                        </div>
                        <div class="d-flex align-items-center justify-content-center ms-auto">
                            <button class="btn m-0 follow-btn">Follow</button>
                        </div>
                    </div>
                    <div class="d-flex align-items-center rounded-3 p-3" style="height: 100px;">
                        <img src="https://images.pexels.com/photos/34046748/pexels-photo-34046748.jpeg" alt="user" class="rounded-circle me-4 align-items-ceter" style="width:75px; height:75px;">
                        <div class="d-flex flex-column align-items-start">
                            <h6 class="mb-0 fw-bold">USER</h6>
                        </div>
                        <div class="d-flex align-items-center justify-content-center ms-auto">
                            <button class="btn m-0 follow-btn">Follow</button>
                        </div>
                    </div>
                    <div class="d-flex align-items-center rounded-3 p-3" style="height: 100px;">
                        <img src="https://images.pexels.com/photos/34046748/pexels-photo-34046748.jpeg" alt="user" class="rounded-circle me-4 align-items-ceter" style="width:75px; height:75px;">
                        <div class="d-flex flex-column align-items-start">
                            <h6 class="mb-0 fw-bold">USER</h6>
                        </div>
                        <div class="d-flex align-items-center justify-content-center ms-auto">
                            <button class="btn m-0 follow-btn">Follow</button>
                        </div>
                    </div>
                    <div class="d-flex align-items-center rounded-3 p-3" style="height: 100px;">
                        <img src="https://images.pexels.com/photos/34046748/pexels-photo-34046748.jpeg" alt="user" class="rounded-circle me-4 align-items-ceter" style="width:75px; height:75px;">
                        <div class="d-flex flex-column align-items-start">
                            <h6 class="mb-0 fw-bold">USER</h6>
                        </div>
                        <div class="d-flex align-items-center justify-content-center ms-auto">
                            <button class="btn m-0 follow-btn">Follow</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>