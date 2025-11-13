@extends('layouts.app') 

@section('title', 'User Analytics') 

@section('content')
<div class="container">
  <div class="mb-4 d-flex justify-content-between">
    <div class="my-2">
        <a href="{{ route('home') }}" class="text-decoration-none"><< back</a>
    </div>

    <select class="form-select w-auto">
      <option>Last 30 days</option>
    </select>
  </div>

  <div class="row g-4">
    <!-- card 1 -->
    <div class="col-md-4">
      <div class="card h-100">
        <div class="card-body">
          <h3 class="card-title text-center">~ Views ~</h3>
          <h4 class="fs-3 text-center">
            {{ number_format($viewsTotal) }}
          </h4>

          <div class="mb-1" style="height:180px;">
            <canvas id="viewsDonutChart" class="w-100 h-100"></canvas>
          </div>

          <div class="d-flex justify-content-center mb-5">
            @php
              $followersRate = $viewsTotal > 0 ? round(($viewsFollowers / $viewsTotal) * 100, 1) : 0;
              $nonFollowersRate = 100 - $followersRate;
            @endphp
            <span class="ms-4 text-followers">
              Followers {{ $followersRate }}%
            </span>
            <span class="ms-4 text-nonfollowers">
              Non-followers {{ $nonFollowersRate }}%
            </span>
          </div>

          <h6 class="text-decoration-underline">Top posts</h6>
          <div class="d-flex flex-wrap gap-2 mb-5">
            @foreach($topViewedPosts as $post)
              <div class="mx-auto text-center">
                <a href="{{ route('post.show', $post->id) }}">
                  @if ($post->images->first())
                    <img src="{{ asset ('storage/' .  $post->images->first()->image )}}" class="img-thumbnail" style="width:110px; height:110px;">
                  @else
                    <img src="/no-image.png" class="img-thumbnail" style="width:110px; height:110px;">
                  @endif
                </a>
                <div class="small">{{ number_format($post->views_count) }} views</div>
              </div>
            @endforeach
          </div>

          <h6 class="text-decoration-underline">Profile activity</h6>
          <div class="d-flex justify-content-between">
            <span class="text-dark">Profile visits:</span>
            <span>
              {{ number_format($profileVisitsNow) }}
              <span class="{{ $profileVisitChange >= 0 ? 'text-success' : 'text-danger' }}">
                {{ $profileVisitChange >= 0 ? '+' : '' }}{{ $profileVisitChange }}%
              </span>
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- card 2 -->
    <div class="col-md-4">
      <div class="card h-100">
        <div class="card-body">
          <h3 class="card-title text-center">~ Interactions ~</h3>
          <h4 class="fs-3 text-center">{{ number_format($interactionsTotal) }}</h4>

          <div class="mb-1" style="height:180px;">
            <canvas id="interactionsDonutChart" class="w-100 h-100"></canvas>
          </div>

          <div class="d-flex justify-content-center mb-5">
            <span class="ms-4 text-followers">
              Followers {{ $interactionFollowersRate }}%
            </span>
            <span class="ms-4 text-nonfollowers">
              Non-followers {{ $interactionNonFollowersRate }}%
            </span>
          </div>

          <h6 class="text-decoration-underline">Top posts</h6>
          <div class="d-flex flex-wrap gap-2 mb-5">
            @foreach($topInteractionPosts as $post)
            <div class="mx-auto text-center">
              <a href="{{ route('post.show', $post->id) }}">
                @if ($post->images->first())
                  <img src="{{ asset ('storage/' .  $post->images->first()->image )}}" class="img-thumbnail" style="width:110px; height:110px;">
                @else
                  <img src="/no-image.png" class="img-thumbnail" style="width:110px; height:110px;">
                @endif
              </a>
              <div class="small">{{ $post->created_at->format('M j') }}</div>
            </div>
            @endforeach
          </div>

          <h6 class="text-decoration-underline">By interaction</h6>
          <ul class="list-unstyled">
            <li class="d-flex justify-content-between mb-1">Likes:
              <span>{{ $likes }}</span>
            </li>
            <li class="d-flex justify-content-between mb-1">Comments:
              <span>{{ $comments }}</span>
            </li>
            <li class="d-flex justify-content-between mb-1">Saves:
              <span>{{ $saves }}</span>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- card 3 -->
    <div class="col-md-4">
      <div class="card h-100">
        <div class="card-body">
          <h3 class="card-titl text-center">~ Followers ~</h3>
          <h4 class="fs-3 text-center">{{ number_format($followersNow) }}</h4>
          <div class="text-center text-danger mb-3">
            {{ $followersPercent >= 0 ? '+' : '' }}{{ $followersPercent }}% vs last month
          </div>

          <h6 class="text-decoration-underline">Followers Trend</h6>
          <div class="mb-5" style="height:250px;">
            <canvas id="followersChangeChart" class="w-100 h-100"></canvas>
          </div>

          <h6 class="text-decoration-underline">Top countries</h6>
          <div class="country-list">
            @foreach($countryStats as $country)
              @php
                $maxCount = $countryStats->first()->count ?? 1;
                $count = $country->count;
                $percent = round(($country->count / $maxCount) * 100);
              @endphp
              <div class="list-group-item p-1">
                <div class="d-flex justify-content-between country-name">
                  <span>{{ $country->country ?? 'Unknown' }} ({{ $count }})</span>
                  <span>{{ $percent }}%</span>
                </div>
                <div class="progress" style="height: 5px;">
                  <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $percent }}%;"></div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Views Donut
  new Chart(document.getElementById('viewsDonutChart'), {
    type: 'doughnut',
    data: {
      labels: ['Followers', 'Non-followers'],
      datasets: [{ data: [{{ $followersRate }}, {{ $nonFollowersRate }}], backgroundColor: ['#9F6B46', '#F1BDB2'] }]
    },
    options: { cutout: '60%', plugins: { legend: { display: false } }, responsive: true, maintainAspectRatio: false }
  });

  // Interactions Donut
  new Chart(document.getElementById('interactionsDonutChart'), {
    type: 'doughnut',
    data: {
      labels: ['Followers', 'Non-followers'],
      datasets: [{ data: [{{ $interactionFollowersRate }}, {{ $interactionNonFollowersRate }}], backgroundColor: ['#9F6B46', '#F1BDB2'] }]
    },
    options: { cutout: '60%', plugins: { legend: { display: false } }, responsive: true, maintainAspectRatio: false }
  });

  // Followers Line Chart
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
      scales: { y: { min: 0, max: 1000, ticks: { stepSize: 250 } } },
      plugins: { legend: { display: false } }
    }
  });
</script>

@endsection