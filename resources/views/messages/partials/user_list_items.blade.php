@if($conversations->isEmpty())
    <div class="d-flex align-items-center justify-content-center p-4">
        <p class="mb-0" style="color: #888; font-size: 14px;">
            {{ __('messages.dm.no_user') }}
        </p>
    </div>
@else
    @foreach ($conversations as $conversation)
        @php
            $partner = $conversation->getPartner($user_id);
            $unreadCount = $conversation->unreadCount($user_id);
            $dropdownId = 'dropdownMenuButton-' . $conversation->id;
        @endphp

            <div class="d-flex align-items-center justify-content-between rounded-3 p-3 message-users" data-conversation-id="{{ $conversation->id }}">
                {{-- left side (image + username + last message) --}}
                <a href="{{ route('conversations.show', $conversation->id )}}" class="text-decoration-none">
                    <div class="d-flex align-items-center">
                        @if ($partner->avatar)
                            <img src="{{ $partner->avatar }}" alt="{{ $partner->name }}" class="rounded-circle me-4 align-items-ceter" style="width:75px; height:75px;">
                        @else
                            <i class="fa-solid fa-user rounded-circle me-4 align-items-center" style="width:75px; height:75px; font-size:40px; display:flex; align-items:center; justify-content:center; background-color:#ccc; color:#fff;"></i>
                        @endif
                        
                        <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-3 fw-bold" style="color: #9F6B46">{{ $partner->name }}</h6>
                            <p class="mb-0 last-message" style="font-size: 13px; font-weight:300;">
                                {{ $conversation->last_message_text ?? 'No message yet'}}
                            </p>
                        </div>
                    </div>
                </a>

                {{-- right side  (unread count + delete button) --}}
                <div class="ms-auto d-flex align-items-center gap-3">
                    @if ($unreadCount > 0)
                        <div class="d-flex align-items-center justify-content-center rounded notice m-0" style="width:41px; height:38px;">
                        {{ $unreadCount }}
                        </div>
                    @endif
                    
                    <div class="dropdown d-flex align-items-center justify-content-center d-md-none">
                        <button class="btn btn-link text-secondary p-0" type="button" id="{{ $dropdownId }}" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis-vertical" style="color: #D9D9D9; font-size:30px;"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="{{ $dropdownId }}">
                            <li class="text-center">
                                <a class="dropdown-item" href="#" style="color: #9F6B46">
                                    <form action="{{ route('conversations.destroy', $conversation->id )}}" method="post" onsubmit="return confirm('Delete this conversation?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">
                                            <i class="fa-solid fa-trash" style="color:#9F6B46"></i> &nbsp;{{ __('messages.dm.delete') }}
                                        </button>
                                    </form>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
    @endforeach
@endif