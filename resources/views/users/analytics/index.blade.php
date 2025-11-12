@extends('layouts.app') 


@section('title', 'User Analytics') 


@section('content')

@vite(['public/css/user-analytics.css'])

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
        
        <div class="chart">
          <canvas id="viewsDonutChart"></canvas>
        </div>

        <div class="legend">
          @php
            $followersRate = $viewsTotal > 0 ? round(($viewsFollowers / $viewsTotal) * 100, 1) : 0;
            $nonFollowersRate = 100 - $followersRate;
          @endphp
          <span class="followers">Followers {{ $followersRate }}%</span>
          <span class="non-followers">Non-followers {{ $nonFollowersRate }}%</span>
        </div>

        <div class="sub-section">
          <h4>By top content</h4>
          <div class="thumbs">
            @foreach($topViewedPosts as $post)
              <div class="content-item">
                <img src="{{ asset('storage/' . $post->image) }}" alt="">
                <span class="views">{{ number_format($post->views_count) }} views</span>
              </div>
            @endforeach
          </div>

          <br>

          <h4>Profile activity</h4>
          <div class="profile-activity">
            <span>Profile visits:</span>
            <span class="numbers">
              {{ number_format($profileVisitsNow) }}
              <span class="increase">
                {{ $profileVisitChange >= 0 ? '+' : '' }}{{ $profileVisitChange }}%
              </span>
            </span>
          </div>
        </div>
      </div>

      <!-- カード② Interactions -->
      <div class="card">
        <h2>Interactions</h2>
        <div class="main-value">{{ number_format($interactionsTotal) }}</div>
        <div class="chart">
          <canvas id="interactionsDonutChart"></canvas>
        </div>
        <div class="legend">
          <span class="followers">Followers {{ $interactionFollowersRate }}%</span>
          <span class="non-followers">Non-followers {{ $interactionNonFollowersRate }}%</span>
        </div>

        <div class="sub-section">
          <h4>By interaction</h4>
          <div class="profile-activity"><span>Likes:</span><span class="numbers">{{ $likes }}</span></div>
          <div class="profile-activity"><span>Comments:</span><span class="numbers">{{ $comments }}</span></div>
          <div class="profile-activity"><span>Saves:</span><span class="numbers">{{ $saves }}</span></div>
          <br>
          <h4>Top posts</h4>
          <div class="thumbs">
            @foreach($topInteractionPosts as $post)
            <div class="content-item">
              @if ($post->images->first())
                <img src="data:image/jpeg;base64,{{ $post->images->first()->image }}" alt="Post image {{ $post->id }}">
              @else
                <img src="/no-image.png" alt="No image">
              @endif

              <span class="views">{{ $post->created_at->format('M j') }}</span>
            </div>
            @endforeach
          </div>
        </div>
      </div>

      <!-- カード③ Followers -->
      <div class="card">
        <h2>Followers</h2>
        <div class="main-value">{{ number_format($followersNow) }}</div>
        <div style="text-align:center; color:#F1BDB2;">
          {{ $followersPercent >= 0 ? '+' : '' }}{{ $followersPercent }}% vs last month
        </div>

        <div class="sub-section">
          <h4>Followers Trend</h4>



          <!-- 折れ線グラフ（カードにちょうどいいサイズ） -->
          <div style="width: 100%; max-width: 800px; margin: 0 auto;">
            <canvas id="followersChangeChart" style="width: 100%; height:300px;"></canvas>
          </div>
          


          <br>

          <h4>Top countries</h4>
          <div class="country-list">
            @foreach($countryStats as $country)
              @php
                $maxCount = $countryStats->first()->count ?? 1;
                $percent = round(($country->count / $maxCount) * 100);
              @endphp
              <div class="country">
                {{ $country->country ?? 'Unknown' }} {{ $percent }} % 
                <div class="bar" style="width:{{ $percent }}%;"></div>
              </div>
            @endforeach
          </div>
        </div>
      </div>

    </div>
  </main>

            <!-- Chart.js 読み込み -->
          <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
          <script>
              // Views donut
              new Chart(document.getElementById('viewsDonutChart'), {
                type: 'doughnut',
                data: {
                  labels: ['Followers', 'Non-followers'],
                  datasets: [{
                    data: [{{ $followersRate }}, {{ $nonFollowersRate }}],
                    backgroundColor: ['#9F6B46', '#F1BDB2'],
                  }]
                },
                options: { cutout: '60%', plugins: { legend: { display: false } } }
              });

              // Interactions donut
              new Chart(document.getElementById('interactionsDonutChart'), {
                type: 'doughnut',
                data: {
                  labels: ['Followers', 'Non-followers'],
                  datasets: [{
                    data: [{{ $interactionFollowersRate }}, {{ $interactionNonFollowersRate }}],
                    backgroundColor: ['#9F6B46', '#F1BDB2'],
                  }]
                },
                options: { cutout: '60%', plugins: { legend: { display: false } } }
              });


            const ctx = document.getElementById('followersChangeChart').getContext('2d');

            new Chart(ctx, {
              type: 'line',
              data: {
                labels: ['Oct 1', 'Oct 5', 'Oct 10', 'Oct 15', 'Oct 20', 'Oct 25', 'Oct 30'],
                datasets: [{
                  label: 'Follower Change',
                  data: [250, 260, 340, 120, 500, 440, 600],
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
                    min: 0,
                    max: 1000,
                    ticks: {
                      stepSize: 250,
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
@endsection