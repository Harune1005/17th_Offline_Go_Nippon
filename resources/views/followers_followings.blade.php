@extends('layouts.app')

@section('content')
<style>
    .col-md-4{
        font-family: 'Source Serif Pro', serif;
    }
    div{
        color:#9F6B46;
    }
    span{
        color:#CAAE99;
    }

    .card{
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);   
    }

    .post-image{
        width: 100%;
        aspect-ratio:1 / 1;
        oblect-fit:cover;
    }


 @media (max-width: 600px) {
    html, body {
    overflow-x: hidden; /* 横スクロール禁止 */
  }

  .col-md-4{
    padding-right:0;
  }

  .trip-map-a{
    padding-right:0%;
    padding-left: 0.5rem;
  }
  .container, .row, .col-md-4, .col-md-8 {
    max-width: 100%;
    overflow-x: hidden;
  }

  /* 横余白でズレやすい要素をリセット */
  .profile-row, .click-map {
    margin-left: 0 !important;
    margin-right: 0 !important;
    padding-left: 0.5rem;
    padding-right: 0.5rem;
  }

  /* ボタンのマージン調整 */
  .btn {
    margin-left: 0 !important;
    margin-right: 0 !important;
  }

  /* スピナーの位置調整も微修正（右にはみ出ることがあるため） */
  .spinner-wrapper {
    right: 10%;
    transform: translateX(0) scale(0.9);
  }
.col-auto{
    padding: 0;
}
  .phone {
    font-size: 12px;
    padding: 0;
  }

  .name{
    padding-left: 2rem;
  }
  .number{
    padding-left: 2rem;
  }
 .profile-row{
   padding-left: 0.5rem;
 }
 .spinner-wrapper {
    bottom: 5px;
    right: 30px;
    transform: translateX(10%) scale(0.9);
  }
 
 .btn{
    margin-left:0.5rem;
    margin-right:0.5rem;
 }
 .click-map{
    margin-left: 1rem;
    padding-right: 0;
    padding-left: 1rem;
 }

 }
    .map-container {
  position: relative;
  width: 100%;
  height: 350px;
  background-color: #E6F4FA;
  border-radius: 20px;
  overflow: hidden;
}

 
  path {
    stroke: #333;
    stroke-width: 0.5;
    fill: #ccc;
  }
  path:hover {
    fill: #F1BDB2;
  }




/* 外円 */
.spinner-outer {
  position: relative;
  width: 130px;
  height: 130px;
}

.spinner-outer::before {
  content: '';
  position: absolute;
  inset: 0;
  border: 15px solid #FFFF;
  border-radius: 50%;
}


.spinner-outer::after {
  content: '';
  position: absolute;
  inset: 0;
  border: 15px solid transparent;
  border-top-color: #F1BDB2;
  border-radius: 50%;
  animation: spin 1.5s linear infinite;
}


/* 中央のテキスト */
.spinner-text {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
}

.spinner-text p {
  margin: 0;
}

.spinner-text .label {
  font-family: 'Source Serif Pro', serif;
  color: #9F6B46;
  font-weight: 600;
  font-size: 15px;
}

.spinner-text .count {
  font-family: 'Source Serif Pro', serif;
  color: #9F6B46;
  font-weight: bold;
  font-size: 32px;
}
.spinner-wrapper {
  position: absolute;
  bottom: 10px;
  right: 10px;
  z-index: 10; /* 地図の上に出す */
}

</style>

<div class="container">
    <div class="row mt-3 justify-content-center">
        <div class="col d-none d-md-block mx-2">
            {{-- profile --}}
            <div class="row ps-2 profile-row">
                <div class="col-auto">
                    <i class="fa-solid fa-circle-user text-secondary" style="font-size: 80px; border: 5px solid #9F6B46; border-radius: 50%; 
                        padding:0;" ></i>
                </div>
                <div class="col-auto">
                    
                    <div class="row name">
                        <h3 >John</h3>
                    </div>
                    <div class="row">
                        <div class="row text-center mt-3 mb-2 number">
                            <div class="col-4">
                                <div class="fs-5 fw-bold" >10</div>
                                <div class="small" >Posts</div>
                            </div>
                            <div class="col-4">
                                <div class="fs-5 fw-bold" >10</div>
                                <div class="small">Followers</div>
                            </div>
                            <div class="col-4">
                                <div class="fs-5 fw-bold" >10</div>
                                <div class="small" >Followings</div>
                            </div>
                        </div>
                                    
                    </div>
                </div>
            </div>

            <div class="row profile-row">
                <h5><span> country:</span>USA</h5>
            </div>
            <div class="row profile-row" >
                <p>Hi. I'm John. <br> I love travering, meeting new people, and exploring different cultures. I'm always currious to learn new things and share experiences...</p>
            </div>
            <div class="row mb-2 profile-row">
                <div class="col-auto px-2 ">
                    <button type="submit" class="btn p-auto" style=" background-color: #F1BDB2; color:#FFFF; width:150px;">Edit Pofile</button>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn p-auto" style=" border-color: #F1BDB2; color:#F1BDB2; width:150px;">Favorites</button>
                </div>
            </div>
            
            {{-- map --}}
            <div class="row">
                <p class="fw-bold h5 click-map">Click map <span>to view full map</span></p>

                <div class="map-container">
                    <a href="profile/trip-map" class="trip-map-a"> 
                        <div id="map" style="width: 100%; height: 350px;"></div>
                   </a>
                    <div class="spinner-wrapper">
                        <div class="spinner-outer">
                            <div class="spinner-text">
                                <p class="label">Completed</p>
                                <p class="count">5 <span style="font-size: 20px">/47</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="mx-auto" style="max-width: 500px;">
                <div class="d-flex mb-3">
                    <input type="text" name="" placeholder="Search User ...." class="d-flex form-control me-2" style="width: 75%;">
                    <button class="btn custom-btn ms-auto"><i class="fa-solid fa-magnifying-glass"></i>Search</button>
                </div>

                {{-- tabs --}}
                <div class="mx-auto w-100 mb-2">
                    <ul class="nav nav-tabs border-bottom-0 justify-contenr-center" id="followTabs" role="tablist" style="height: 50px;">
                        <li class="nav-item text-center flex-fill follow-tab" role="presentation">
                            <button class="nav-link active h-100 w-100" id="followings-tab" data-bs-toggle="tab" data-bs-target="#followings" type="button" role="tab" aria-controls="followings" aria-selected="true">Followings</button>
                        </li>
                        <li class="nav-item text-center flex-fill follow-tab" role="presentation">
                            <button class="nav-link h-100 w-100" id="followers-tab" data-bs-toggle="tab" data-bs-target="#followers" type="button" role="tab" aria-controls="followers" aria-selected="false">Followers</button>
                        </li>
                    </ul>
                </div>

                {{-- content of tabs --}}
                <div class="tab-content shadow p-3" id="followTabsContent">
                    {{-- followings --}}
                    <div class="tab-pane fade show active" id="followings" role="tabpanel" aria-labelledby="followings-tab">
                        <div class="d-flex justify-content-center align-items-center text-center mt-2 w-50 mx-auto rounded" style="color:#ffffff ; background-color: #9F6B46; height:50px;">
                            <h2 class="mb-0" style="font-size:20px;">120 Followings</h2>
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
                    {{-- followers --}}
                    <div class="tab-pane fade" id="followers" role="tabpanel" aria-labelledby="followers-tab">
                        <div class="d-flex justify-content-center align-items-center text-center mt-2 w-50 mx-auto rounded" style="color:#ffffff ; background-color: #9F6B46; height:50px;">
                            <h2 class="mb-0" style="font-size:20px;">350 Followers</h2>
                        </div>
                        <div class="d-flex align-items-center rounded-3 p-3" style="height: 100px;">
                            <img src="https://images.pexels.com/photos/31618288/pexels-photo-31618288.jpeg" alt="user" class="rounded-circle me-4 align-items-ceter" style="width:75px; height:75px;">
                            <div class="d-flex flex-column align-items-start">
                                <h6 class="mb-0 fw-bold">USER 1</h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center ms-auto">
                                <button class="btn m-0 following-btn">Following</button>
                            </div>
                        </div>
                        <div class="d-flex align-items-center rounded-3 p-3" style="height: 100px;">
                            <img src="https://images.pexels.com/photos/31618288/pexels-photo-31618288.jpeg"" alt="user" class="rounded-circle me-4 align-items-ceter" style="width:75px; height:75px;">
                            <div class="d-flex flex-column align-items-start">
                                <h6 class="mb-0 fw-bold">USER 2</h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center ms-auto">
                                <button class="btn m-0 follow-btn">Follow</button>
                            </div>
                        </div>
                        <div class="d-flex align-items-center rounded-3 p-3" style="height: 100px;">
                            <img src="https://images.pexels.com/photos/31618288/pexels-photo-31618288.jpeg"" alt="user" class="rounded-circle me-4 align-items-ceter" style="width:75px; height:75px;">
                            <div class="d-flex flex-column align-items-start">
                                <h6 class="mb-0 fw-bold">USER 3</h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center ms-auto">
                                <button class="btn m-0 following-btn">Following</button>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="col d-none d-md-block">
            <div class="shadow p-3 m-3">
                <div class="d-flex justify-content-center align-items-center text-center mt-2 w-100 mx-auto mb-4" >
                    <h2 class="mb-0" style="font-size:20px;"><i class="fa-solid fa-user"></i> Recommend Users</h2>
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

@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const container = document.getElementById("map");
        const width = container.clientWidth; // ← 画面幅に合わせる！
        const height = 350;
    
      const svg = d3.select("#map")
        .append("svg")
        .attr("width", width)
        .attr("height", height);
    
      // 投影法（地球を2Dに写すための設定）
      const projection = d3.geoMercator()
        .center([136.0, 38.0]) // 日本の中心あたり
        .scale(980)
        .translate([width / 2, height / 2]);
    
      const path = d3.geoPath().projection(projection);
    
      // GeoJSONを読み込んで描画
      d3.json("https://raw.githubusercontent.com/dataofjapan/land/master/japan.geojson").then(function(data) {
        svg.selectAll("path")
          .data(data.features)
          .enter()
          .append("path")
          .attr("d", path)
          .attr("fill", "#dcdcdc")
          .attr("stroke", "#333")
          .on("mouseover", function(event, d) {
            d3.select(this).attr("fill", "#ff7f50");
          })
          .on("mouseout", function(event, d) {
            d3.select(this).attr("fill", "#dcdcdc");
          })
          .on("click", function(event, d) {
            alert(d.properties.nam_ja + " がクリックされました");
          });
      });
    });
    </script>