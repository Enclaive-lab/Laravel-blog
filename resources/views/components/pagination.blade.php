@if ($paginator->hasPages())
  
<nav class="mt-8 flex items-center justify-center gap-2"
     aria-label="Пагинация">
    @if ($paginator -> onFirstPage())
    
    <span aria-label="Предыдущая страница" aria-disabled="true"
       class="rounded-lg border border-line bg-white px-3 py-2 text-sm hover:border-brand">
        ←
    </span>
    @else
    <a href="{{ $paginator->previousPageUrl() }}" aria-label="Предыдущая страница"
       class="rounded-lg border border-line bg-white px-3 py-2 text-sm hover:border-brand">
        ←
    </a>
@endif
   @foreach ($elements as $element ) 
    @if(is_string($element))
    <span class="px-3 py-2 text-sm text-slate-500">
        {{ $element }}
    </span>
    @endif

    @if(is_array($element))
    @foreach ( $element as $page => $url)
       @if ($page == $paginator->currentPage() )
          <span aria-current="page"
          class="rounded-lg bg-brand px-3 py-2 text-sm text-white">
        {{ $page }}
    </span>
    @else
    <a href="{{ $url }}"
          class="rounded-lg border border-line bg-white px-3 py-2 text-sm hover:border-brand">
        {{ $page}}
    </a>
       @endif
    @endforeach
    @endif
  @endforeach

   @if ($paginator->hasMorePages())  
   <a href="{{ $paginator->nextPageUrl() }}" aria-label="Следующая страница"
       class="rounded-lg border border-line bg-white px-3 py-2 text-sm hover:border-brand">
        →
   </a>
   @else
   <span aria-label="Следующая страница" aria-disabled="true"
       class="rounded-lg border border-line bg-white px-3 py-2 text-sm hover:border-brand">
        →
    </span>
   @endif
</nav>
@endif
