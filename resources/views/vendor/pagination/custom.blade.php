@if ($paginator->hasPages())
    <div>
        <ul class="pagination-container">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="pagination-link" aria-hidden="true">Précédent</span>
                </li>
            @else
                <li>
                    <a class="pagination-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">Précédent</a>
                </li>
            @endif

            {{-- Page Number --}}
            <li>
                <span class="pagination-link-number">{{ $paginator->currentPage() }} sur {{ $paginator->lastPage() }}</span>
            </li>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a class="pagination-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">Suivant</a>
                </li>
            @else
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="pagination-link" aria-hidden="true">Suivant</span>
                </li>
            @endif
        </ul>
    </div>
@endif

