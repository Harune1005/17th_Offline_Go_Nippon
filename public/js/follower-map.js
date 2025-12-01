window.followerMap = function({ userId, prefectures }) {
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

    let svg;
    const baseWidth = 675;
    const baseHeight = 670;

    const projection = d3.geoMercator()
        .center([133, 42])
        .translate([baseWidth/2, baseHeight/2]);
    const path = d3.geoPath().projection(projection);

    function adjustProjectionScale() {
        const container = document.querySelector(".map-container");
        const cw = container.clientWidth;
        const ch = container.clientHeight;
        const scaleFactor = Math.min(cw/baseWidth, ch/baseHeight);
        let baseScale = 3000 * scaleFactor;

        if (window.innerWidth < 600) {
            projection.center([133,43]).scale(baseScale*1.0).translate([cw/2, ch/2.3]);
        } else {
            projection.center([133,42]).scale(baseScale).translate([cw/2, ch/2]);
        }
    }

    function renderMap(data) {
        svg.selectAll(".prefecture").data(data.features.filter(d => d.properties.nam_ja !== "沖縄県"))
            .enter().append("path")
            .attr("class","prefecture")
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
            .on("mouseover", function(){ d3.select(this).attr("fill","#ff7f50"); })
            .on("mouseout", function(d){
                const engName = prefectureNameMap[d.properties.nam_ja];
                const prefData = prefectures.find(p => p.name === engName);
                d3.select(this).attr("fill", prefData && prefData.has_post ? "#F1BDB2" : "#dcdcdc");
            })
            .on("click", function(event,d){
                const engName = prefectureNameMap[d.properties.nam_ja];
                const prefData = prefectures.find(p => p.name === engName);
                if(prefData){ loadPosts(prefData.id, engName); }
            });

        // 沖縄も同様に描画
        const okinawaProjection = d3.geoMercator().center([127.6,26.2]).scale(5000).translate([130,130]);
        const okinawaPath = d3.geoPath().projection(okinawaProjection);
        const okinawa = data.features.filter(d=>d.properties.nam_ja==="沖縄県");
        svg.selectAll(".okinawa").data(okinawa)
            .enter().append("path")
            .attr("class","okinawa")
            .attr("d", okinawaPath)
            .attr("id", d => {
                const engName = prefectureNameMap[d.properties.nam_ja];
                const prefData = prefectures.find(p => p.name === engName);
                return prefData ? `pref-${prefData.code}` : null;
            })
            .attr("fill","#ffdcb2")
            .attr("stroke","#666")
            .attr("stroke-width",0.5)
            .on("mouseover", function(){ d3.select(this).attr("fill","#ffb37f"); })
            .on("mouseout", function(d){
                const engName = prefectureNameMap[d.properties.nam_ja];
                const prefData = prefectures.find(p => p.name === engName);
                d3.select(this).attr("fill", prefData && prefData.has_post ? "#F1BDB2" : "#ffdcb2");
            })
            .on("click", function(event,d){
                const engName = prefectureNameMap[d.properties.nam_ja];
                const prefData = prefectures.find(p => p.name === engName);
                if(prefData){ loadPosts(prefData.id, engName); }
            });

        colorPrefectures(prefectures);
    }

    function drawMap() {
        d3.select("#map").selectAll("*").remove();
        svg = d3.select("#map").append("svg")
            .attr("viewBox", `0 0 ${baseWidth} ${baseHeight}`)
            .attr("preserveAspectRatio","xMidYMid meet")
            .style("width","100%")
            .style("height","100%");
        adjustProjectionScale();
        d3.json("/geojson/japan.geojson").then(renderMap);
    }

    function colorPrefectures(prefectures) {
        prefectures.forEach(pref=>{
            const area = document.querySelector(`#pref-${pref.code}`);
            if(area){ area.style.fill = pref.has_post ? "#F1BDB2" : "#dcdcdc"; }
        });
        updateSpinner(prefectures);
    }

    function updateSpinner(prefectures){
        const completed = prefectures.filter(p=>p.has_post).length;
        const total = 47;
        const degree = (360/total)*completed;
        const spinnerOuter = document.querySelector('.spinner-outer');
        spinnerOuter.style.background = `conic-gradient(#F1BDB2 0deg ${degree}deg,#FFF ${degree}deg 360deg)`;
        const countElement = document.querySelector('.spinner-text .count');
        countElement.innerHTML = `${completed}<span style="font-size:27px">/47</span>`;
    }

    drawMap();

    fetch(`/prefectures/${userId}/posts`).then(r=>r.json())
        .then(pref=>colorPrefectures(pref))
        .catch(e=>console.error(e));
};
