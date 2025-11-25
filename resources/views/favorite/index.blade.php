@extends('layouts.app')


@section('content')
 
    {{-- search bar --}}
    <div class="container mb-5">
        <form id="search-form" action="{{ route('favorite') }}" method="get">
            <div class="row align-items-end">
                <div class="col-12 col-md-4 mb-3 mb-md-0">
                    <input type="text" name="search" class="form-control" placeholder="{{ __('messages.favorite.search_placeholder') }}" value="{{ $search }}">
                </div>

                <div class="col-12 col-md-8">
                    <div class="row g-2  align-items-end">
                        <div class="col-6 col-md-5 mb-3 mb-md-0">
                            <label for="" class="form-label">
                                {{ __('messages.favorite.prefecture') }}
                            </label>
                            <select name="prefecture" class="form-select text-muted">
                                <option value="" selected>
                                    {{ __('messages.favorite.prefecture_placeholder') }}
                                </option>
                                @foreach ($all_prefectures as $prefecture)
                                    <option value="{{$prefecture->id}}" {{ $prefecture_id == $prefecture->id ? 'selected' : '' }}>{{$prefecture->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-5 mb-3 mb-md-0">
                            <label for="" class="form-label">
                                {{ __('messages.favorite.category') }}
                            </label>
                            <select name="category" class="form-select text-muted">
                                <option value="" selected>
                                    {{ __('messages.favorite.category_placeholder') }}
                                </option>
                                @foreach ($all_categories as $category)
                                    <option value="{{$category->id}}" {{ $category_id == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-2 d-grid">
                            <button type="submit" class="btn btn-outline w-100">
                                {{ __('messages.favorite.search') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- order tabs --}}
    <div class="container mx-auto mb-2">
        <div class="nav-tabs-wrapper">
            <ul class="nav nav-tabs d-flex flex-nowrap custom-tabs text-center">

                @php $query = request()->all(); @endphp
                <li class="nav-item tab-item">
                    <a href="{{ route('favorite', ['order' => 'newest']) }}" class="tab-btn {{ $order === 'newest' ? 'active' : '' }}" data-order="newest">
                    {{ __('messages.favorite.sort_1') }}
                    </a>
                </li>

                <li class="nav-item tab-item">
                    <a href="{{ route('favorite', ['order' => 'oldest']) }}" class="tab-btn {{ $order === 'oldest' ? 'active' : '' }}" data-order="oldest">
                    {{ __('messages.favorite.sort_2') }}
                    </a>
                </li>
                <li class="nav-item tab-item">
                    <a href="{{ route('favorite', array_merge($query, ['order' => 'most_liked'])) }}" class="tab-btn {{ $order === 'most_liked' ? 'active' : '' }}" data-order="most_liked">
                        {{ __('messages.favorite.sort_3') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container w-100 mx-auto">
        <div id="favorite-list">
            @include('favorite.favorite_posts')
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $favorites->appends(request()->query())->links() }}
    </div>

    {{-- For Serch and Order --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // when double click
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    
                    const order = this.dataset.order;
                    const form = document.querySelector('#search-form');
                    const formData = new FormData(form);
                    formData.append('order', order);

                    
                    const query = new URLSearchParams(formData).toString();
                    
                    fetch(`{{ route('favorite') }}?${query}`)
                        .then(res => res.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const newList = doc.querySelector('#favorite-list').innerHTML;
                            document.querySelector('#favorite-list').innerHTML = newList;

                            // change active tab
                            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                            this.classList.add('active');
                        })
                        .catch(err => console.error(err));
                });
            });
        });
    </script>

    {{-- For Favorite button --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const favoriteList = document.querySelector('#favorite-list');
            const token = document.querySelector('meta[name="csrf-token"]').content;

            favoriteList.addEventListener('click', async (e) => {
                const button = e.target.closest('.favorite-btn');
                if (!button) return;

                e.preventDefault();

                const postId = button.dataset.postId;
                const isFavorited = button.dataset.favorited === 'true';

                try {
                    const url = isFavorited
                        ? `/favorite/${postId}/destroy`
                        : `/favorite/${postId}/store`;
                    const method = isFavorited ? 'DELETE' : 'POST';

                    const response = await fetch(url, {
                        method: method,
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                    });

                    const data = await response.json();

                    if (data.success) {
                        const icon = button.querySelector('i');

                        if (data.favorited) {
                            // register favorite
                            icon.classList.remove('fa-regular');
                            icon.classList.add('fa-solid', 'text-warning');
                            button.dataset.favorited = 'true';
                        } else {
                            // remove favorite
                            icon.classList.remove('fa-solid', 'text-warning');
                            icon.classList.add('fa-regular');
                            button.dataset.favorited = 'false';

                            // fade
                            const card = button.closest('.col-12');
                            card.style.transition = 'opacity 0.4s ease';
                            card.style.opacity = '0';
                            setTimeout(() => {
                                card.remove();

                            if (favoriteList.querySelectorAll('.favorite-btn').length === 0) {
                                favoriteList.innerHTML = '<h2>There is no favorite post.</h2>';
                            }
                        }, 400);
                        }
                    }

                } catch (err) {
                    console.error(err);
                }
            });
        });
    </script>

    {{-- For Liked button --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            document.querySelectorAll('.like-button').forEach(button => {
                button.addEventListener('click', async () => {

                    const postId = button.dataset.postId;
                    const liked = button.dataset.liked === 'true';

                    const url = liked 
                        ? `/like/${postId}/destroy`  // DELETE
                        : `/like/${postId}/store`; // POST same route

                    const method = liked ? 'DELETE' : 'POST';

                    const response = await fetch(url, {
                        method: method,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        }
                    });

                    const data = await response.json();

                    if (data.success) {

                        const icon = button.querySelector('i');
                        const countElement = button.nextElementSibling;

                        if (data.liked) {
                            icon.classList.remove('fa-regular');
                            icon.classList.add('fa-solid');
                            icon.style.color = '#F1BDB2';
                        } else {
                            icon.classList.remove('fa-solid');
                            icon.classList.add('fa-regular');
                            icon.style.color = '#9F6B46';
                        }

                        countElement.textContent = data.like_count;

                        button.dataset.liked = data.liked ? 'true' : 'false';
                    }
                });
            });
        });
    </script>

    
@endsection


