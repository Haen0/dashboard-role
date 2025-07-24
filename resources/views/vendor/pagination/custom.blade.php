{{-- @if ($paginator->hasPages()) --}}
    <div class="flex flex-col md:flex-row items-center justify-between mt-4 text-sm text-gray-700 gap-4">

        {{-- Showing --}}
        <div>
            Showing {{ $paginator->firstItem() ?? 0 }} to {{ $paginator->lastItem() ?? 0 }} of {{ $paginator->total() }} results
        </div>

        {{-- Pagination Controls --}}
        <div class="flex items-center gap-2">

            {{-- First & Prev --}}
            @if ($paginator->onFirstPage())
                <button disabled class="flex items-center px-2 py-1 text-gray-400 bg-gray-100 border border-gray-300 rounded">&laquo;</button>
                <button disabled class="flex items-center px-2 py-1 text-gray-400 bg-gray-100 border border-gray-300 rounded">&lt;</button>
            @else
                <a href="{{ $paginator->url(1) }}" class="flex items-center px-2 py-1 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-100">&laquo;</a>
                <a href="{{ $paginator->previousPageUrl() }}" class="flex items-center px-2 py-1 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-100">&lt;</a>
            @endif

            {{-- Page Numbers --}}
            @php
                $currentPage = $paginator->currentPage();
                $lastPage = $paginator->lastPage();
                $start = max($currentPage - 2, 1);
                $end = min($start + 4, $lastPage);
                $start = max($end - 4, 1);
            @endphp

            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $currentPage)
                    <span class="flex items-center px-3 py-1 text-white bg-blue-600 border border-blue-600 rounded">{{ $page }}</span>
                @else
                    <a href="{{ $paginator->url($page) }}" class="flex items-center px-3 py-1 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-100">{{ $page }}</a>
                @endif
            @endfor

            {{-- Next & Last --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="flex items-center px-2 py-1 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-100">&gt;</a>
                <a href="{{ $paginator->url($paginator->lastPage()) }}" class="flex items-center px-2 py-1 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-100">&raquo;</a>
            @else
                <button disabled class="flex items-center px-2 py-1 text-gray-400 bg-gray-100 border border-gray-300 rounded">&gt;</button>
                <button disabled class="flex items-center px-2 py-1 text-gray-400 bg-gray-100 border border-gray-300 rounded">&raquo;</button>
            @endif

            {{-- Jump to page --}}
            <form method="GET" action="{{ url()->current() }}" class="ml-4 flex items-center gap-2">
                @foreach(request()->except('page') as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <input name="page" type="number" min="1" max="{{ $paginator->lastPage() }}"
                    class="block w-16 px-2 py-1 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Page" />
                <button type="submit"
                    class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-3 py-1">Go</button>
            </form>
        </div>
    </div>
{{-- @endif --}}
