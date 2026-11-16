@extends('layouts.app')

@section('title', 'Вход')

@section('content')
<div class="mx-auto max-w-md py-2 sm:py-6">
    <a href="{{ route('blog.index') }}" class="mb-6 inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition-colors hover:text-brand">
        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="m12 5-7 7 7 7M5 12h14" />
        </svg>
        Вернуться в блог
    </a>

    <section class="rounded-2xl border border-line bg-white p-6 shadow-sm sm:p-9" aria-labelledby="login-heading">
        <div class="mb-7">
            <span class="mb-5 inline-flex items-center gap-2 rounded-full bg-brand/10 px-3 py-1.5 text-xs font-semibold text-brand">
                <span class="h-1.5 w-1.5 rounded-full bg-brand" aria-hidden="true"></span>
                Личный кабинет
            </span>
            <h1 id="login-heading" class="text-3xl font-semibold tracking-tight text-ink">Вход в блог</h1>
            <p class="mt-3 text-sm leading-6 text-slate-500">С возвращением. Войдите, чтобы продолжить работу с публикациями.</p>
        </div>

        @if(session('status'))
            <div role="status" class="mb-6 rounded-xl border border-brand/20 bg-brand/5 px-4 py-3 text-sm leading-6 text-brand">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="login-email" class="mb-2 block text-sm font-medium text-ink">Электронная почта</label>
                <input type="email" id="login-email" name="email" value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" maxlength="255" required autofocus
                       aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" @error('email') aria-describedby="login-email-error" @enderror
                       class="block w-full rounded-xl border border-line bg-canvas/60 px-4 py-3 text-base text-ink outline-none transition-colors placeholder:text-slate-400 focus:border-brand focus:bg-white focus:ring-2 focus:ring-brand/15">
                @error('email')
                    <p id="login-email-error" class="mt-2 text-sm leading-5 text-red-600" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="login-password" class="mb-2 block text-sm font-medium text-ink">Пароль</label>
                <input type="password" id="login-password" name="password" placeholder="Введите пароль" autocomplete="current-password" required
                       aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}" @error('password') aria-describedby="login-password-error" @enderror
                       class="block w-full rounded-xl border border-line bg-canvas/60 px-4 py-3 text-base text-ink outline-none transition-colors placeholder:text-slate-400 focus:border-brand focus:bg-white focus:ring-2 focus:ring-brand/15">
                @error('password')
                    <p id="login-password-error" class="mt-2 text-sm leading-5 text-red-600" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <label class="inline-flex cursor-pointer items-center gap-2.5 text-sm text-slate-500">
                <input type="checkbox" name="remember_me" value="1" @checked(old('remember_me')) class="h-4 w-4 rounded accent-brand">
                Запомнить меня
            </label>

            <button type="submit" class="flex min-h-12 w-full items-center justify-center gap-2 rounded-xl bg-brand px-5 py-3 text-sm font-semibold text-white transition-colors hover:bg-[#095e57]">
                Войти
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6" />
                </svg>
            </button>
        </form>

        <p class="mt-7 border-t border-line pt-6 text-center text-sm leading-6 text-slate-500">
            Ещё нет аккаунта?
            <a href="{{ route('register') }}" class="font-semibold text-brand underline-offset-4 hover:underline">Зарегистрироваться</a>
        </p>
    </section>
</div>
@endsection
