@if ($paginator->hasPages())
    <div class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <button disabled>&lt;</button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}">
                <button>&lt;</button>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <button disabled>{{ $element }}</button>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <button class="active">{{ $page }}</button>
                    @else
                        <a href="{{ $url }}"><button>{{ $page }}</button></a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}">
                <button>&gt;</button>
            </a>
        @else
            <button disabled>&gt;</button>
        @endif
    </div>
@endif