@extends('layouts.app')

@section('title', 'Profile ')

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


    .map-container {
  position: relative;
  width: 420px;
  height: 350px;
  background-color: #E6F4FA;
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


.spinner-outer {
  position: relative;
  width: 150px;
  height: 150px;
  border-radius: 50%;
  background: transparent;
}

.spinner-circle {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  background: conic-gradient(#F1BDB2 0deg, #FFFF 0deg); 
  transition: background 0.5s ease;
}

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
  font-size: 20px;
  margin-bottom: 2px;
}

.spinner-text .count {
  font-family: 'Source Serif Pro', serif;
  color: #9F6B46;
  font-weight: bold;
  font-size: 45px;
  line-height: 1;
}
.spinner-text .small-text {
    font-size: 15px;
    color: #CAAE99;
    
}
.spinner-wrapper {
  position: absolute;
  bottom: 10px;
  right: 10px;
  z-index: 10; 
}
.map-container svg {
  width: 100%;
  max-width: 600px;
  height: auto;
}

.selected-pref {
    fill: #ffb08a !important;
    stroke: #cc6644;
    stroke-width: 1.5;
    transition: all 0.3s ease;
}
.has-post {
  fill: #F1BDB2;
  transition: fill 0.3s;
}
.tooltip {
  position: absolute;
  padding: 5px 10px;
  background-color: #333;
  color: #fff;
  border-radius: 5px;
  font-size: 0.9em;
  display: none;
  pointer-events: none; /* ホバーを妨げない */
  white-space: nowrap;
  z-index: 10;
}



@media (max-width: 600px) {
    html, body {
    overflow-x: hidden; 
  }

  .col-md-4{
    padding-right:0;
  }

  .trip-map-a{
    padding-right:0%;
    padding-left: 0.5rem;
  }
  .trip-map-a,
  .profile-row,
  .click-map {
    padding-left: 0 !important;
    padding-right: 10 !important;
    margin-left: auto !important;
    margin-right: auto !important;
    
  }

  /* ボタンのマージン調整 */
  .btn {
    margin-left: 0 !important;
    margin-right: 0 !important;
  }

  /* スピナーの位置調整も微修正（右にはみ出ることがあるため） */
  .spinner-wrapper {
    right: 10%;
    transform: translateX(0) scale(0.8);
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

</style>

    {{-- Profile area --}}
<div class="container">
    <div class="row mt-2 profile-row p-0">
        <x-profile 
          :user="$user"
          :prefectures="$prefectures"
          :allBadges="$allBadges"
          :earnedBadgeIds="$earnedBadgeIds"
        />

        {{-- Post area --}}
        <div class="col-md-8">
            <div class="row mt-3 mb-2">
                <div class="col-12">
                    @if ($posts->isNotEmpty())
                        <div class="row g-3">
                            @foreach ($posts as $post)
                                @if ($post->images->isNotEmpty())
                                    <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                                        <div class="card border-0 p-0 shadow-sm rounded-2 overflow-hidden">
                                            <div class="card-header border-0 p-0">
                                                <a href="{{ route('post.show', $post->id) }}" class="d-block position-relative">
                                                    @if ($post->images->count() > 1)
                                                        <div id="carouselPost{{ $post->id }}" 
                                                            class="carousel slide" 
                                                            data-bs-ride="carousel">
                                                            <div class="carousel-inner">
                                                                @foreach ($post->images as $key => $image)
                                                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                                     <img  src="{{ asset('storage/' . $image->image) }}"
                                                                                   alt="Post image {{ $post->id }}" 
                                                                            class="d-block w-100 post-image"
                                                                            style="width: 100%; height: auto; object-fit: cover;">
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                            <button class="carousel-control-prev" type="button"
                                                                data-bs-target="#carouselPost{{ $post->id }}" data-bs-slide="prev">
                                                                <span class="carousel-control-prev-icon"></span>
                                                            </button>
                                                            <button class="carousel-control-next" type="button"
                                                                data-bs-target="#carouselPost{{ $post->id }}" data-bs-slide="next">
                                                                <span class="carousel-control-next-icon"></span>
                                                            </button>
                                                        </div>
                                                    @else
                                                       <img src="{{ asset('storage/' . $post->images->first()->image) }}" 
                                                            alt="Post image {{ $post->id }}" 
                                                            class="post-image"
                                                            style="width: 100%; height: auto; object-fit: cover;">
                                                    @endif
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="d-flex flex-column justify-content-center align-items-center text-center"
                            style="min-height: 60vh;">
                            <i class="fa-regular fa-image mb-3" style="font-size: 9rem; color:#B0A695;"></i>
                            <h3 class="fw-semibold" style="color:#776B5D;">
                              {{ __('messages.profile.no_post') }}
                            </h3>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="{{ asset('js/profile-map.js') }}"></script>
@stack('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        profileMap({
            userId: {{ $user->id }},
            prefectures: @json($prefectures)
        });
    });
</script>

{{-- <script>
    const prefectures = @json($prefectures ?? []); 
</script>



<script>
const prefectureNameMap = {
  "北海道": "Hokkaido",
  "青森県": "Aomori",
  "岩手県": "Iwate",
  "宮城県": "Miyagi",
  "秋田県": "Akita",
  "山形県": "Yamagata",
  "福島県": "Fukushima",
  "茨城県": "Ibaraki",
  "栃木県": "Tochigi",
  "群馬県": "Gunma",
  "埼玉県": "Saitama",
  "千葉県": "Chiba",
  "東京都": "Tokyo",
  "神奈川県": "Kanagawa",
  "新潟県": "Niigata",
  "富山県": "Toyama",
  "石川県": "Ishikawa",
  "福井県": "Fukui",
  "山梨県": "Yamanashi",
  "長野県": "Nagano",
  "岐阜県": "Gifu",
  "静岡県": "Shizuoka",
  "愛知県": "Aichi",
  "三重県": "Mie",
  "滋賀県": "Shiga",
  "京都府": "Kyoto",
  "大阪府": "Osaka",
  "兵庫県": "Hyogo",
  "奈良県": "Nara",
  "和歌山県": "Wakayama",
  "鳥取県": "Tottori",
  "島根県": "Shimane",
  "岡山県": "Okayama",
  "広島県": "Hiroshima",
  "山口県": "Yamaguchi",
  "徳島県": "Tokushima",
  "香川県": "Kagawa",
  "愛媛県": "Ehime",
  "高知県": "Kochi",
  "福岡県": "Fukuoka",
  "佐賀県": "Saga",
  "長崎県": "Nagasaki",
  "熊本県": "Kumamoto",
  "大分県": "Oita",
  "宮崎県": "Miyazaki",
  "鹿児島県": "Kagoshima",
  "沖縄県": "Okinawa"
};

     const userId = {{ $user->id ?? 'null' }};

    window.onload = function() {
      const baseWidth = 675;
      const baseHeight = 670;
      let svg;
    
      // window.onload の中
const spinnerFill = document.querySelector('.spinner-fill');
const tooltip = document.getElementById('spinner-tooltip');

spinnerFill.addEventListener('mouseenter', (e) => {
    const prefName = e.target.dataset.prefecture;
    tooltip.textContent = prefName;
    tooltip.style.display = 'block';
});

spinnerFill.addEventListener('mousemove', (e) => {
    tooltip.style.left = e.pageX + 10 + 'px';
    tooltip.style.top = e.pageY + 10 + 'px';
});

spinnerFill.addEventListener('mouseleave', () => {
    tooltip.style.display = 'none';
});

      const projection = d3.geoMercator()
        .center([133, 42]) 
        .translate([baseWidth / 2, baseHeight / 2]);
    
      const path = d3.geoPath().projection(projection);
    
      function adjustProjectionScale() {
      const container = document.querySelector(".map-container");
      const cw = container.clientWidth;
      const ch = container.clientHeight;
      const scaleFactor = Math.min(cw / baseWidth, ch / baseHeight);
      let baseScale = 3000 * scaleFactor;

      if (window.innerWidth < 600) {
        // スマホ
        projection
          .center([133.0, 43.0]) 
          .scale(baseScale * 1.0) 
          .translate([cw / 2, ch / 2.3]); 

      } else {
        //  PC
        projection
          .center([133.0, 42.0]) 
          .scale(baseScale)
          .translate([cw / 2, ch / 2]);
      }
    }
    
      function renderMap(data) {

        svg.selectAll(".prefecture")
          .data(data.features.filter(d => d.properties.nam_ja !== "沖縄県"))
          .enter()
          .append("path")
          .attr("class", "prefecture")
          .attr("d", path)
          .attr("id", d => {
            const engName = prefectureNameMap[d.properties.nam_ja];
            const prefData = prefectures.find(p => p.name === engName);
            return prefData ? `pref-${prefData.code}` : null;
          })
          .attr("fill", d => {
            const engName = prefectureNameMap[d.properties.nam_ja];
            const prefData = prefectures.find(p => p.name === engName);
            return prefData && prefData.has_post ? "#F1BDB2" : "#dcdcdc";
          })          
          .attr("stroke", "#333")
          .on("mouseover", function() { d3.select(this).attr("fill", "#ff7f50"); })
         // .on("mouseout", function() { d3.select(this).attr("fill", "#dcdcdc"); })
          .on("click", function(event, d) {
            const [ [x0,y0], [x1,y1 ]] = path.bounds(d);

            svg.transition()
            .duration(750)
            .attr("viewBox", `${x0 - 20} ${y0-20} ${x1 - x0 + 40} ${y1 - y0 + 40}`);

            d3.selectAll(".prefecture, .okinawa").each(function(){
              this.style.fill = '';
            });

             d3.selectAll(".prefecture, .okinawa").classed("selected-pref", false);
             d3.select(this).classed("selected-pref", true);

            const prefName = d.properties.nam_ja;
            const engName = prefectureNameMap[prefName];
            const prefData = prefectures.find(p => p.name === engName);
            if(prefData){
              loadPosts(prefData.id, engName);
            }
          });
    
        // 沖縄のpath描画
        const okinawaProjection = d3.geoMercator()
          .center([127.6, 26.2])
          .scale(5000)
          .translate([130, 130]); 
        const okinawaPath = d3.geoPath().projection(okinawaProjection);
        const okinawa = data.features.filter(d => d.properties.nam_ja === "沖縄県");
        svg.selectAll(".okinawa")
          .data(okinawa)
          .enter()
          .append("path")
          .attr("class", "okinawa")
          .attr("d", okinawaPath)
          .attr("id", d => {
            const engName = prefectureNameMap[d.properties.nam_ja];
            const prefData = prefectures.find(p => p.name === engName);
            return prefData ? `pref-${prefData.code}` : null;
          })
          .attr("fill", "#ffdcb2")
          .attr("stroke", "#666")
          .attr("stroke-width", 0.5)
          .on("mouseover", function() { d3.select(this).attr("fill", "#ffb37f"); })
         // .on("mouseout", function() { d3.select(this).attr("fill", "#ffdcb2"); })
          .on("click", function(event, d) {
            const[[x0, y0], [x1, y1]] = okinawaPath.bounds(d);

            svg.transition()
                .duration(750)
                .attr("viewBox", `${x0 - 20} ${y0 - 20} ${x1 - x0 + 40} ${y1 - y0 + 40}`);

            d3.selectAll(".prefecture, .okinawa").each(function(){
              this.style.fill = '';
            });

            d3.selectAll(".prefecture, .okinawa").classed("selected-pref", false);
            d3.select(this).classed("selected-pref", true);
            
            const prefName = d.properties.nam_ja;
            const prefData = prefectures.find(p => p.name === prefName);
            if(prefData){
                loadPosts(prefData.id, prefName);
            }
          });
          prefectures.forEach(pref => {
            if(pref.has_post){
                const prefElement = document.querySelector(`#pref-${pref.code}`);
                if(prefElement){
                    if(pref.has_post){
                      prefElement.classList.add('has-post');
                    }else{
                      prefElement.classList.remove('has-post');
                    }
                }
            }
          });

        svg.append("line")
        .attr("x1", 240)
        .attr("y1", 20)
        .attr("x2", 240)
        .attr("y2", 240)
        .attr("stroke", "#666")
        .attr("stroke-width", 1);

        svg.append("line")
        .attr("x1", 20)
        .attr("y1", 240)
        .attr("x2", 240)
        .attr("y2", 240)
        .attr("stroke", "#666")
        .attr("stroke-width", 1);
      }
    
      function drawMap() {
        d3.select("#map").selectAll("*").remove();
        svg = d3.select("#map")
          .append("svg")
          .attr("viewBox", `0 0 ${baseWidth} ${baseHeight}`)
          .attr("preserveAspectRatio", "xMidYMid meet")
          .style("width", "100%")
          .style("height", "100%");
    
        adjustProjectionScale();
    
        d3.json("{{ asset('geojson/japan.geojson') }}").then(renderMap);

        svg.on("click", function(event){
          if(event.target === this){ 
            svg.transition().duration(750)
               .attr("viewBox", `0 0 ${baseWidth} ${baseHeight}`);
            d3.selectAll(".prefecture, .okinawa").classed("selected-pref", false);
            d3.selectAll(".prefecture, .okinawa").each(function() { this.style.fill = ''; });
           }
         });
      }

      drawMap();

      fetch(`/prefectures/${userId}/posts`)
        .then(response => response.json())
        .then(prefArr => {
          prefArr.forEach(pref => {
            const area = document.querySelector(`#pref-${pref.code}`);
            if (area && pref.has_post) {
              // inline ではなくクラスを追加
              area.classList.add('has-post');
            }
      });
      updateSpinner(prefArr);
    })
    .catch(error => console.error('Error loading prefectures:', error));

    function updateSpinner(prefectures) {
        
      const completed = prefectures.filter(p => p.has_post).length;
      console.log(prefectures);
      const total = 47;
      const degree = (360 / total) * completed; 

      const spinnerOuter = document.querySelector('.spinner-outer');
      spinnerOuter.style.background = `conic-gradient(#F1BDB2 0deg ${degree}deg, #FFF ${degree}deg 360deg)`;

      const countElement = document.querySelector('.spinner-text .count');
      countElement.innerHTML = `${completed}<span style="font-size: 27px">/47</span>`;
    }

            let resizeTimeout;
            window.addEventListener("resize", () => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(() => {
                drawMap();
                }, 400);
            });

        function loadPosts(prefId, prefName) {
          const bigCard = document.querySelector('.big-card');
            fetch(`/profile/${userId}/pref/${prefId}`)
                .then(response => response.json())
                .then(posts => {
          const postContainer = document.querySelector('.big-card-body');
          const prefHeader = document.querySelector('.big-card h1');
          prefHeader.textContent = prefName;
          const prefectureNameMap = {
  "北海道": "Hokkaido",
  "青森県": "Aomori",
  "岩手県": "Iwate",
  "宮城県": "Miyagi",
  "秋田県": "Akita",
  "山形県": "Yamagata",
  "福島県": "Fukushima",
  "茨城県": "Ibaraki",
  "栃木県": "Tochigi",
  "群馬県": "Gunma",
  "埼玉県": "Saitama",
  "千葉県": "Chiba",
  "東京都": "Tokyo",
  "神奈川県": "Kanagawa",
  "新潟県": "Niigata",
  "富山県": "Toyama",
  "石川県": "Ishikawa",
  "福井県": "Fukui",
  "山梨県": "Yamanashi",
  "長野県": "Nagano",
  "岐阜県": "Gifu",
  "静岡県": "Shizuoka",
  "愛知県": "Aichi",
  "三重県": "Mie",
  "滋賀県": "Shiga",
  "京都府": "Kyoto",
  "大阪府": "Osaka",
  "兵庫県": "Hyogo",
  "奈良県": "Nara",
  "和歌山県": "Wakayama",
  "鳥取県": "Tottori",
  "島根県": "Shimane",
  "岡山県": "Okayama",
  "広島県": "Hiroshima",
  "山口県": "Yamaguchi",
  "徳島県": "Tokushima",
  "香川県": "Kagawa",
  "愛媛県": "Ehime",
  "高知県": "Kochi",
  "福岡県": "Fukuoka",
  "佐賀県": "Saga",
  "長崎県": "Nagasaki",
  "熊本県": "Kumamoto",
  "大分県": "Oita",
  "宮崎県": "Miyazaki",
  "鹿児島県": "Kagoshima",
  "沖縄県": "Okinawa"
};

    prefHeader.textContent = prefectureNames[prefId] || prefName;

          if (!posts || posts.length === 0) {
            postContainer.innerHTML = `<p class="text-center text-muted">There is no post.</p>`;
          } else {
            postContainer.innerHTML = `
      <div class="row">
        ${posts.map(post => {
          const base64 = (post.images && post.images.length) ? post.images[0].image : null;
          const imgSrc = base64 ? `data:image/jpeg;base64,${base64}` : '/images/placeholder.jpg';
          return `
            <div class="col-12 col-md-6 mb-3">
              <div class="card border-0 post-card">
                <div class="card-header p-0 border-0">
                  <a href="/post/${post.id}/show">
                    <img src="${imgSrc}" alt="${post.user ? post.user.name : ''}" class="p-0 post-image">
                  </a>
                </div>
              </div>
            </div>
          `;
        }).join('')}
      </div>
    `;

          }

          bigCard.style.display = 'block';
          bigCard.classList.add('show');
          
        })
        .catch(error => console.error('Error loading posts:', error));
    }


   };
</script>
     --}}