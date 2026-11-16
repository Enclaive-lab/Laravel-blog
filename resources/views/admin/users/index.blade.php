@extends('admin.layouts.app')

@section('title', 'Пользователи')
@section('breadcrumb', 'Пользователи')

@section('content')
    <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="mb-3 flex items-center gap-2 text-[13px] font-semibold tracking-widest text-slate-400 uppercase">
                <span class="h-px w-5 bg-brand" aria-hidden="true"></span>
                Управление блогом
            </p>
            <div class="flex items-center gap-3">
                <h1 class="font-heading text-3xl font-semibold tracking-tight sm:text-4xl">Пользователи</h1>
                <span class="rounded-lg border border-line bg-white px-2.5 py-1 font-mono text-sm text-slate-400">{{ $users->total() }}</span>
            </div>
            <p class="mt-3 text-sm leading-6 text-slate-500">Участники блога и их права доступа.</p>
        </div>
        <a href="{{ route('admin.posts.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-line bg-white px-4 py-2.5 text-sm font-semibold text-slate-500 transition-colors hover:border-brand/30 hover:text-brand">
            <x-admin.icon name="arrow-left" width="16" height="16" />
            К публикациям
        </a>
    </div>

    @if(session('message'))
        <div role="status" class="mb-6 rounded-xl border border-brand/20 bg-brand/5 px-4 py-3 text-sm text-brand">{{ session('message') }}</div>
    @endif

    @if($errors->any())
        <div role="alert" class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-600">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <section class="overflow-hidden rounded-xl border border-line bg-white shadow-sm" aria-labelledby="users-list-heading">
        <div class="border-b border-line px-5 py-5 sm:px-6">
            <h2 id="users-list-heading" class="font-heading text-base font-semibold">Все пользователи</h2>
            <p class="mt-1 text-[13px] leading-5 text-slate-500">При выборе новой роли изменение сохраняется автоматически.</p>
        </div>

        <table class="block w-full text-left sm:table">
            <thead class="hidden border-b border-line bg-canvas/60 text-xs font-semibold tracking-wider text-slate-400 uppercase sm:table-header-group">
                <tr>
                    <th scope="col" class="px-6 py-3 font-semibold">Пользователь</th>
                    <th scope="col" class="hidden px-5 py-3 font-semibold xl:table-cell">Регистрация</th>
                    <th scope="col" class="px-6 py-3 font-semibold">Роль и доступ</th>
                </tr>
            </thead>
            <tbody class="block divide-y divide-line sm:table-row-group">
                @forelse($users as $user)
                    <tr class="block transition-colors hover:bg-canvas/30 sm:table-row">
                        <td class="block px-5 pt-5 pb-3 sm:table-cell sm:px-6 sm:py-5">
                            <div class="flex min-w-0 items-center gap-3">
                                <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-brand/10 font-semibold text-brand" aria-hidden="true">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</span>
                                <div class="min-w-0">
                                    <p class="break-words font-heading text-sm font-semibold text-ink">{{ $user->name }}</p>
                                    <p class="mt-1 break-all text-[13px] text-slate-500">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="hidden whitespace-nowrap px-5 py-5 text-[13px] text-slate-500 xl:table-cell">{{ $user->created_at?->format('d.m.Y') ?? '—' }}</td>
                        <td class="block px-5 pt-0 pb-5 sm:table-cell sm:px-6 sm:py-5">
                            <form action="{{ route('admin.users.update.role', ['userId' => $user->id]) }}" method="POST" class="flex flex-wrap items-center gap-2" data-role-form>
                                @csrf
                                <label for="user-role-{{ $user->id }}" class="sr-only">Роль пользователя {{ $user->name }}</label>
                                <select id="user-role-{{ $user->id }}" name="role" class="change-role min-h-10 min-w-0 flex-1 rounded-lg border border-line bg-white px-3 py-2 text-base text-ink focus:border-brand sm:w-44 sm:flex-none sm:text-sm">
                                    <option value="user" @selected($user->role === \App\Enums\UserRole::USER)>Пользователь</option>
                                    <option value="admin" @selected($user->role === \App\Enums\UserRole::ADMIN)>Администратор</option>
                                </select>
                                <button type="submit" class="min-h-10 rounded-lg bg-brand px-3.5 py-2 text-[13px] font-semibold text-white transition-colors hover:bg-[#095e57]">Сохранить</button>
                                <span data-role-feedback class="w-full text-[13px] leading-5" role="status" aria-live="polite" hidden></span>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr class="block sm:table-row">
                        <td colspan="3" class="block px-6 py-12 text-center sm:table-cell">
                            <p class="font-heading text-base font-semibold">Пользователей пока нет</p>
                            <p class="mt-2 text-sm leading-6 text-slate-500">Зарегистрированные участники появятся здесь.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="border-t border-line px-5 py-4 sm:px-6">
            @if($users->hasPages())
                {{ $users->onEachSide(1)->links('components.pagination') }}
            @else
                <p class="text-[13px] text-slate-400">Всего пользователей: {{ $users->total() }}</p>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-role-form]').forEach(form => {
            const select = form.querySelector('.change-role');
            const button = form.querySelector('button[type="submit"]');
            const feedback = form.querySelector('[data-role-feedback]');
            let savedRole = select.value;
            let pending = false;

            const saveRole = async () => {
                if (pending) return;

                const data = new FormData(form);
                pending = true;
                select.disabled = true;
                button.disabled = true;
                form.setAttribute('aria-busy', 'true');
                feedback.hidden = false;
                feedback.style.color = '#536370';
                feedback.textContent = 'Сохранение…';

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: data,
                        credentials: 'same-origin',
                        headers: { 'Accept': 'application/json' },
                    });
                    const result = await response.json().catch(() => null);

                    if (!response.ok || !result || typeof result.role !== 'string') {
                        throw new Error(result?.errors?.role?.[0] || result?.message || 'Не удалось сохранить роль. Обновите страницу и попробуйте снова.');
                    }

                    savedRole = result.role;
                    select.value = savedRole;
                    feedback.style.color = '#0e756d';
                    feedback.textContent = result.message;
                } catch (error) {
                    select.value = savedRole;
                    feedback.style.color = '#dc2626';
                    feedback.textContent = error.message;
                } finally {
                    pending = false;
                    select.disabled = false;
                    button.disabled = false;
                    form.removeAttribute('aria-busy');
                }
            };

            select.addEventListener('change', saveRole);
            form.addEventListener('submit', event => {
                event.preventDefault();
                saveRole();
            });
        });
    });
</script>
@endpush
