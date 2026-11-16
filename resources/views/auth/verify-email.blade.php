@extends('layouts.app')

@section('title', 'Подтверждение почты')

@section('content')
<div class="mx-auto max-w-md py-2 sm:py-6">
    <section class="rounded-2xl border border-line bg-white p-6 shadow-sm sm:p-9" aria-labelledby="verify-email-heading">
        <h1 id="verify-email-heading" class="text-2xl font-semibold tracking-tight text-ink sm:text-3xl">Подтвердите вашу почту</h1>

        <p class="mt-4 text-sm leading-7 text-slate-500">
            Прежде чем продолжить, проверьте свою почту и перейдите по ссылке в письме.
            Если письмо не пришло, его можно отправить ещё раз.
        </p>

        @if(session('message'))
            <div role="status" class="mt-6 rounded-xl border border-brand/20 bg-brand/5 px-4 py-3 text-sm leading-6 text-brand">
                {{ session('message') }}
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}" class="mt-7">
            @csrf
            <button type="submit" class="flex min-h-12 w-full items-center justify-center rounded-xl bg-brand px-5 py-3 text-sm font-semibold text-white transition-colors hover:bg-[#095e57]">
                Отправить письмо повторно
            </button>
        </form>
    </section>
</div>
@endsection
