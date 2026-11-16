@extends('layouts.app')

@section('title', 'Восстановление пароля')

@section('content')
<div class="mx-auto max-w-md py-2 sm:py-6">
    <section class="rounded-2xl border border-line bg-white p-6 shadow-sm sm:p-9" aria-labelledby="forgot-password-heading">
        <div class="mb-7">
            <span class="mb-5 inline-flex items-center gap-2 rounded-full bg-brand/10 px-3 py-1.5 text-xs font-semibold text-brand">
                <span class="h-1.5 w-1.5 rounded-full bg-brand" aria-hidden="true"></span>
                Восстановление доступа
            </span>
            <h1 id="forgot-password-heading" class="text-3xl font-semibold tracking-tight text-ink">Забыли пароль?</h1>
            <p class="mt-3 text-sm leading-6 text-slate-500">Укажите почту своего аккаунта. Мы отправим ссылку для создания нового пароля.</p>
        </div>

        @if(session('status'))
            <div role="status" class="mb-6 rounded-xl border border-brand/20 bg-brand/5 px-4 py-3 text-sm leading-6 text-brand">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="forgot-email" class="mb-2 block text-sm font-medium text-ink">Электронная почта</label>
                <input type="email" id="forgot-email" name="email" value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" maxlength="255" required autofocus
                       aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" @error('email') aria-describedby="forgot-email-error" @enderror
                       class="block w-full rounded-xl border border-line bg-canvas/60 px-4 py-3 text-base text-ink outline-none transition-colors placeholder:text-slate-400 focus:border-brand focus:bg-white focus:ring-2 focus:ring-brand/15">
                @error('email')
                    <p id="forgot-email-error" class="mt-2 text-sm leading-5 text-red-600" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="flex min-h-12 w-full items-center justify-center rounded-xl bg-brand px-5 py-3 text-sm font-semibold text-white transition-colors hover:bg-[#095e57]">
                Отправить ссылку
            </button>
        </form>

        <p class="mt-7 border-t border-line pt-6 text-center text-sm leading-6 text-slate-500">
            Вспомнили пароль?
            <a href="{{ route('login') }}" class="font-semibold text-brand underline-offset-4 hover:underline">Войти</a>
        </p>
    </section>
</div>
@endsection
