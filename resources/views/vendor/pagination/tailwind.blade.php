@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi halaman" class="flex items-center justify-center gap-1 text-sm">
        @if ($paginator->onFirstPage())
            <span class="rounded-full px-4 py-2 text-arang/30">&larr; Sebelumnya</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="rounded-full px-4 py-2 font-medium text-bata-700 hover:bg-lontar-100">&larr; Sebelumnya</a>
        @endif

        <span class="hidden items-center gap-1 sm:flex">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-2 text-arang/40">{{ $element }}</span>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" class="grid h-10 w-10 place-items-center rounded-full bg-bata-800 font-semibold text-lontar-50">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="grid h-10 w-10 place-items-center rounded-full text-arang/70 hover:bg-lontar-100">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </span>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="rounded-full px-4 py-2 font-medium text-bata-700 hover:bg-lontar-100">Berikutnya &rarr;</a>
        @else
            <span class="rounded-full px-4 py-2 text-arang/30">Berikutnya &rarr;</span>
        @endif
    </nav>
@endif
