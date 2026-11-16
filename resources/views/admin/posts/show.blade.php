
@extends('admin.layouts.app')

@section('title', $post->title)
@section('breadcrumb', 'Предпросмотр записи')

@section('content')
    @php
        $words = preg_split('/\s+/u', trim(strip_tags($post->body)), -1, PREG_SPLIT_NO_EMPTY);
        $readingMinutes = max(1, (int) ceil(count($words) / 180));
        $paragraphs = preg_split('/\R\s*\R/u', trim($post->body));
    @endphp
    <a href="{{ route('admin.posts.index') }}" class="mb-6 inline-flex items-center gap-2 text-[13px] font-semibold text-slate-400 transition hover:text-brand"><x-admin.icon name="arrow-left" width="15" height="15" />Все публикации</a>

    <div class="mb-8 flex flex-wrap items-end justify-between gap-5">
        <div><div class="mb-3 flex items-center gap-2 text-[13px] font-semibold tracking-[.1em] text-slate-400 uppercase"><span class="h-px w-5 bg-brand"></span>Взгляд со стороны читателя</div><h1 class="font-heading text-[30px] font-semibold tracking-[-1px] sm:text-[34px]">Предпросмотр записи</h1><p class="mt-2 text-sm leading-6 text-slate-500">Последний взгляд на вашу историю перед следующей главой.</p></div>
        <a href="{{ route('admin.posts.edit', $post) }}" class="inline-flex items-center gap-2.5 rounded-lg bg-brand px-5 py-3 text-sm font-semibold text-white hover:bg-[#095e57]"><x-admin.icon name="edit" width="16" height="16" />Редактировать</a>
    </div>

    <div class="grid items-start gap-6 xl:grid-cols-[minmax(0,1fr)_260px]">
        <article class="min-w-0 overflow-hidden rounded-xl border border-line bg-white">
            <div class="relative flex h-36 items-center justify-between overflow-hidden border-b border-[#dfece6] bg-[#eaf3ee] px-7 sm:h-44 sm:px-10" aria-hidden="true">
                <div class="relative z-10"><span class="mb-3 block text-[12px] font-semibold tracking-[.2em] text-[#7c9b8c] uppercase">Заметки и истории</span><span class="font-heading text-3xl font-medium tracking-[-1px] text-[#315a48]">Из личного блога<span class="text-[#90b19d]">.</span></span><span class="mt-3 block font-mono text-[12px] text-[#90a89a]">LARAVEL BLOG — ЗАПИСЬ {{ str_pad($post->id, 3, '0', STR_PAD_LEFT) }}</span></div>
                <svg class="absolute right-1 bottom-[-12px] h-[180px] w-[180px] opacity-70 sm:right-5 sm:h-[220px] sm:w-[220px]" viewBox="0 0 220 220" fill="none"><circle cx="120" cy="110" r="88" stroke="#cedfd2"/><circle cx="120" cy="110" r="64" stroke="#cedfd2"/><rect x="65" y="46" width="95" height="132" rx="8" transform="rotate(12 65 46)" fill="#f5faf6" stroke="#c2d7c7"/><rect x="52" y="38" width="95" height="132" rx="8" fill="#fff" stroke="#c2d7c7"/><path d="M72 64h55M72 77h55M72 90h55M72 103h34M72 139h22" stroke="#91b39e" stroke-width="3" stroke-linecap="round"/></svg>
            </div>

            <div class="p-6 sm:p-9 lg:p-10">
                <div class="mb-5 flex flex-wrap items-center gap-3"><span @class(['inline-flex items-center gap-1.5 rounded-md px-2 py-1 text-[12px] font-semibold', 'bg-[#ecf6f0] text-[#35704f]' => $post->is_published, 'bg-[#fff6e8] text-[#8f671f]' => !$post->is_published])><span class="size-1 rounded-full bg-current"></span>{{ $post->is_published ? 'Опубликовано' : 'Черновик' }}</span><span class="text-[13px] text-slate-400">{{ $post->published_at?->format('d.m.Y') ?? 'Дата не указана' }}</span></div>
                <h2 class="font-heading text-[28px] leading-[1.3] font-semibold tracking-[-.8px] text-ink sm:text-[36px]">{{ $post->title }}</h2>
                <div class="mt-6 flex flex-wrap items-center gap-3 border-b border-line pb-7"><span class="flex size-8 items-center justify-center rounded-full bg-[#edf3ef] text-[13px] font-semibold text-brand">АБ</span><span class="text-[13px] font-semibold text-slate-500">{{ $post->author?->name ?? 'Автор блога' }}</span><span class="mx-1 size-1 rounded-full bg-slate-300"></span><span class="inline-flex items-center gap-1.5 text-[13px] text-slate-400"><x-admin.icon name="clock" width="13" height="13" />{{ $readingMinutes }} мин чтения</span></div>
                @if($post->excerpt)<p class="mt-7 border-l-[3px] border-[#91b5a4] pl-5 font-heading text-base leading-8 font-medium text-[#62756d]">{{ $post->excerpt }}</p>@endif
                <div class="article-content mt-7">@foreach($paragraphs as $paragraph)<p class="whitespace-pre-line">{{ $paragraph }}</p>@endforeach</div>
                <div class="mt-10 flex items-center gap-3 border-t border-line pt-6 text-[13px] text-slate-400"><span class="h-px w-8 bg-[#a7c2b3]"></span>Спасибо, что дочитали до конца.</div>
            </div>
        </article>

        <aside class="space-y-5 xl:sticky xl:top-6" aria-label="Информация о записи">
            <section class="rounded-xl border border-line bg-white p-5"><h2 class="mb-5 font-heading text-sm font-medium">Детали записи</h2><dl class="space-y-5 text-[13px]"><div class="flex justify-between gap-3"><dt class="text-slate-400">Номер</dt><dd class="font-mono font-medium text-slate-600">#{{ str_pad($post->id, 3, '0', STR_PAD_LEFT) }}</dd></div><div class="flex justify-between gap-3"><dt class="text-slate-400">Создана</dt><dd class="font-medium text-slate-600">{{ $post->created_at?->format('d.m.Y') }}</dd></div><div class="flex justify-between gap-3"><dt class="text-slate-400">Обновлена</dt><dd class="font-medium text-slate-600">{{ $post->updated_at?->format('d.m.Y') }}</dd></div><div class="flex justify-between gap-3"><dt class="text-slate-400">Чтение</dt><dd class="font-medium text-slate-600">~ {{ $readingMinutes }} мин</dd></div></dl><div class="mt-5 border-t border-line pt-4"><p class="mb-2 text-[13px] text-slate-400">Короткое имя</p><p class="break-all rounded-md bg-canvas px-3 py-2 font-mono text-[12px] leading-5 text-slate-500">{{ $post->slug }}</p></div><button type="button" data-copy-url="{{ route('admin.posts.show', $post) }}" class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-lg border border-line px-3 py-2.5 text-[13px] font-semibold text-slate-600 hover:bg-canvas"><x-admin.icon name="copy" width="14" height="14" />Копировать ссылку</button></section>
            <div class="rounded-xl bg-[#edf3f5] p-5"><span class="mb-3 inline-flex text-[#829da8]"><x-admin.icon name="eye" width="19" height="19" /></span><p class="font-heading text-[15px] font-medium text-[#5b7781]">Всё на своих местах?</p><p class="mt-2 text-[13px] leading-6 text-[#5b737d]">Проверьте заголовок, описание и дату. К редактированию всегда можно вернуться.</p><a href="{{ route('admin.posts.edit', $post) }}" class="mt-4 inline-flex items-center gap-2 text-[13px] font-semibold text-[#5b7781]">Вернуться к тексту<x-admin.icon name="arrow-up-right" width="13" height="13" /></a></div>
        </aside>
    </div>
@endsection
