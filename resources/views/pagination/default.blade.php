@if ($paginator->hasPages())
<div class="mp-pagination">
  <div class="mp-pagination__info mp-text-fs-small">
    
     </div> 
    
    <ul class="pagination">
      {{-- Previous Page Link --}}
      @if ($paginator->onFirstPage())
      <li class="disabled mp-text-c-light-gray"><span>&laquo;</span></li>
      @else
      <li><a class="mp-text-c-primary" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
      @endif

      {{-- Pagination Elements --}}
      @foreach ($elements as $element)
      {{-- "Three Dots" Separator --}}
      @if (is_string($element))
      <li class="disabled mp-text-c-light-gray"><span>{{ $element }}</span></li>
      @endif

      {{-- Array Of Links --}}
      @if (is_array($element))
      @foreach ($element as $page => $url)
      @if ($page == $paginator->currentPage())
      <li class="active"><span>{{ $page }}</span></li>
      @else
      <li ><a class="mp-text-c-primary" href="{{ $url }}">{{ $page }}</a></li>
      @endif
      @endforeach
      @endif
      @endforeach

      {{-- Next Page Link --}}
      @if ($paginator->hasMorePages())
      <li ><a class="mp-text-c-primary" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
      @else
      <li class="disabled mp-text-c-light-gray"><span>&raquo;</span></li>
      @endif
    </ul>

</div>
@endif