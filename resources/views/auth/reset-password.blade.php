@extends('layouts.app')

@section('title', 'Новый пароль')

@section('content')
<div class="mx-auto max-w-md py-2 sm:py-6">
    <section class="rounded-2xl border border-line bg-white p-6 shadow-sm sm:p-9" aria-labelledby="reset-password-heading">
        <div class="mb-7">
            <span class="mb-5 inline-flex items-center gap-2 rounded-full bg-brand/10 px-3 py-1.5 text-xs font-semibold text-brand">
                <span class="h-1.5 w-1.5 rounded-full bg-brand" aria-hidden="true"></span>
                Восстановление доступа
            </span>
            <h1 id="reset-password-heading" class="text-3xl font-semibold tracking-tight text-ink">Новый пароль</h1>
            <p class="mt-3 text-sm leading-6 text-slate-500">Придумайте новый пароль и повторите его, чтобы вернуться в аккаунт.</p>
        </div>

        <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            @error('token')
                <p class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm leading-6 text-red-600" role="alert">{{ $message }}</p>
            @enderror

            <div>
                <label for="reset-email" class="mb-2 block text-sm font-medium text-ink">Электронная почта</label>
                <input type="email" id="reset-email" name="email" value="{{ old('email', request('email')) }}" placeholder="you@example.com" autocomplete="email" maxlength="255" required
                       aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" @error('email') aria-describedby="reset-email-error" @enderror
                       class="block w-full rounded-xl border border-line bg-canvas/60 px-4 py-3 text-base text-ink outline-none transition-colors placeholder:text-slate-400 focus:border-brand focus:bg-white focus:ring-2 focus:ring-brand/15">
                @error('email')
                    <p id="reset-email-error" class="mt-2 text-sm leading-5 text-red-600" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="reset-password" class="mb-2 block text-sm font-medium text-ink">Новый пароль</label>
                <input type="password" id="reset-password" name="password" placeholder="Придумайте пароль" autocomplete="new-password" minlength="8" required
                       aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}" aria-describedby="reset-password-hint @error('password') reset-password-error @enderror"
                       class="block w-full rounded-xl border border-line bg-canvas/60 px-4 py-3 text-base text-ink outline-none transition-colors placeholder:text-slate-400 focus:border-brand focus:bg-white focus:ring-2 focus:ring-brand/15">
                <p id="reset-password-hint" class="mt-2 text-xs leading-5 text-slate-500">Не менее 8 символов.</p>
                @error('password')
                    <p id="reset-password-error" class="mt-2 text-sm leading-5 text-red-600" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="reset-password-confirmation" class="mb-2 block text-sm font-medium text-ink">Повторите пароль</label>
                <input type="password" id="reset-password-confirmation" name="password_confirmation" placeholder="Введите пароль ещё раз" autocomplete="new-password" minlength="8" required
                       aria-invalid="{{ $errors->has('password_confirmation') ? 'true' : 'false' }}" @error('password_confirmation') aria-describedby="reset-password-confirmation-error" @enderror
                       class="block w-full rounded-xl border border-line bg-canvas/60 px-4 py-3 text-base text-ink outline-none transition-colors placeholder:text-slate-400 focus:border-brand focus:bg-white focus:ring-2 focus:ring-brand/15">
                @error('password_confirmation')
                    <p id="reset-password-confirmation-error" class="mt-2 text-sm leading-5 text-red-600" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="flex min-h-12 w-full items-center justify-center rounded-xl bg-brand px-5 py-3 text-sm font-semibold text-white transition-colors hover:bg-[#095e57]">
                Сохранить пароль
            </button>
        </form>

        <p class="mt-7 border-t border-line pt-6 text-center text-sm leading-6 text-slate-500">
            <a href="{{ route('login') }}" class="font-semibold text-brand underline-offset-4 hover:underline">Вернуться ко входу</a>
        </p>
    </section>
</div>
@endsection
