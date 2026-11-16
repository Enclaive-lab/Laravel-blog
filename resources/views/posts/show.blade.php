@extends('layouts.app')

@section('title', 'Блог на Laravel 13')

@section('content')
 <div class="mx-auto max-w-3xl">
    <div class="rounded-2xl border border-line bg-white p-6 shadow-sm sm:p-10">

        <div class="mb-8">
            <a href="{{ route('blog.index') }}"
               class="inline-flex items-center gap-2 rounded-lg border border-line px-4 py-2 text-sm text-slate-500 hover:border-brand hover:text-brand">
                ← Ко всем постам
            </a>
        </div>

        <article>
            <p class="mb-4 text-sm text-slate-500">
                Опубликовано: {{ optional($post->published_at ?? $post->created_at)->format('d.m.Y')}}
            </p>
       @if($post->image)
        <div class="w-full rounded">
            <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full rounded">
        </div>
        @endif
            <h1 class="mb-6 break-words text-3xl font-semibold leading-tight tracking-tight text-ink sm:text-4xl">
                {{ $post->title }}
            </h1>

            <div class="break-words text-base leading-8 text-slate-600 sm:text-[17px]">
                {!! $post->body !!}
            </div>
        </article>

    </div>
</div>
@endsection
