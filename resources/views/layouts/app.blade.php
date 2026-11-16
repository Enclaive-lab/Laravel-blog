<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0e756d">
    <title>@yield('title', 'Блог') — Laravel Blog</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Golos+Text:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind подключён через CDN: npm и сборка Vite не нужны. -->
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
    <style>
        :root { color-scheme: light; }
        html { scrollbar-gutter: stable; }
        body { font-size: 15px; line-height: 1.6; font-synthesis: none; }
        h1, h2, h3 { text-wrap: balance; }
        ::selection { background: #ccebe2; color: #17443c; }
        :focus-visible { outline: 3px solid #63b9a7; outline-offset: 4px; }
    </style>
</head>
<body class="flex min-h-screen flex-col bg-canvas font-sans text-ink">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:rounded-lg focus:bg-white focus:p-4">Перейти к содержимому</a>

    <header class="border-b border-line bg-white">
        <div class="mx-auto flex min-h-20 max-w-6xl flex-wrap items-center justify-between gap-x-6 gap-y-3 px-5 py-4 sm:px-8">
            <a href="/blog" class="shrink-0 font-heading text-xl font-semibold tracking-tight">Laravel Blog<span class="text-brand">.</span></a>
            <nav aria-label="Основная навигация" class="flex w-full items-center gap-1 text-sm font-medium sm:w-auto sm:gap-2">
                <a href="/blog" class="rounded-lg px-3 py-2 text-slate-500 transition-colors hover:bg-brand/5 hover:text-brand">Посты</a>
                <a href="/login" class="rounded-lg px-3 py-2 text-slate-500 transition-colors hover:bg-brand/5 hover:text-brand">Войти</a>
                <a href="/register" class="rounded-lg bg-brand px-4 py-2.5 font-semibold text-white transition-colors hover:bg-[#095e57]">Регистрация</a>
            </nav>
        </div>
    </header>

    <main id="main-content" class="mx-auto w-full max-w-6xl flex-1 px-5 py-10 sm:px-8 sm:py-12" tabindex="-1">
        <!-- Здесь будет содержимое публичной страницы. -->
        @yield('content')
    </main>

    <footer class="border-t border-line bg-white">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-3 px-5 py-6 text-[13px] text-slate-500 sm:px-8">
            <span class="font-medium text-ink">Laravel Blog</span>
            <span>Место для ваших историй</span>
        </div>
    </footer>
</body>
</html>
