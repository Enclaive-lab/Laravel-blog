@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<div class="mx-auto max-w-md py-2 sm:py-6">
    <a href="{{ route('blog.index') }}" class="mb-6 inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition-colors hover:text-brand">
        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="m12 5-7 7 7 7M5 12h14" />
        </svg>
        Вернуться в блог
    </a>

    <section class="rounded-2xl border border-line bg-white p-6 shadow-sm sm:p-9" aria-labelledby="register-heading">
        <div class="mb-7">
            <span class="mb-5 inline-flex items-center gap-2 rounded-full bg-brand/10 px-3 py-1.5 text-xs font-semibold text-brand">
                <span class="h-1.5 w-1.5 rounded-full bg-brand" aria-hidden="true"></span>
                Личный кабинет
            </span>
            <h1 id="register-heading" class="text-3xl font-semibold tracking-tight text-ink">Создать аккаунт</h1>
            <p class="mt-3 text-sm leading-6 text-slate-500">Начните свою историю. Укажите имя, почту и придумайте пароль.</p>
        </div>

        <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="register-name" class="mb-2 block text-sm font-medium text-ink">Ваше имя</label>
                <input type="text" id="register-name" name="name" value="{{ old('name') }}" placeholder="Как к вам обращаться?" autocomplete="name" maxlength="255" required autofocus
                       aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}" @error('name') aria-describedby="register-name-error" @enderror
                       class="block w-full rounded-xl border border-line bg-canvas/60 px-4 py-3 text-base text-ink outline-none transition-colors placeholder:text-slate-400 focus:border-brand focus:bg-white focus:ring-2 focus:ring-brand/15">
                @error('name')
                    <p id="register-name-error" class="mt-2 text-sm leading-5 text-red-600" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="register-email" class="mb-2 block text-sm font-medium text-ink">Электронная почта</label>
                <input type="email" id="register-email" name="email" value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" maxlength="255" required
                       aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" @error('email') aria-describedby="register-email-error" @enderror
                       class="block w-full rounded-xl border border-line bg-canvas/60 px-4 py-3 text-base text-ink outline-none transition-colors placeholder:text-slate-400 focus:border-brand focus:bg-white focus:ring-2 focus:ring-brand/15">
                @error('email')
                    <p id="register-email-error" class="mt-2 text-sm leading-5 text-red-600" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="register-password" class="mb-2 block text-sm font-medium text-ink">Пароль</label>
                <input type="password" id="register-password" name="password" placeholder="Придумайте пароль" autocomplete="new-password" minlength="8" required
                       aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}" aria-describedby="register-password-hint @error('password') register-password-error @enderror"
                       class="block w-full rounded-xl border border-line bg-canvas/60 px-4 py-3 text-base text-ink outline-none transition-colors placeholder:text-slate-400 focus:border-brand focus:bg-white focus:ring-2 focus:ring-brand/15">
                <p id="register-password-hint" class="mt-2 text-xs leading-5 text-slate-500">Не менее 8 символов.</p>
                @error('password')
                    <p id="register-password-error" class="mt-2 text-sm leading-5 text-red-600" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="register-password-confirmation" class="mb-2 block text-sm font-medium text-ink">Повторите пароль</label>
                <input type="password" id="register-password-confirmation" name="password_confirmation" placeholder="Введите пароль ещё раз" autocomplete="new-password" minlength="8" required
                       aria-invalid="{{ $errors->has('password_confirmation') ? 'true' : 'false' }}" @error('password_confirmation') aria-describedby="register-password-confirmation-error" @enderror
                       class="block w-full rounded-xl border border-line bg-canvas/60 px-4 py-3 text-base text-ink outline-none transition-colors placeholder:text-slate-400 focus:border-brand focus:bg-white focus:ring-2 focus:ring-brand/15">
                @error('password_confirmation')
                    <p id="register-password-confirmation-error" class="mt-2 text-sm leading-5 text-red-600" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="flex min-h-12 w-full items-center justify-center gap-2 rounded-xl bg-brand px-5 py-3 text-sm font-semibold text-white transition-colors hover:bg-[#095e57]">
                Зарегистрироваться
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6" />
                </svg>
            </button>
        </form>

        <p class="mt-7 border-t border-line pt-6 text-center text-sm leading-6 text-slate-500">
            Уже есть аккаунт?
            <a href="{{ route('login') }}" class="font-semibold text-brand underline-offset-4 hover:underline">Войти</a>
        </p>
    </section>
</div>
@endsection
