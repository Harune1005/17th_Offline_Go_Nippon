@extends('layouts.app')

@section('content')

    @vite(['resources/css/app.css', 'resources/js/app.js']) 

<div class="container">
    <div class="row">
        {{-- pc user-list --}}
        <div class="col-4 d-none d-md-block">
            @include('messages.partials.user-list')
        </div>

        {{-- mobile user-list --}}
        <div class="col-12 d-md-none">
            @include('messages.partials.user-list')
        </div>

        {{-- pc chat-board --}}
        <div class="col-8 d-none d-md-block">
            @include('messages.partials.chat')
        </div>
    </div>
</div>


@endsection
