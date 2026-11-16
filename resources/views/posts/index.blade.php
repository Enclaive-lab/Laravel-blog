@extends('layouts.app')

@section('title', 'Блог на Laravel 13')

@section('content')

<div class="mb-10">
  
    <p class="mb-3 text-sm font-medium text-brand">
        Личный блог
    </p>

    <h1 class="text-3xl font-semibold tracking-tight sm:text-4xl">
        Заметки о разработке
    </h1>

    <p class="mt-4 max-w-2xl text-base leading-7 text-slate-500">
        Делюсь опытом, разбираюсь в технологиях и сохраняю полезные мысли.
    </p>
</div>

<form action="{{ route('blog.index') }}" method="GET" role="search" class="mb-8 rounded-2xl border border-line bg-white p-4 shadow-sm sm:p-5">
    <label for="blog-search" class="mb-3 block text-sm font-semibold text-ink">Поиск по блогу</label>
    <div class="flex flex-col gap-3 sm:flex-row">
        <div class="relative min-w-0 flex-1">
            <svg class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <circle cx="10.5" cy="10.5" r="6.5" />
                <path stroke-linecap="round" d="m16 16 4 4" />
            </svg>
            <input type="search" id="blog-search" name="q" value="{{ request('q') }}" placeholder="Название или текст публикации" class="w-full rounded-xl border border-line bg-canvas py-3 pr-4 pl-12 text-base text-ink outline-none transition-colors placeholder:text-slate-400 focus:border-brand focus:bg-white focus:ring-2 focus:ring-brand/15">
        </div>
        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-brand px-7 py-3 text-sm font-semibold text-white transition-colors hover:bg-[#095e57]">Найти</button>
        @if(trim((string) request('q', '')) !== '')
            <a href="{{ route('blog.index') }}" class="inline-flex items-center justify-center rounded-xl px-3 py-3 text-sm font-medium text-slate-500 transition-colors hover:bg-canvas hover:text-ink">Сбросить</a>
        @endif
    </div>
</form>

<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
    @forelse ($posts as $post)
    <!-- Первая карточка поста -->
    <article class="group flex flex-col rounded-2xl border border-line bg-white p-6 shadow-sm transition duration-200 hover:border-brand/30 hover:shadow-md sm:p-8">

        <time datetime="2026-10-21"
              class="text-sm font-medium text-slate-500">
           {{ $post->published_at?->format('d.m.Y') }}
        </time>
         

        @if($post->image)
        <div class="w-full rounded">
            <img src="{{ $post->image_url }}" alt="{{ $post->title }}">
        </div>
        @endif

        <h2 class="mt-4 text-xl font-semibold leading-snug tracking-tight sm:text-2xl">
            <a href="#"
               class="transition-colors hover:text-brand">
                {{ $post->title }}
            </a>
        </h2>

        <p class="mt-4 flex-1 text-[15px] leading-7 text-slate-500">
            {{ $post->excerpt }}
        </p>

        <div class="mt-7 border-t border-line pt-5">
            <a href="{{ route('blog.show', $post->slug) }}"
               class="inline-flex items-center gap-2 rounded-lg bg-brand/10 px-4 py-2.5 text-sm font-semibold text-brand transition-colors hover:bg-brand hover:text-white">
                Читать дальше

                <svg class="h-4 w-4"
                     xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     aria-hidden="true">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="1.8"
                          d="M5 12h14m-6-6 6 6-6 6" />
                </svg>
            </a>
        </div>

    </article>
    @empty
        <div class="rounded-2xl border border-line bg-white px-6 py-12 text-center md:col-span-2">
            <h2 class="text-xl font-semibold">{{ trim((string) request('q', '')) !== '' ? 'Ничего не найдено' : 'Публикаций пока нет' }}</h2>
            <p class="mt-3 text-sm leading-6 text-slate-500">{{ trim((string) request('q', '')) !== '' ? 'Попробуйте другое слово или сбросьте поиск.' : 'Новые записи появятся здесь после публикации.' }}</p>
        </div>
    @endforelse
</div>
@if ($posts->hasPages())
{{ $posts->onEachSide(1)->links('components.pagination') }}
  
@endif
@endsection
