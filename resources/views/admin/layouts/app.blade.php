<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0e756d">
    <title>@yield('title', 'Редакция') — Laravel Blog</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Golos+Text:wght@400;500;600;700&display=swap" rel="stylesheet">
    {{-- Tailwind для учебной вёрстки: работает без npm install и сборки Vite. --}}
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Golos Text', 'Segoe UI', sans-serif;
            --font-heading: 'Golos Text', 'Segoe UI', sans-serif;
            --color-brand: #0e756d;
            --color-ink: #172c36;
            --color-canvas: #f5f7f9;
            --color-line: #e7ecf0;
            --color-slate-400: #62717d;
            --color-slate-500: #536370;
            --color-slate-600: #3f515e;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('admin/admin.css') }}">
    @stack('styles')
</head>
<body class="bg-canvas font-sans text-sm text-ink">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[100] focus:rounded-lg focus:bg-white focus:p-4">Перейти к содержимому</a>
    <button type="button" id="sidebar-overlay" class="fixed inset-0 z-40 bg-slate-900/30 backdrop-blur-sm lg:hidden" aria-label="Закрыть меню" hidden></button>

    <aside id="admin-sidebar" class="admin-sidebar fixed inset-y-0 left-0 z-50 flex w-60 -translate-x-full flex-col border-r border-line bg-white lg:translate-x-0" aria-label="Основная навигация">
        <button type="button" id="sidebar-close" class="absolute top-2 right-2 rounded-md p-1.5 text-slate-400 hover:bg-canvas lg:hidden" aria-label="Закрыть меню"><x-admin.icon name="x" width="16" height="16" /></button>
        <a href="{{ route('admin.posts.index') }}" class="flex h-[84px] shrink-0 items-center gap-3 px-7">
            <span class="flex size-10 items-center justify-center rounded-xl bg-brand text-white"><x-admin.icon name="logo" width="25" height="25" /></span>
            <span><span class="block font-heading text-[20px] font-semibold tracking-[-.6px]">Laravel Blog<span class="text-brand">.</span></span><span class="mt-0.5 block text-[13px] font-medium text-slate-400">Редакция блога</span></span>
        </a>

        <div class="px-4 pt-9">
            <p class="mb-3 px-3 text-[13px] font-semibold tracking-[.1em] text-slate-400 uppercase">Управление блогом</p>
            <nav class="space-y-1.5">
                <a href="{{ route('admin.posts.index') }}" @class(['nav-item flex items-center gap-3 rounded-lg px-3 py-3 font-semibold text-slate-500', 'is-active' => !request()->routeIs('admin.posts.create')]) @if(!request()->routeIs('admin.posts.create')) aria-current="page" @endif>
                    <x-admin.icon name="file" /><span>Публикации</span><span class="ml-auto size-1.5 rounded-full bg-current"></span>
                </a>
                <a href="{{ route('admin.posts.create') }}" @class(['nav-item flex items-center gap-3 rounded-lg px-3 py-3 font-semibold text-slate-500', 'is-active' => request()->routeIs('admin.posts.create')]) @if(request()->routeIs('admin.posts.create')) aria-current="page" @endif>
                    <x-admin.icon name="edit" /><span>Новая запись</span>
                </a>
            </nav>
        </div>

        <div class="mx-5 mt-auto mb-6 rounded-xl border border-[#e3eee9] bg-[#f5faf7] p-4">
            <span class="mb-3 inline-flex size-8 items-center justify-center rounded-lg bg-white text-brand"><x-admin.icon name="sparkles" width="17" height="17" /></span>
            <p class="font-heading text-sm font-medium">Есть чем поделиться?</p>
            <p class="mt-2 text-sm leading-5 text-slate-500">Новая история начинается<br>с одной хорошей мысли.</p>
            <a href="{{ route('admin.posts.create') }}" class="mt-4 flex items-center justify-between text-sm font-semibold text-brand">Начать писать <x-admin.icon name="arrow-up-right" width="16" height="16" /></a>
        </div>

        <div class="border-t border-line p-4">
            <button type="button" data-open-help class="nav-item flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-500"><x-admin.icon name="help" width="18" height="18" />Помощь и подсказки</button>
            <div class="mt-3 flex items-center gap-3 rounded-lg bg-canvas p-3">
                <span class="flex size-8 items-center justify-center rounded-full bg-[#e4ebe8] text-[13px] font-bold text-brand">АБ</span>
                <span><span class="block text-sm font-semibold">Автор блога</span><span class="mt-0.5 block text-[13px] text-slate-400">Личное пространство</span></span>
                <span class="ml-auto size-1.5 rounded-full bg-emerald-500" aria-label="Доступно"></span>
            </div>
        </div>
    </aside>

    <div id="admin-shell" class="min-h-screen lg:pl-60">
        <header class="flex h-[84px] items-center justify-between gap-4 border-b border-line bg-white/90 px-5 sm:px-8 xl:px-11">
            <div class="flex min-w-0 items-center gap-3">
                <button type="button" id="sidebar-toggle" class="rounded-lg p-2 text-slate-500 hover:bg-canvas lg:hidden" aria-label="Открыть меню" aria-controls="admin-sidebar" aria-expanded="false"><x-admin.icon name="menu" /></button>
                <nav aria-label="Хлебные крошки" class="flex min-w-0 items-center gap-2.5 text-sm">
                    <x-admin.icon name="grid" class="text-slate-400" width="16" height="16" />
                    <a href="{{ route('admin.posts.index') }}" class="hidden whitespace-nowrap text-slate-400 hover:text-brand sm:inline">Рабочее пространство</a>
                    <span class="hidden text-slate-300 sm:inline">/</span>
                    <span class="truncate font-semibold">@yield('breadcrumb', 'Публикации')</span>
                </nav>
            </div>
            <div class="flex shrink-0 items-center gap-5">
                <span class="hidden text-[13px] text-slate-400 md:block">{{ now()->locale('ru')->translatedFormat('j F, l') }}</span>
                <span class="hidden h-5 w-px bg-line md:block"></span>
                <span class="inline-flex items-center gap-2 rounded-full border border-line px-3 py-1.5 text-[13px] font-semibold text-slate-500"><span class="size-1.5 rounded-full bg-brand"></span>Мой блог</span>
            </div>
        </header>

        <main id="main-content" class="mx-auto max-w-[1450px] px-5 pt-8 pb-12 outline-none sm:px-8 lg:pt-10 xl:px-11" tabindex="-1">
            @if(session('success') || session('succes'))
                <div role="status" class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800"><x-admin.icon name="check" />{{ session('success') ?? session('succes') }}</div>
            @endif

            {{-- Уникальное содержимое каждой страницы админки. --}}
            @yield('content')

            <footer class="mt-10 flex flex-wrap items-center justify-between gap-3 text-[13px] text-slate-400">
                <span>Laravel Blog <span class="mx-1.5 text-slate-300">/</span> Место для ваших историй</span>
                <span>Редакция, {{ now()->year }}</span>
            </footer>
        </main>
    </div>

    <dialog id="delete-dialog" class="fixed inset-0 m-auto w-[calc(100%-2rem)] max-w-md rounded-2xl border-0 bg-white p-7 shadow-xl">
        <span class="mb-5 inline-flex size-11 items-center justify-center rounded-xl bg-red-50 text-red-500"><x-admin.icon name="trash" /></span>
        <h2 class="font-heading text-xl font-semibold">Удалить публикацию?</h2>
        <p class="mt-3 text-sm leading-6 text-slate-500">Запись «<span id="delete-post-title" class="font-medium text-ink"></span>» будет удалена из списка.</p>
        <div class="mt-7 flex justify-end gap-3"><button type="button" data-close-dialog class="rounded-lg border border-line px-4 py-2.5 text-sm font-semibold hover:bg-canvas">Отмена</button><button type="button" id="confirm-delete" class="rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-red-700">Удалить запись</button></div>
    </dialog>

    <dialog id="help-dialog" class="fixed inset-0 m-auto w-[calc(100%-2rem)] max-w-md rounded-2xl border-0 bg-white p-7 shadow-xl">
        <div class="flex items-center justify-between"><h2 class="font-heading text-xl font-semibold">Ваше рабочее пространство</h2><button type="button" data-close-dialog class="rounded-lg p-2 hover:bg-canvas" aria-label="Закрыть подсказки"><x-admin.icon name="x" width="18" height="18" /></button></div>
        <p class="mt-4 text-sm leading-7 text-slate-500">Здесь собраны публикации блога. Создавайте записи, проверяйте их перед публикацией и возвращайтесь к черновикам, когда появится вдохновение.</p>
        <div class="mt-5 flex items-center justify-between rounded-lg bg-canvas p-4 text-sm"><span class="text-slate-500">Найти запись на странице</span><kbd class="rounded border border-line bg-white px-2 py-1 font-mono">/</kbd></div>
    </dialog>

    <div id="admin-toast" class="admin-toast fixed right-5 bottom-5 z-[100] max-w-[calc(100%-2.5rem)] rounded-xl bg-ink px-5 py-3.5 text-sm font-medium text-white shadow-xl" role="status" aria-live="polite" hidden></div>
    <script src="{{ asset('admin/admin.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
