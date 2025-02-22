@if ($paginator->hasPages())
    <nav>
        <ul class="pagination justify-content-center">
            
            {{-- Previous Button --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link"><i class="fa fa-arrow-left "></i></span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}">
                        <i class="fa fa-arrow-left "></i>
                    </a>
                </li>
            @endif

            {{-- Always show Page 1 --}}
            <li class="page-item {{ $paginator->onFirstPage() ? 'active' : '' }}">
                <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
            </li>

            {{-- Always show Page 2 --}}
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url(2) }}">2</a>
            </li>

            {{-- Always show Page 3 --}}
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url(3) }}">3</a>
            </li>

            {{-- Dots if the current page is greater than 4 --}}
            @if ($paginator->currentPage() > 4)
                <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif

            {{-- Show the current page if it's between 4 and lastPage - 3 --}}
            @if ($paginator->currentPage() > 3 && $paginator->currentPage() < $paginator->lastPage() - 2)
                <li class="page-item active">
                    <a class="page-link" href="{{ $paginator->url($paginator->currentPage()) }}">{{ $paginator->currentPage() }}</a>
                </li>
            @endif

            {{-- Dots before last pages if needed --}}
            @if ($paginator->currentPage() < $paginator->lastPage() - 3)
                <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif

            {{-- Always show second-last page --}}
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url($paginator->lastPage() - 1) }}">{{ $paginator->lastPage() - 1 }}</a>
            </li>

            {{-- Always show Last Page --}}
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
            </li>

            {{-- Next Button --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
                        <i class="fa fa-arrow-right "></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">
                        <i class="fa fa-arrow-right "></i>
                    </span>
                </li>
            @endif

        </ul>
    </nav>
@endif
