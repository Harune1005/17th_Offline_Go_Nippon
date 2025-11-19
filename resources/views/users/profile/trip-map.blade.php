@extends('layouts.app')

@section('title', 'Trip-map')

@section('content')
<style>
:root {
  --main-brown: #9F6B46;
  --accent-beige: #FFFBEB;
  --highlight: #F1BDB2;
  --background: #E6F4FA;
  --shadow: rgba(0, 0, 0, 0.15);
}

.card, .big-card, .post-card {
  overflow: hidden;   
  border-radius: 16px;
  box-shadow: 0 4px 12px var(--shadow);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.post-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 20px var(--shadow);
}

.trip-map-page main.py-4 {
    display: flex;
  flex-direction: row;
  height: calc(100vh - 70px);
  width: 100vw;
  padding: 0 !important;
  margin: 0 !important;
  background-color: #E6F4FA;
  overflow: hidden;
}


html, body {
height: 100%;
  margin: 0;
  padding: 0;
  background-color: #E6F4FA;
  overflow-x: hidden; 
  overflow-y: auto; 
  
}
p span {
  margin-left: 0.5em;
}

.col{
 font-family: 'Source Serif Pro', serif;
}

div{
  color:#9F6B46;
 }

 span{
   color:#CAAE99;
}

.badge{
   background-color:#ECF9FF;
   color:#9F6B46;
 }

 .post-image{
    width: 100%; 
    height:320px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
 }
.post-col-12{
    padding:0.5rem;
}

.col-md-6{
    padding:0.5rem;
}


.map-container {
    width: 100%;     
  height: 80vh;      
  max-width: 900px; 
  margin: 0 auto;
  position: relative;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #E6F4FA;
}
#map{
  display: block;
  width: 600px;
   height: 660px;
}

#map svg {
  width: 100%;
  height: 100%;
  display: block;
  max-width: none;
}

 
  path {
    stroke: #333;
    stroke-width: 0.5;
    fill: #ccc;
  }
  path:hover {
    fill: #F1BDB2;
  }

  .okinawa-frame {
    fill: none;
    stroke: #aaa;
    stroke-width: 1;
  }

  .okinawa-line {
  stroke: #aaa;
  stroke-width: 1;
}

  .spinner-wrapper {
  position: absolute;
  bottom: 5%;
  left: 60%;
  z-index: 10;
}

.spinner-outer {
  position: relative;
  width: 200px;
  height: 200px;
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
  font-size: 25px;
  margin-bottom: 2px;
}

.spinner-text .count {
  font-family: 'Source Serif Pro', serif;
  color: #9F6B46;
  font-weight: bold;
  font-size: 65px;
  line-height: 1;
}
.spinner-text .small-text {
    font-size: 18px;
    color: #CAAE99;
}
.big-card-body{
    height: 75vh;
    overflow-y:auto;
}
.big-card{
   border:0px;
   background-color: #FFFBEB;
   box-shadow: 0 5px 8px rgba(0, 0, 0, 0.4);   
   opacity: 0;
  transition: opacity 0.4s ease;
  display: none;
}

.big-card.show{
    display:block !important;
    opacity:1;
    animation: slideIn 0.4s ease-out;
  }
  @keyframes slideIn{
    from { opaxity: 0; transform:translateX(20px); }
    to { opacity: 1; transform: translateX(0); }
  }

.post-card{
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

@media (max-width: 600px) {
    .trip-map-page main.py-4 {
    flex-direction: column; 
    height: auto;
    overflow: auto;
  }

  html, body {
    overflow-y: auto;  
  } 

  .spinner-wrapper {
    position: absolute;
    bottom: 5%;
    right: 5%;
    transform: translateX(10%) scale(0.6);
  }
    .col-auto{
        padding: 0;
    }

.big-card-body {
  padding: 1rem;
  height: auto;         
  overflow-y: visible; 
}

.big-card {
  order: 2;
  width: 100%;
  border-radius: 15px 15px 0 0; */
  overflow-y: visible; 
  max-height: none; 
  border: 3px solid #9F6B46;
  background-color: #FFFBEB;
  /* border-radius: 20px; */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  opacity: 0;
  transition: opacity 0.4s ease;
  }

.map-container {
    width: 100%;
    height: 45vh;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  #map svg {
    transform-origin: center;
    transform: none; 
    height: 45vh;
  }

  .map{
    display:block;
    width: 100%;
    height: 80vh;
  }

.spinner-text {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -40%);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0rem;   
  text-align: center;
}

.spinner-text p { 
    margin: 0; 
    padding: 0; 
    line-height: 1; 
} 

.spinner-text .label {
  font-size: 16px;
  line-height: 1;
  margin: 2;
  padding: 0;
}

.post-image{
  height: auto;
  width:100%;
  object-fit: cover;
}
}

</style>


<div class="container-fluid">
    {{-- Map  --}}
  <div class="row">
    <div class="col" style="width: 50vh; height: 50vh;">
        <p class="fw-bold h2 mt-5 text-center  d-flex justify-content-center flex-wrap-nowrap" style="white-space: nowrap;">Click prefecture<span>to view your posts</span></p>
            <div class="map-container">
                 <div id="map" class="map"></div>
                    <div class="spinner-wrapper">
                        <div class="spinner-outer">
                            <div class="spinner-fill"></div>
                            <div class="spinner-text">
                                <p class="label  p-0 m-0">Completed</p>
                                <p class="count p-0 m-0">0<span style="font-size: 27px">/47</span></p>
                                <p class="small-text">Prefectures</p>
                            </div>
                        </div>
                    </div>
            </div>
    </div>

    {{-- Post --}}
    <div class="col mt-1">
        <div class="card mt-5 big-card">
            <div class="card-header" style="border-radius: 16px 16px 0 0; ">
                <h1 class="fw-bold  d-flex justify-content-center " style="color:#9F6B46;">&nbsp;</h1>
            </div>
            <div class="card-body big-card-body" ></div>
        </div>
    </div> 
  </div>
 </div>
@endsection

<script>
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
      const projection = d3.geoMercator()
        .center([137, 38]) 
        .translate([baseWidth / 2, baseHeight / 2]);
      const path = d3.geoPath().projection(projection);
      function adjustProjectionScale() {
      const container = document.querySelector(".map-container");
      const cw = container.clientWidth;
      const ch = container.clientHeight;
      const scaleFactor = Math.min(cw / baseWidth, ch / baseHeight);
      let baseScale = 3000 * scaleFactor;
      if (window.innerWidth < 600) {
        projection
          .center([133.0, 43.0]) 
          .scale(baseScale * 1.0) 
          .translate([cw / 2, ch / 2.3]); 
      } else {
        projection
          .center([138.0, 38.0]) 
          .scale(1800)
          .translate([cw / 2, ch / 2]);
      }
    }

    function renderMap(data) {
      //本州
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
        .on("mouseout", function() { d3.select(this).attr("fill", "#dcdcdc"); })
        .on("click", function(event, d) {
          const prefNameJa = d.properties.nam_ja;
          const engName = prefectureNameMap[prefNameJa];
          const prefData = prefectures.find(p => p.name === engName);
          if (prefData) {
            loadPosts(prefData.id, engName);
          } else {
             console.warn("There is no post yet.:", prefNameJa);
          }
        });
       // 沖縄
        const okinawaProjection = d3.geoMercator()
          .center([127.6, 26.2])
          .scale(4500)
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
          .attr("stroke", "#9F6B46")
          .attr("stroke-width", 0.5)
          .on("mouseover", function() { d3.select(this).attr("fill", "#ffb37f"); })
          .on("mouseout", function() { d3.select(this).attr("fill", "#ffdcb2"); })
          .on("click", function(event, d) {
            const prefNameJa = d.properties.nam_ja;
            const engName = prefectureNameMap[prefNameJa];
            const prefData = prefectures.find(p => p.name === engName);

            if (prefData) {
              loadPosts(prefData.id, engName);
            } else {
              console.warn("There is no post yet.:", prefNameJa);
            }
          });
          prefectures.forEach(pref => {
            if(pref.has_post){
                const prefElement = document.querySelector(`#pref-${pref.code}`);
                if(prefElement){
                    prefElement.style.fill = "#F1BDB2";
                    prefElement.style.transition = "fill 0.3s";
                }
            }
          });
        //沖縄の線
        svg.append("line")
        .attr("x1", 240)
        .attr("y1", 20)
        .attr("x2", 240)
        .attr("y2", 240)
        .attr("stroke", "#9F6B46")
        .attr("stroke-width", 1);

        svg.append("line")
        .attr("x1", 20)
        .attr("y1", 240)
        .attr("x2", 240)
        .attr("y2", 240)
        .attr("stroke", "#9F6B46")
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
    }

    drawMap();

    const userId = {{ $user->id ?? 'null' }};
    fetch(`/prefectures/${userId}/posts`)
      .then(response => response.json())
      .then(prefectures => {
          prefectures.forEach(pref => {
            const area = document.querySelector(`#pref-${pref.code}`); 
              if (area && pref.has_post) {
                area.style.fill = "#F1BDB2";
              }
            });

             updateSpinner(prefectures);
         })
      .catch(error => console.error('Error loading prefectures:', error));
      drawMap();

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
      const prefectureEnglishNames = {
        1: "Hokkaido",
        2: "Aomori",
        3: "Iwate",
        4: "Miyagi",
        5: "Akita",
        6: "Yamagata",
        7: "Fukushima",
        8: "Ibaraki",
        9: "Tochigi",
        10: "Gunma",
        11: "Saitama",
        12: "Chiba",
        13: "Tokyo",
        14: "Kanagawa",
        15: "Niigata",
        16: "Toyama",
        17: "Ishikawa",
        18: "Fukui",
        19: "Yamanashi",
        20: "Nagano",
        21: "Gifu",
        22: "Shizuoka",
        23: "Aichi",
        24: "Mie",
        25: "Shiga",
        26: "Kyoto",
        27: "Osaka",
        28: "Hyogo",
        29: "Nara",
        30: "Wakayama",
        31: "Tottori",
        32: "Shimane",
        33: "Okayama",
        34: "Hiroshima",
        35: "Yamaguchi",
        36: "Tokushima",
        37: "Kagawa",
        38: "Ehime",
        39: "Kochi",
        40: "Fukuoka",
        41: "Saga",
        42: "Nagasaki",
        43: "Kumamoto",
        44: "Oita",
        45: "Miyazaki",
        46: "Kagoshima",
        47: "Okinawa"
      };
    prefHeader.textContent = prefectureEnglishNames[prefId] || prefName;
      if (!posts || posts.length === 0) {
        postContainer.innerHTML = `<p class="text-center text-muted">There is no post.</p>`;
      } else {
        postContainer.innerHTML = `
      <div class="row">
    ${posts.map(post => {
      const images = post.images || [];
      const carouselId = `carouselPost${post.id}`;
      const carouselHTML = images.length > 1
        ? `
          <div id="${carouselId}" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              ${images.map((img, index) => `
                <div class="carousel-item ${index === 0 ? "active" : ""}">
                  <a href="/post/${post.id}/show">
                    <img src="/storage/${img.image}" class="d-block w-100 post-image" alt="">
                  </a>
                </div>
              `).join('')}
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#${carouselId}" data-bs-slide="prev">
              <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#${carouselId}" data-bs-slide="next">
              <span class="carousel-control-next-icon"></span>
            </button>

          </div>
        `
        : `
          <a href="/post/${post.id}/show">
            <img src="${images.length ? "/storage/" + images[0].image : "/images/placeholder.jpg"}"
                class="post-image w-100" alt="">
          </a>
        `;

          return `
            <div class="col-12 col-md-6 mb-3">
              <div class="card border-0 post-card">
                <div class="card-header p-0 border-0">
                  ${carouselHTML}
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
    