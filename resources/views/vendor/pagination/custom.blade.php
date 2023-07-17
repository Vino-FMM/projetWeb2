@if ($paginator->hasPages())
    <div class="pagination-container">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <div class="disabled pagination-link">Previous</div>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="pagination-link">Previous</a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="pagination-link">Next</a>
        @else
            <div class="disabled pagination-link">Next</div>
        @endif
    </div>
@endif
