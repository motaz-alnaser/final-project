@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation">
        <ul class="pagination" style="
            display: flex;
            justify-content: center;
            gap: 8px;
            list-style: none;
            padding: 0;
        ">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li style="opacity: 0.5; cursor: not-allowed;">
                    <span style="
                        padding: 10px 16px;
                        background: var(--carbon-medium);
                        border: 1px solid var(--metal-dark);
                        color: var(--text-secondary);
                        border-radius: 8px;
                    ">Previous</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" style="
                        padding: 10px 16px;
                        background: var(--carbon-medium);
                        border: 1px solid var(--metal-dark);
                        color: var(--text-primary);
                        text-decoration: none;
                        border-radius: 8px;
                        transition: all 0.3s ease;
                    ">Previous</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li style="
                        padding: 10px 16px;
                        color: var(--text-secondary);
                    ">{{ $element }}</li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li style="
                                padding: 10px 16px;
                                background: var(--accent-purple);
                                border: 1px solid var(--accent-purple);
                                color: white;
                                border-radius: 8px;
                            ">{{ $page }}</li>
                        @else
                            <li>
                                <a href="{{ $url }}" style="
                                    padding: 10px 16px;
                                    background: var(--carbon-medium);
                                    border: 1px solid var(--metal-dark);
                                    color: var(--text-primary);
                                    text-decoration: none;
                                    border-radius: 8px;
                                    transition: all 0.3s ease;
                                ">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" style="
                        padding: 10px 16px;
                        background: var(--carbon-medium);
                        border: 1px solid var(--metal-dark);
                        color: var(--text-primary);
                        text-decoration: none;
                        border-radius: 8px;
                        transition: all 0.3s ease;
                    ">Next</a>
                </li>
            @else
                <li style="opacity: 0.5; cursor: not-allowed;">
                    <span style="
                        padding: 10px 16px;
                        background: var(--carbon-medium);
                        border: 1px solid var(--metal-dark);
                        color: var(--text-secondary);
                        border-radius: 8px;
                    ">Next</span>
                </li>
            @endif
        </ul>
    </nav>
@endif