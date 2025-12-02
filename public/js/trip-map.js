window.tripMap = function({ userId, prefectures }) {
    const prefectureNameMap = {
        "北海道": "Hokkaido", "青森県": "Aomori", "岩手県": "Iwate",
        "宮城県": "Miyagi", "秋田県": "Akita", "山形県": "Yamagata",
        "福島県": "Fukushima", "茨城県": "Ibaraki", "栃木県": "Tochigi",
        "群馬県": "Gunma", "埼玉県": "Saitama", "千葉県": "Chiba",
        "東京都": "Tokyo", "神奈川県": "Kanagawa", "新潟県": "Niigata",
        "富山県": "Toyama", "石川県": "Ishikawa", "福井県": "Fukui",
        "山梨県": "Yamanashi", "長野県": "Nagano", "岐阜県": "Gifu",
        "静岡県": "Shizuoka", "愛知県": "Aichi", "三重県": "Mie",
        "滋賀県": "Shiga", "京都府": "Kyoto", "大阪府": "Osaka",
        "兵庫県": "Hyogo", "奈良県": "Nara", "和歌山県": "Wakayama",
        "鳥取県": "Tottori", "島根県": "Shimane", "岡山県": "Okayama",
        "広島県": "Hiroshima", "山口県": "Yamaguchi", "徳島県": "Tokushima",
        "香川県": "Kagawa", "愛媛県": "Ehime", "高知県": "Kochi",
        "福岡県": "Fukuoka", "佐賀県": "Saga", "長崎県": "Nagasaki",
        "熊本県": "Kumamoto", "大分県": "Oita", "宮崎県": "Miyazaki",
        "鹿児島県": "Kagoshima", "沖縄県": "Okinawa"
    };

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
        // 本州
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
            .on("mouseout", function(d) {
                const engName = prefectureNameMap[d.properties.nam_ja];
                const prefData = prefectures.find(p => p.name === engName);
                d3.select(this).attr("fill", prefData && prefData.has_post ? "#F1BDB2" : "#dcdcdc");
            })
            .on("click", function(event, d) {
                const engName = prefectureNameMap[d.properties.nam_ja];
                const prefData = prefectures.find(p => p.name === engName);
                if (prefData) loadPosts(prefData.id, engName);
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
            .on("mouseout", function(d) {
                const engName = prefectureNameMap[d.properties.nam_ja];
                const prefData = prefectures.find(p => p.name === engName);
                d3.select(this).attr("fill", prefData && prefData.has_post ? "#F1BDB2" : "#ffdcb2");
            })
            .on("click", function(event, d) {
                const engName = prefectureNameMap[d.properties.nam_ja];
                const prefData = prefectures.find(p => p.name === engName);
                if (prefData) loadPosts(prefData.id, engName);
            });

        prefectures.forEach(pref => {
            const prefElement = document.querySelector(`#pref-${pref.code}`);
            if (prefElement && pref.has_post) {
                prefElement.style.fill = "#F1BDB2";
                prefElement.style.transition = "fill 0.3s";
            }
        });
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
        d3.json("/geojson/japan.geojson").then(renderMap);

        svg.append("line")
        .attr("x1", 220)
        .attr("y1", 20)
        .attr("x2", 220)
        .attr("y2", 180)
        .attr("stroke", "#666")
        .attr("stroke-width", 1);

        svg.append("line")
        .attr("x1", 40)
        .attr("y1", 180)
        .attr("x2", 220)
        .attr("y2", 180)
        .attr("stroke", "#666")
        .attr("stroke-width", 1);


    }

    function updateSpinner(prefectures) {
        const completed = prefectures.filter(p => p.has_post).length;
        const degree = (360 / 47) * completed;
        const spinnerOuter = document.querySelector('.spinner-outer');
        spinnerOuter.style.background = `conic-gradient(#F1BDB2 0deg ${degree}deg, #FFF ${degree}deg 360deg)`;
        const countElement = document.querySelector('.spinner-text .count');
        countElement.innerHTML = `${completed}<span style="font-size: 27px">/47</span>`;
    }

   function loadPosts(prefId, prefName) {
        const bigCard = document.querySelector('.big-card');
        fetch(`/profile/${userId}/pref/${prefId}`)
            .then(response => response.json())
            .then(posts => {
                const postContainer = document.querySelector('.big-card-body');
                const prefHeader = document.querySelector('.big-card h1');
                prefHeader.textContent = prefName;

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
                                            class="post-image" alt="">
                                    </a>
                                    `;

                                return `
                                    <div class="col-12 col-md-6 mb-3 post-col-12">
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


    drawMap();
    fetch(`/prefectures/${userId}/posts`)
        .then(res => res.json())
        .then(prefectures => updateSpinner(prefectures));

    window.addEventListener("resize", () => {
        setTimeout(drawMap, 400);
    });
};
