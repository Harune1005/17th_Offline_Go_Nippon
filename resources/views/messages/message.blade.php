@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        {{-- pc user-list --}}
        <div class="col-4 d-none d-md-block" id="conversation-list-pc">
            <div class="container w-100 mt-1">
                {{-- title --}}
                <div class="d-flex">
                    <h2 class="mb-0" style="font-size: 32px;">
                        {{ __('messages.dm.title') }}
                    </h2>
                    <div class="d-flex align-items-center ms-auto">
                        <button class="btn border-0" data-bs-toggle="modal" data-bs-target="#followListModal">
                        <i class="fa-solid fa-square-plus" style="font-size:24px; color:#F1BDB2"></i>
                        </button>
                    </div>
                </div>
                {{-- search user list --}}
                <div class="d-flex mb-3 mt-2 align-items-center" style="width: 100%">
                    <input type="text" id="conversation-search-pc" class="form-control conversation-search me-4" placeholder="{{ __('messages.dm.search_placeholder') }}">
                </div>

                {{-- conversation lists --}}
                <div id="conversation-items-{{ $device ?? 'pc' }}">
                    @include('messages.partials.user_list_items', ['conversations' => $conversations, 'user_id' => $user_id])
                </div>

                {{-- creat new conversation button --}}
                <div class="d-flex align-items-center justify-content-center rounded-3 p-3 message-users">
                    <button class="btn border-0" data-bs-toggle="modal" data-bs-target="#followListModal">
                        <i class="fa-regular fa-square-plus" style="font-size: 50px;"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- mobile user-list --}}
        <div class="col-12 d-md-none" id="conversation-list-mobile">
            <div class="container w-100">
                 {{-- title --}}
                <div class="d-flex">
                    <h2 class="mb-0" style="font-size: 32px;">
                        {{ __('messages.dm.title') }}
                    </h2>
                    <div class="d-flex align-items-center ms-auto">
                        <button class="btn border-0" data-bs-toggle="modal" data-bs-target="#followListModal">
                        <i class="fa-solid fa-square-plus" style="font-size:24px; color:#F1BDB2"></i>
                        </button>
                    </div>
                </div>
                {{-- search user list --}}
                <div class="d-flex mb-3 mt-2 align-items-center" style="width: 100%">
                    <input type="text" id="conversation-search-mobile" class="form-control conversation-search me-4" placeholder="Search User...">
                </div>

                {{-- conversation lists --}}
                <div id="conversation-items-{{ $device ?? 'mobile' }}">
                    @include('messages.partials.user_list_items', ['conversations' => $conversations, 'user_id' => $user_id])
                </div>
    

                {{-- creat new conversation button --}}
                <div class="d-flex align-items-center justify-content-center rounded-3 p-3 message-users">
                    <button class="btn border-0" data-bs-toggle="modal" data-bs-target="#followListModal">
                        <i class="fa-regular fa-square-plus" style="font-size: 50px;"></i>
                    </button>
                </div>
            </div>
            

        </div>

        {{-- pc chat-board --}}
        <div class="col-8 d-none d-md-block">
            @include('messages.partials.chat',['conversation' => $conversation])
        </div>
    </div>
</div>

<!-- Follow List Modal -->
<div class="modal fade" id="followListModal" tabindex="-1" aria-labelledby="followListModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="followListModalLabel">
                    {{ __('messages.dm.add_modal_title') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                    <div class="d-flex mb-3 mt-2 align-items-center" style="width: 100%">
                        <div class="d-flex flex-grow-1">
                            <input type="text" id="modal-user-search-input" class="form-control me-4" placeholder="{{ __('messages.dm.search_placeholder') }}">
                        </div>
                    </div>

                <div class="user-list-scroll mt-3" id="modal-follow-list-container">
                    @include('messages.partials.follow_list_items',['followings'=> $followings])
                </div>
            </div>

        </div>
    </div>
</div>

{{-- search conversation --}}
<script>
document.addEventListener('DOMContentLoaded', function() {

    const inputPC = document.getElementById('conversation-search-pc');
    const containerPC = document.getElementById('conversation-items-pc');

    const inputMobile = document.getElementById('conversation-search-mobile');
    const containerMobile = document.getElementById('conversation-items-mobile');

    const inputModal = document.getElementById('modal-user-search-input');
    const containerModal = document.getElementById('modal-follow-list-container');
    const followListModal = document.getElementById('followListModal');
 
    // search conversation list
    const setupSearch = (input, container,routeUrl) => {
        if (input && container) {
            input.addEventListener('input', function() {
                const keyword = this.value;
                
                fetch(routeUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ q: keyword }) 
                })
                .then(res => res.text())
                .then(html => {
                
                    container.innerHTML = html;
                })
                .catch(err => console.error('Search error:', err));
            });
        }
    };

    setupSearch(inputPC, containerPC, `{{ route('conversations.search') }}`);
    setupSearch(inputMobile, containerMobile, `{{ route('conversations.search') }}`);
    


    // search modal(following user list)
    const loadFollowList = (keyword = '') => {
        fetch(`{{ route('conversations.searchFollowings') }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ q: keyword }) 
        })
        .then(res => res.text())
        .then(html => {
            
            containerModal.innerHTML = html;
        })
        .catch(err => console.error('Modal search error:', err));
    };

    if (followListModal) {
        
        followListModal.addEventListener('shown.bs.modal', function () {
            // claar search bar
            inputModal.value = '';
            
            loadFollowList();
        });
    }

    if (inputModal) {
        inputModal.addEventListener('input', function() {
            
            loadFollowList(this.value);
        });
    }
});
</script>

@endsection
