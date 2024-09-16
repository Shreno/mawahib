@if ($paginator->hasPages())
<div class="row max-mt-50">
    <div class="col">
        <ul class="pagination center">
            {{-- Link to the Previous Page --}}
            @if ($paginator->onFirstPage())
                <li><a href="#" class="prev disabled">السابق</a></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}" class="prev">السابق</a></li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li><a href="#">{{ $element }}</a></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><a href="#" class="active">{{ $page }}</a></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Link to the Next Page --}}
            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}" class="next">التالى</a></li>
            @else
                <li><a href="#" class="next disabled">التالى</a></li>
            @endif
        </ul>
    </div>
</div>
@endif