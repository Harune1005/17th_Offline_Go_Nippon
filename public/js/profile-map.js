window.profileMap = function({ userId, prefectures }) {
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

    // tooltip & spinner
    const tooltip = document.getElementById('spinner-tooltip');
    const spinnerFills = document.querySelectorAll('.spinner-fill');
    spinnerFills.forEach(fill => {
        fill.addEventListener('mouseenter', e => {
            tooltip.textContent = e.target.dataset.prefecture;
            tooltip.style.display = 'block';
        });
        fill.addEventListener('mousemove', e => {
            tooltip.style.left = e.pageX + 10 + 'px';
            tooltip.style.top = e.pageY + 10 + 'px';
        });
        fill.addEventListener('mouseleave', () => {
            tooltip.style.display = 'none';
        });
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
            projection.center([133.0, 43.0])
                      .scale(baseScale)
                      .translate([cw / 2, ch / 2.3]);
        } else {
            projection.center([133.0, 42.0])
                      .scale(baseScale)
                      .translate([cw / 2, ch / 2]);
        }
    }

    function renderMap(data) {
        // 本州以外
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
            .on("click", function(event, d) {
                const [[x0, y0], [x1, y1]] = path.bounds(d);
                svg.transition().duration(750)
                    .attr("viewBox", `${x0 - 20} ${y0 - 20} ${x1 - x0 + 40} ${y1 - y0 + 40}`);
                d3.selectAll(".prefecture, .okinawa").classed("selected-pref", false);
                d3.select(this).classed("selected-pref", true);

                const prefName = d.properties.nam_ja;
                const engName = prefectureNameMap[prefName];
                const prefData = prefectures.find(p => p.name === engName);
                if(prefData) loadPosts(prefData.id, engName);
            });

        // 沖縄
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
            .on("click", function(event, d) {
                const [[x0, y0], [x1, y1]] = okinawaPath.bounds(d);
                svg.transition().duration(750)
                    .attr("viewBox", `${x0 - 20} ${y0 - 20} ${x1 - x0 + 40} ${y1 - y0 + 40}`);
                d3.selectAll(".prefecture, .okinawa").classed("selected-pref", false);
                d3.select(this).classed("selected-pref", true);

                const prefName = d.properties.nam_ja;
                const engName = prefectureNameMap[prefName];
                const prefData = prefectures.find(p => p.name === engName);
                if(prefData) loadPosts(prefData.id, engName);

                
            });

        // 投稿済みフラグ
        prefectures.forEach(pref => {
            const el = document.querySelector(`#pref-${pref.code}`);
            if(el && pref.has_post) el.classList.add('has-post');    
        });
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

    function drawMap() {
        d3.select("#map").selectAll("*").remove();
        svg = d3.select("#map").append("svg")
                .attr("viewBox", `0 0 ${baseWidth} ${baseHeight}`)
                .attr("preserveAspectRatio", "xMidYMid meet")
                .style("width", "100%")
                .style("height", "100%");

        adjustProjectionScale();
        d3.json("/geojson/japan.geojson").then(renderMap);

        svg.on("click", function(event){
            if(event.target === this){
                svg.transition().duration(750)
                    .attr("viewBox", `0 0 ${baseWidth} ${baseHeight}`);
                d3.selectAll(".prefecture, .okinawa").classed("selected-pref", false);
            }
        });
    }

    drawMap();

    fetch(`/prefectures/${userId}/posts`)
        .then(res => res.json())
        .then(prefArr => {
            prefArr.forEach(pref => {
                const area = document.querySelector(`#pref-${pref.code}`);
                if(area && pref.has_post) area.classList.add('has-post');
            });
            updateSpinner(prefArr);
        });

    function updateSpinner(prefectures) {
        const completed = prefectures.filter(p => p.has_post).length;
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
        resizeTimeout = setTimeout(drawMap, 400);
    });

    function loadPosts(prefId, prefName) {
        const bigCard = document.querySelector('.big-card');
        const postContainer = document.querySelector('.big-card-body');
        const prefHeader = document.querySelector('.big-card h1');
        prefHeader.textContent = prefName;

        fetch(`/profile/${userId}/pref/${prefId}`)
            .then(res => res.json())
            .then(posts => {
                if(!posts || posts.length === 0){
                    postContainer.innerHTML = `<p class="text-center text-muted">There is no post.</p>`;
                } else {
                    postContainer.innerHTML = `
                        <div class="row">
                            ${posts.map(post => {
                                const imgSrc = (post.images && post.images.length)
                                    ? `data:image/jpeg;base64,${post.images[0].image}`
                                    : '/images/placeholder.jpg';
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
            });
    }
};
