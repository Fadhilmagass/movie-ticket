@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation">
        <ul class="flex justify-between">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="px-4 py-2 text-gray-400 dark:text-gray-600 cursor-not-allowed">Prevous</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}"
                        class="px-4 py-2 text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                        Previous
                    </a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}"
                        class="px-4 py-2 text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">Next</a>
                </li>
            @else
                <li>
                    <span class="px-4 py-2 text-gray-400 dark:text-gray-600 cursor-not-allowed">Next</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
