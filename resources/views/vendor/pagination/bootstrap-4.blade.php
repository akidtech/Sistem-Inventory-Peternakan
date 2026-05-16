@if ($paginator->hasPages())
    <nav aria-label="Pagination Navigation" class="d-flex justify-content-between align-items-center mb-4">
        <div>
            @if ($paginator->onFirstPage())
                <span class="page-link disabled">« Previous</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="page-link">« Previous</a>
            @endif
        </div>

        <div class="d-flex gap-2">
            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span aria-disabled="true" class="page-link disabled">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="page-link active" aria-label="Page {{ $page }}">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" aria-label="Go to page {{ $page }}" class="page-link">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        <div>
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="page-link">Next »</a>
            @else
                <span class="page-link disabled">Next »</span>
            @endif
        </div>
    </nav>

    <div class="text-muted text-center mb-3">
        <small>Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }}
            results</small>
    </div>
@endif
