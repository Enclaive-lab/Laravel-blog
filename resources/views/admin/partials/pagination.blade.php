@if($posts->hasPages())
    <nav class="flex flex-wrap items-center justify-between gap-4 border-t border-line px-5 py-4 sm:px-6" aria-label="Страницы публикаций">
        <p class="text-[13px] text-slate-400">Показаны <span class="font-semibold text-slate-600">{{ $posts->firstItem() }}–{{ $posts->lastItem() }}</span> из {{ $posts->total() }} записей</p>
        <div class="flex items-center gap-1">
            @if($posts->onFirstPage())
                <span class="flex size-8 items-center justify-center text-slate-300" aria-disabled="true"><x-admin.icon name="chevron-left" width="15" height="15" /></span>
            @else
                <a href="{{ $posts->previousPageUrl() }}" class="flex size-8 items-center justify-center rounded-lg text-slate-500 hover:bg-canvas" aria-label="Предыдущая страница"><x-admin.icon name="chevron-left" width="15" height="15" /></a>
            @endif
            @foreach($posts->getUrlRange(max(1, $posts->currentPage() - 2), min($posts->lastPage(), $posts->currentPage() + 2)) as $page => $url)
                <a href="{{ $url }}" @class(['flex size-8 items-center justify-center rounded-lg text-sm font-semibold', 'bg-brand text-white' => $page === $posts->currentPage(), 'text-slate-500 hover:bg-canvas' => $page !== $posts->currentPage()]) @if($page === $posts->currentPage()) aria-current="page" @endif>{{ $page }}</a>
            @endforeach
            @if($posts->hasMorePages())
                <a href="{{ $posts->nextPageUrl() }}" class="flex size-8 items-center justify-center rounded-lg text-slate-500 hover:bg-canvas" aria-label="Следующая страница"><x-admin.icon name="chevron-right" width="15" height="15" /></a>
            @else
                <span class="flex size-8 items-center justify-center text-slate-300" aria-disabled="true"><x-admin.icon name="chevron-right" width="15" height="15" /></span>
            @endif
        </div>
    </nav>
@else
    <div class="border-t border-line px-6 py-4 text-[13px] text-slate-400">{{ $posts->total() }} записей в вашем блоге</div>
@endif
