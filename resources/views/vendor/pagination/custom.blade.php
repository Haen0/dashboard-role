@if ($paginator->hasPages())
    <div class="flex items-center justify-between mt-4 text-sm text-gray-700">

        {{-- Showing --}}
        <div>
            Showing {{ $paginator->firstItem() ?? 0 }} to {{ $paginator->lastItem() ?? 0 }} of {{ $paginator->total() }} results
        </div>

        <div class="flex items-center gap-2">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="px-2 py-1 text-gray-400">&laquo;</span>
                <span class="px-2 py-1 text-gray-400">&lt;</span>
            @else
                <a href="{{ $paginator->url(1) }}" class="px-2 py-1 hover:underline">&laquo;</a>
                <a href="{{ $paginator->previousPageUrl() }}" class="px-2 py-1 hover:underline">&lt;</a>
            @endif

            {{-- Pages --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-2 py-1">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @php
                        $currentPage = $paginator->currentPage();
                        $lastPage = $paginator->lastPage();
                        $start = max($currentPage - 2, 1);
                        $end = min($start + 4, $lastPage);
                        $start = max($end - 4, 1);
                    @endphp

                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $currentPage)
                            <span class="px-2 py-1 font-bold underline">{{ $page }}</span>
                        @else
                            <a href="{{ $paginator->url($page) }}" class="px-2 py-1 hover:underline">{{ $page }}</a>
                        @endif
                    @endfor
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-2 py-1 hover:underline">&gt;</a>
                <a href="{{ $paginator->url($paginator->lastPage()) }}" class="px-2 py-1 hover:underline">&raquo;</a>
            @else
                <span class="px-2 py-1 text-gray-400">&gt;</span>
                <span class="px-2 py-1 text-gray-400">&raquo;</span>
            @endif

            {{-- Jump to page --}}
            <form method="GET" action="{{ url()->current() }}" class="ml-4 flex items-center gap-1">
                @foreach(request()->except('page') as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <input name="page" type="number" min="1" max="{{ $paginator->lastPage() }}" class="w-16 px-1 py-0.5 border rounded text-sm" placeholder="Page" />
                <button type="submit" class="px-2 py-0.5 bg-gray-200 hover:bg-gray-300 rounded">Go</button>
            </form>

        </div>
    </div>
@endif
