<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Go Nippon! - Analytics</title>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/user-analytics.css') }}">
  
</head>

<body>
  <header></header>

  <main>
    <div class="filter">
      <select>
        <option>Last 30 days</option>
      </select>
    </div>

    <!-- ここから3カード（縦並びver） -->
    <div class="card-container">

      <!-- カード① Views -->
      <div class="card">
        <h2>Views</h2>
        <div class="main-value">{{ number_format($viewsTotal) }}</div>
        <div class="chart"><div class="donut"></div></div>
        <div class="legend">
          <span class="followers">Followers 86%</span>
          <span class="non-followers">Non-followers 14%</span>
        </div>

        <div class="sub-section">
          <h4>By top content</h4>
            <div class="thumbs">
              <div class="content-item">
                <img src="https://images.unsplash.com/photo-1554797589-7241bb691973?w=200">
                <span class="views">1.2K views</span>
              </div>
              <div class="content-item">
                <img src="https://images.unsplash.com/photo-1554797589-7241bb691973?w=200">
                <span class="views">980 views</span>
              </div>
              <div class="content-item">
                <img src="https://images.unsplash.com/photo-1554797589-7241bb691973?w=200">
                <span class="views">865 views</span>
              </div>
          </div>
          <br>
          <h4>Profile activity</h4>
          <div class="profile-activity">
            <span>Profile visits:</span>
            <span class="numbers">1,182 <span class="increase">+58.2%</span></span>
          </div>
        </div>
      </div>

      <!-- カード② Interactions -->
      <div class="card">
        <h2>Interactions</h2>
        <div class="main-value">190</div>
        <div class="chart"><div class="donut"></div></div>
        <div class="legend">
          <span class="followers">Followers 95%</span>
          <span class="non-followers">Non-followers 5%</span>
        </div>

        <div class="sub-section">
          <h4>By interaction</h4>
          <div class="profile-activity"><span>Likes:</span><span class="numbers">108</span></div>
          <div class="profile-activity"><span>Comments:</span><span class="numbers">3</span></div>
          <div class="profile-activity"><span>Saves:</span><span class="numbers">15</span></div>
          <br>
          <h4>Top posts</h4>
          <div class="thumbs">
            <div class="content-item">
              <img src="https://images.unsplash.com/photo-1554797589-7241bb691973?w=200">
              <span class="views">Oct 5</span>
            </div>
            <div class="content-item">
              <img src="https://images.unsplash.com/photo-1554797589-7241bb691973?w=200">
              <span class="views">Sep 23</span>
            </div>
            <div class="content-item">
              <img src="https://images.unsplash.com/photo-1554797589-7241bb691973?w=200">
              <span class="views">Sep 15</span>
            </div>
          </div>
        </div>
      </div>

      <!-- カード③ Followers -->
      <div class="card">
        <h2>Followers</h2>
        <div class="main-value">860</div>
        <div style="text-align:center; color:#F1BDB2;">+58.2% vs Sep 7</div>

        <div class="sub-section">
          <h4>Follower details</h4>

          <!-- Chart.js 読み込み -->
          <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

          <!-- 折れ線グラフ（カードにちょうどいいサイズ） -->
          <div style="width: 100%; max-width: 800px; margin: 0 auto;">
            <canvas id="followersChangeChart" style="width: 100%; height:300px;"></canvas>
          </div>

          <script>
            const ctx = document.getElementById('followersChangeChart').getContext('2d');

            new Chart(ctx, {
              type: 'line',
              data: {
                labels: ['Oct 1', 'Oct 5', 'Oct 10', 'Oct 15', 'Oct 20', 'Oct 25', 'Oct 30'],
                datasets: [{
                  label: 'Follower Change',
                  data: [2, -1, 3, 0, -2, 1, -1],
                  borderColor: '#9F6B46',
                  backgroundColor: 'rgba(241,189,178,0.25)',
                  tension: 0.35,
                  fill: true,
                  pointRadius: 4,
                  pointBackgroundColor: '#9F6B46'
                }]
              },
              options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                  y: {
                    min: -3,
                    max: 3,
                    ticks: {
                      stepSize: 1,
                      color: '#9F6B46',
                      font: { size: 11 }
                    },
                    grid: {
                      color: 'rgba(159,107,70,0.1)'
                    }
                  },
                  x: {
                    grid: {
                      color: 'rgba(159,107,70,0.05)'
                    },
                    ticks: {
                      color: '#9F6B46',
                      font: { size: 11 }
                    }
                  }
                },
                plugins: {
                  legend: { display: false },
                  tooltip: {
                    backgroundColor: '#9F6B46',
                    titleColor: '#FFFBEB',
                    bodyColor: '#FFFBEB',
                    callbacks: {
                      label: function(context) {
                        const value = context.parsed.y;
                        return value > 0 ? `+${value} followers` : `${value} followers`;
                      }
                    }
                  }
                }
              }
            });
          </script>

          <br>

          <h4>Top countries</h4>
          <div class="country-list">
            <div class="country">Taiwan 13.3%<div class="bar" style="width:80%;"></div></div>
            <div class="country">South Korea 4.8%<div class="bar" style="width:40%;"></div></div>
            <div class="country">China 3.7%<div class="bar" style="width:30%;"></div></div>
            <div class="country">Vietnam 3.1%<div class="bar" style="width:25%;"></div></div>
            <div class="country">USA 1.2%<div class="bar" style="width:10%;"></div></div>
          </div>
        </div>
      </div>

    </div>
  </main>
</body>
</html>