@if ($paginator->hasPages())
    @php($url = explode('/', Request::url()))
    @php($homePage = in_array(end($url), ['products', 'filter']))
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="page-selector page-text px-4 cursor-default rounded-md">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <span class="page-selector cursor-pointer px-4 font-medium text-gray-700 border rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" onClick="change_page({{ $paginator->currentPage()-1 }})">
                    {!! __('pagination.previous') !!}
                </span>
            @endif

            @if ($paginator->hasMorePages())
                
                @if($homePage)
                    <span class="page-selector cursor-pointer px-4 ml-3 font-medium text-gray-700 border rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" onClick="change_page({{ $paginator->currentPage()+1 }})">
                @else
                    <a href="{{ $paginator->nextPageUrl() }}" class="page-selector cursor-pointer px-4 ml-3 font-medium text-gray-700 border rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                @endif
                    {!! __('pagination.next') !!}
                @if($homePage)
                    </span>
                @else
                    </a>
                @endif
            @else
                <span class="page-selector page-text px-4 ml-3 cursor-default rounded-md">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <span class="pages">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="page-selector page-text px-2 cursor-default rounded-l-md" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        @if($homePage)
                            <span class="page-selector cursor-pointer page-text px-2 rounded-l-md hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="{{ __('pagination.previous') }}" onClick="change_page({{ $paginator->currentPage()-1 }})">
                        @else
                            <a href="{{ $paginator->previousPageUrl() }}" class="page-selector cursor-pointer page-text px-2 rounded-l-md hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="{{ __('pagination.previous') }}">
                        @endif
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        @if($homePage)
                            </span>
                        @else
                            </a>
                        @endif
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{--"Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="page-selector px-4 -ml-px font-medium text-gray-700 border cursor-default">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="page-selector cur-page">{{ $page }}</span>
                                    </span>
                                @else
                                    @if($homePage)
                                        <span class="page-selector cursor-pointer px-4 -ml-px font-medium text-gray-700 border hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="{{ __('Go to page :page', ['page' => $page]) }}" onClick="change_page({{ $page }})">
                                    @else
                                        <a href="{{ $url }}" class="page-selector cursor-pointer px-4 -ml-px font-medium text-gray-700 border hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                    @endif
                                        {{ $page }}
                                    @if($homePage)
                                        </span>
                                    @else
                                        </a>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        @if($homePage)
                            <span class="page-selector cursor-pointer page-text px-2 -ml-px rounded-r-md hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="{{ __('pagination.next') }}" onClick="change_page({{ $paginator->currentPage()+1 }})">
                        @else
                            <a href="{{ $paginator->nextPageUrl() }}" class="page-selector cursor-pointer page-text px-2 -ml-px rounded-r-md hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="{{ __('pagination.next') }}">
                        @endif
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        @if($homePage)
                            </span>
                        @else
                            </a>
                        @endif
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="page-selector page-text px-2 -ml-px cursor-default rounded-r-md" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
