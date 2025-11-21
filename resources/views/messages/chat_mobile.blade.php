@extends('layouts.app')

@section('content')

<div class="container w-100">
    {{-- back buttom + user icon + user name + dropdown(delete room)--}}
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('conversation.show')}}"><i class="fa-solid fa-angle-left" style="font-size:35px; line-height:50px; color: #D9D9D9"></i></a>

        @if ($partner->avatar)
            <img src="{{ $partner->avatar }}" alt="{{ $partner->name }}" class="rounded-circle" style="width:50px; height:50px;">
        @else
            <i class="fa-solid fa-user rounded-circle me-4 align-items-center" style="width:50px; height:50px; font-size:40px; display:flex; align-items:center; justify-content:center; background-color:#ccc; color:#fff;"></i>
        @endif
        

        @if (isset($partner) && $partner)
            <h6 class="mb-0" style="line-height: 1">{{ $partner->name }}</h6>
        @else
            <h2 class="mb-0 text-muted" style="font-size:24px; line-height: 50px;">No active conversation</h2>
        @endif

        <div class="dropdown ms-auto me-3">
            <button class="btn btn-link text-secondary p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-ellipsis-vertical" style="color: #D9D9D9; font-size:30px;"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                <li class="text-center">
                    <a class="dropdown-item" href="#" style="color: #9F6B46">
                        <form action="{{ route('conversations.destroy', $conversation->id )}}" method="POST" onsubmit="return confirm('Delete this conversation?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">
                                <i class="fa-solid fa-trash" style="color:#9F6B46"></i> &nbsp;Room
                            </button>
                        </form>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    {{-- chat board --}}
    <div class="container">
        <div class="col-12">
            @include('messages.partials.chat',['conversation'=>$conversation])
        </div>
    </div>
</div>


    
@endsection