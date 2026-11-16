@extends('admin.layouts.app')

@section('title', 'Публикации')

@section('content')
    <div class="mb-8 flex flex-wrap items-end justify-between gap-5">
        <div>
            <div class="mb-3 flex items-center gap-2 text-[13px] font-semibold tracking-[.1em] text-slate-400 uppercase"><span class="h-px w-5 bg-brand"></span>Ваша редакция</div>
            <div class="flex items-center gap-3"><h1 class="font-heading text-[32px] font-semibold tracking-[-1px] sm:text-[36px]">Публикации</h1><span class="rounded-lg border border-line bg-white px-2.5 py-1 font-mono text-sm text-slate-400">{{ str_pad($posts->total(), 2, '0', STR_PAD_LEFT) }}</span></div>
            <p class="mt-2 text-sm leading-6 text-slate-500 sm:text-[15px]">Ваши истории, заметки и идеи. Всё в одном месте.</p>
        </div>
        <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center justify-center gap-2.5 rounded-lg bg-brand px-5 py-3 text-sm font-semibold text-white shadow-[0_3px_8px_#0e756d14] transition hover:bg-[#095e57]"><x-admin.icon name="plus" width="17" height="17" />Новая публикация</a>
    </div>

    <div class="mb-7 flex items-start gap-3.5 rounded-xl border border-[#e0e9e7] bg-[#edf5f2] px-5 py-4">
        <span class="mt-0.5 flex size-8 shrink-0 items-center justify-center rounded-lg bg-white/80 text-brand"><x-admin.icon name="edit" width="17" height="17" /></span>
        <div><p class="text-sm font-semibold text-[#345b52]">Хорошие истории начинаются с черновика.</p><p class="mt-1 text-[13px] leading-5 text-[#536e63]">Сохраните мысль сейчас — к деталям можно вернуться позже.</p></div>
    </div>

    <section class="rounded-xl border border-line bg-white shadow-[0_2px_3px_#172c3602]" aria-label="Список публикаций" data-post-list>
        <div class="flex flex-wrap items-center justify-between gap-x-5 border-b border-line px-5 sm:px-6">
            <div class="-mb-px flex max-w-full items-center gap-5 overflow-x-auto sm:gap-7" role="group" aria-label="Фильтр по статусу">
                <button type="button" class="filter-tab inline-flex shrink-0 items-center gap-2 py-5 text-sm font-semibold" data-status-filter="all" aria-pressed="true">Все записи<span class="rounded bg-canvas px-1.5 py-0.5 text-[12px] font-semibold text-slate-400">{{ $posts->total() }}</span></button>
                <button type="button" class="filter-tab shrink-0 py-5 text-sm font-semibold" data-status-filter="published" aria-pressed="false">Опубликованные</button>
                <button type="button" class="filter-tab shrink-0 py-5 text-sm font-semibold" data-status-filter="draft" aria-pressed="false">Черновики</button>
            </div>
            <span class="hidden items-center gap-1.5 text-[13px] text-slate-400 xl:inline-flex"><span class="size-1 rounded-full bg-slate-300"></span>Фильтры на текущей странице</span>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-5 sm:px-6">
            <div class="relative min-w-0 flex-1 basis-full sm:max-w-[330px] sm:basis-auto">
                <x-admin.icon name="search" class="pointer-events-none absolute top-3 left-3.5 text-slate-400" width="17" height="17" />
                <input type="search" id="post-search" data-post-search placeholder="Поиск на этой странице…" aria-label="Поиск публикаций на текущей странице" class="h-10 w-full rounded-lg border border-line bg-white pr-10 pl-10 text-sm placeholder:text-slate-400">
                <kbd class="pointer-events-none absolute top-2.5 right-3 rounded border border-line px-1.5 py-0.5 font-mono text-[12px] text-slate-400">/</kbd>
            </div>
            <div class="flex items-center gap-3">
                <span data-selected-toolbar class="inline-flex items-center gap-2 text-[13px] text-brand" hidden>Выбрано: <strong data-selected-count>0</strong><button type="button" data-clear-selection class="rounded p-1 hover:bg-canvas" aria-label="Снять выделение"><x-admin.icon name="x" width="13" height="13" /></button></span>
                <div class="relative"><select data-post-sort aria-label="Сортировка записей на странице" class="h-10 appearance-none rounded-lg border border-line bg-white py-2 pr-9 pl-3 text-[13px] font-semibold text-slate-500"><option value="newest">Сначала новые</option><option value="oldest">Сначала старые</option><option value="title">По названию</option></select><x-admin.icon name="chevron-down" class="pointer-events-none absolute top-3 right-3 text-slate-400" width="14" height="14" /></div>
            </div>
        </div>

        <div class="px-1 sm:px-2">
            <table class="w-full border-collapse text-left">
                <thead><tr class="border-y border-line bg-[#fafbfc] text-[12px] font-semibold tracking-[.08em] text-slate-400 uppercase">
                    <th class="w-11 rounded-tl-md py-3 pl-4 sm:w-12 sm:pl-4"><input type="checkbox" data-select-all aria-label="Выбрать все видимые записи" class="size-3.5 rounded border-slate-300"></th>
                    <th scope="col" class="py-3 pr-3 font-semibold">Публикация</th>
                    <th scope="col" class="hidden w-[145px] px-3 py-3 font-semibold sm:table-cell">Статус</th>
                    <th scope="col" class="hidden w-[125px] px-3 py-3 font-semibold xl:table-cell">Обновлено</th>
                    <th scope="col" class="w-[84px] rounded-tr-md py-3 pr-4 text-right font-semibold"><span class="sr-only">Действия</span></th>
                </tr></thead>
                <tbody data-post-rows>
                    @forelse($posts as $post)
                        @php
                            $tileColors = ['bg-[#edf3ef] text-[#688f78]', 'bg-[#eff0f7] text-[#8585a6]', 'bg-[#faf1e8] text-[#bf9979]', 'bg-[#eaf1f6] text-[#7897ad]'];
                            $tileColor = $tileColors[$post->id % count($tileColors)];
                        @endphp
                        <tr class="post-row border-b border-line last:border-b-0 hover:bg-[#fafcfc]" data-post-row data-title="{{ $post->title }}" data-search="{{ $post->title }} {{ $post->excerpt }}" data-status="{{ $post->is_published ? 'published' : 'draft' }}" data-order="{{ $post->created_at?->timestamp ?? 0 }}">
                            <td class="py-5 pl-4 align-middle"><input type="checkbox" data-row-select aria-label="Выбрать {{ $post->title }}" class="size-3.5 rounded border-slate-300"></td>
                            <td class="py-5 pr-3">
                                <div class="flex items-center gap-4">
                                    <span class="hidden size-[52px] shrink-0 items-center justify-center rounded-lg {{ $tileColor }} md:flex"><svg width="28" height="32" viewBox="0 0 28 32" fill="none" aria-hidden="true"><rect x="3" y="2" width="22" height="28" rx="3" stroke="currentColor" stroke-opacity=".45"/><path d="M8 9h12M8 13h12M8 17h7M8 23h4" stroke="currentColor" stroke-linecap="round" stroke-width="1.5"/></svg></span>
                                    <div class="min-w-0"><a href="{{ route('admin.posts.edit', $post) }}" class="post-title line-clamp-2 font-heading text-ink transition hover:text-brand sm:max-w-[400px]">{{ $post->title }}</a><p class="post-excerpt mt-1 line-clamp-1 max-w-[360px] text-slate-400">{{ $post->excerpt ?: 'Краткое описание пока не добавлено' }}</p><span class="mt-1.5 inline-block text-[12px] font-semibold {{ $post->is_published ? 'text-brand' : 'text-amber-600' }} sm:hidden">{{ $post->is_published ? 'Опубликовано' : 'Черновик' }}</span></div>
                                </div>
                            </td>
                            <td class="hidden px-3 py-5 sm:table-cell"><span @class(['inline-flex items-center gap-1.5 whitespace-nowrap rounded-md px-2 py-1 text-[12px] font-semibold', 'bg-[#ecf6f0] text-[#35704f]' => $post->is_published, 'bg-[#fff6e8] text-[#8f671f]' => !$post->is_published])><span class="size-1 rounded-full bg-current"></span>{{ $post->is_published ? 'Опубликовано' : 'Черновик' }}</span></td>
                            <td class="post-date hidden px-3 py-5 xl:table-cell"><span class="block text-[13px] font-medium text-slate-500">{{ $post->updated_at?->format('d.m.Y') }}</span><span class="mt-1 block text-[12px] text-slate-400">{{ $post->updated_at?->format('H:i') }}</span></td>
                            <td class="pr-3 pl-1 text-right sm:pr-4">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.posts.show', $post) }}" class="hidden rounded-md p-2 text-slate-400 hover:bg-canvas hover:text-brand md:inline-flex" aria-label="Просмотреть {{ $post->title }}" title="Предпросмотр"><x-admin.icon name="eye" width="17" height="17" /></a>
                                    <details class="row-menu relative text-left"><summary class="rounded-md p-2 text-slate-400 hover:bg-canvas" aria-label="Действия с записью {{ $post->id }}"><x-admin.icon name="more" width="18" height="18" /></summary><div class="absolute top-full right-0 z-20 mt-1 w-44 rounded-xl border border-line bg-white p-1.5 shadow-lg shadow-slate-900/5">
                                        <a href="{{ route('admin.posts.edit', $post) }}" class="flex items-center gap-2.5 rounded-lg px-3 py-2.5 text-[13px] text-slate-600 hover:bg-canvas"><x-admin.icon name="edit" width="15" height="15" />Редактировать</a>
                                        <a href="{{ route('admin.posts.show', $post) }}" class="flex items-center gap-2.5 rounded-lg px-3 py-2.5 text-[13px] text-slate-600 hover:bg-canvas"><x-admin.icon name="eye" width="15" height="15" />Предпросмотр</a>
                                        <div class="my-1 h-px bg-line"></div>
                                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" data-delete-form data-post-title="{{ $post->title }}">@csrf @method('DELETE')<button type="submit" class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2.5 text-[13px] text-red-500 hover:bg-red-50"><x-admin.icon name="trash" width="15" height="15" />Удалить</button></form>
                                    </div></details>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-20 text-center"><span class="mx-auto mb-4 flex size-12 items-center justify-center rounded-xl bg-canvas text-slate-400"><x-admin.icon name="file" width="24" height="24" /></span><h2 class="font-heading text-lg font-medium">Первая история впереди</h2><p class="mt-2 text-sm text-slate-400">Создайте публикацию, и она появится здесь.</p><a href="{{ route('admin.posts.create') }}" class="mt-5 inline-flex rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-white">Написать первую запись</a></td></tr>
                    @endforelse
                </tbody>
            </table>
            <div data-search-empty class="px-5 py-16 text-center" hidden><x-admin.icon name="search" class="mx-auto mb-3 text-slate-300" width="30" height="30" /><p class="font-heading text-base font-medium">Ничего не найдено</p><p class="mt-2 text-sm text-slate-400">Попробуйте другое название или измените фильтр.</p><button type="button" data-reset-filters class="mt-4 text-sm font-semibold text-brand">Сбросить фильтры</button></div>
        </div>
        @include('admin.partials.pagination')
    </section>

    <div class="mt-5 flex flex-wrap items-center justify-between gap-3 px-1 text-[13px] text-slate-400"><span>Немного порядка — больше места для идей.</span><span data-filter-result aria-live="polite"></span></div>



@endsection
