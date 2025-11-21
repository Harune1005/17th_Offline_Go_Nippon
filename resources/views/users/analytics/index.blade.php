@extends('layouts.app') 

@section('title', 'User Analytics') 

@section('content')
<div class="container my-5">
  <div class="row g-4">
    <!-- card 1 -->
    <div class="col-md-4">
      <div class="card shadow h-100">
        <div class="card-body">
          <h2 class="card-title fw-bold text-center">~ Views ~</h2>
          <h4 class="fs-3 text-center" style="color: #9F6B46;">
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

          <h5 class="text-decoration-underline fw-bold">Top posts</h5>
          <div class="d-flex flex-wrap gap-2 mb-5">
            @foreach($topViewedPosts as $post)
              <div class="mx-auto text-center">
                <a href="{{ route('post.show', $post->id) }}">
                  @if ($post->images->first())
                    <img src="{{ asset ('storage/' .  $post->images->first()->image )}}" class="img-thumbnail" style="width:110px; height:110px; object-fit: cover;">
                  @else
                    <img src="/no-image.png" class="img-thumbnail" style="width:110px; height:110px; object-fit: cover;">
                  @endif
                </a>
                <div class="small">{{ number_format($post->views_count) }} views</div>
              </div>
            @endforeach
          </div>

          <h5 class="text-decoration-underline fw-bold">Profile activity</h5>
          <div class="d-flex justify-content-between">
            <span class="visit">Profile visits:</span>
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
      <div class="card shadow h-100">
        <div class="card-body">
          <h2 class="card-title fw-bold text-center">~ Interactions ~</h2>
          <h4 class="fs-3 text-center" style="color: #9F6B46;">
            {{ number_format($interactionsTotal) }}
          </h4>

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

          <h5 class="text-decoration-underline fw-bold">Top posts</h5>
          <div class="d-flex flex-wrap gap-2 mb-5">
            @foreach($topInteractionPosts as $post)
            <div class="mx-auto text-center">
              <a href="{{ route('post.show', $post->id) }}">
                @if ($post->images->first())
                  <img src="{{ asset ('storage/' .  $post->images->first()->image )}}" class="img-thumbnail" style="width:110px; height:110px; object-fit: cover;">
                @else
                  <img src="/no-image.png" class="img-thumbnail" style="width:110px; height:110px; object-fit: cover;">
                @endif
              </a>
              <div class="small">{{ $post->created_at->format('M j') }}</div>
            </div>
            @endforeach
          </div>

          <h5 class="text-decoration-underline fw-bold">By interaction</h5>
          <ul class="list-unstyled" style="color: #9F6B46;">
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
      <div class="card shadow h-100">
        <div class="card-body">
          <h2 class="card-title fw-bold text-center">~ Followers ~</h2>
          <h4 class="fs-3 text-center" style="color: #9F6B46;">
            {{ number_format($followersNow) }}
          </h4>
          <div class="text-center text-danger mb-3">
            {{ $followersPercent >= 0 ? '+' : '' }}{{ $followersPercent }}% vs last month
          </div>

          <h5 class="text-decoration-underline fw-bold">Followers Trend</h5>
          <div class="mb-5" style="height:250px;">
            <canvas id="followersChangeChart" class="w-100 h-100"></canvas>
          </div>

          <h5 class="text-decoration-underline fw-bold">Top countries</h5>
          <div class="country-list">
            @foreach($countryStats as $country)
              @php
                $total = $countryStats->sum('count') ?: 1;
                $count = $country->count;
                $percent = round(($count / $total) * 100);
              @endphp
              <div class="list-group-item p-1">
                <div class="d-flex justify-content-between country-name">
                  <span>{{ $country->country ?? 'Unknown' }} ({{ $count }})</span>
                  <span>{{ $percent }}%</span>
                </div>

                <div class="progress" style="height: 8px;" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar" style="width: {{ $percent }}%"></div>
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
      datasets: [{ data: [{{ $followersRate }}, {{ $nonFollowersRate }}], backgroundColor: ['#F1BDB2', '#9F6B46'] }]
    },
    options: { cutout: '60%', plugins: { legend: { display: false } }, responsive: true, maintainAspectRatio: false }
  });

  // Interactions Donut
  new Chart(document.getElementById('interactionsDonutChart'), {
    type: 'doughnut',
    data: {
      labels: ['Followers', 'Non-followers'],
      datasets: [{ data: [{{ $interactionFollowersRate }}, {{ $interactionNonFollowersRate }}], backgroundColor: ['#F1BDB2', '#9F6B46'] }]
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
        data: [2, 4, 5, 4, 6, 8, 3],
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
      scales: { y: { min: 0, max: 10, ticks: { stepSize: 2 } } },
      plugins: { legend: { display: false } }
    }
  });
</script>

@endsection