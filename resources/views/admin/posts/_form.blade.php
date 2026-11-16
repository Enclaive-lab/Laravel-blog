@php
    $editing = isset($post) && $post->exists;
    $published = (bool) old('is_published', $post->is_published ?? false);
    $dateValue = old('published_at', isset($post) && $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '');
    $fieldClass = 'editor-control w-full rounded-lg border border-line bg-white px-4 py-3 text-sm text-ink placeholder:text-slate-400';
@endphp

<a href="{{ route('admin.posts.index') }}" class="mb-6 inline-flex items-center gap-2 text-[13px] font-semibold text-slate-400 transition hover:text-brand"><x-admin.icon name="arrow-left" width="15" height="15" />Все публикации</a>

<form  enctype="multipart/form-data" action="{{ $editing ? route('admin.posts.update', $post) : route('admin.posts.store') }}" method="POST" data-editor-form data-editor-mode="{{ $editing ? 'edit' : 'create' }}">
    @csrf
    @if($editing) @method('PUT') @endif
    

    <div class="mb-8 flex flex-wrap items-end justify-between gap-5">
        <div><div class="mb-3 flex items-center gap-2 text-[13px] font-semibold tracking-[.1em] text-slate-400 uppercase"><span class="h-px w-5 bg-brand"></span>{{ $editing ? 'Снова за работу' : 'С чистого листа' }}</div><h1 class="font-heading text-[30px] font-semibold tracking-[-1px] sm:text-[34px]">{{ $editing ? 'Редактировать запись' : 'Новая публикация' }}</h1><p class="mt-2 text-sm leading-6 text-slate-500">{{ $editing ? 'У хорошей истории всегда есть пространство для деталей.' : 'Поймайте мысль. Подберите слова. Поделитесь историей.' }}</p></div>
        <div class="flex flex-wrap items-center gap-2.5">
            <button type="button" data-editor-preview-button class="inline-flex items-center gap-2 rounded-lg border border-line bg-white px-4 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-50"><x-admin.icon name="eye" width="16" height="16" />Предпросмотр</button>
            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-brand px-5 py-3 text-sm font-semibold text-white shadow-[0_3px_8px_#0e756d14] hover:bg-[#095e57]"><x-admin.icon name="check" width="16" height="16" />Сохранить запись</button>
        </div>
    </div>

    @if($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm leading-6 text-red-700" role="alert"><p class="font-semibold">Проверьте заполнение полей</p><ul class="mt-1 list-inside list-disc">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif





    <div class="grid items-start gap-6 xl:grid-cols-[minmax(0,1fr)_280px]">
        <div class="min-w-0 space-y-6">
            <section class="rounded-xl border border-line bg-white p-5 sm:p-7" aria-labelledby="post-details-heading">
                <div class="mb-6 flex items-center gap-2.5"><span class="flex size-7 items-center justify-center rounded-md bg-[#edf5f2] text-brand"><x-admin.icon name="file" width="15" height="15" /></span><h2 id="post-details-heading" class="font-heading text-sm font-medium">О чём ваша история?</h2></div>
                  <label for="title" class="mb-2.5 block text-[13px] font-semibold text-slate-600">Заголовок <span class="text-brand">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title', $post->title ?? '') }}" class="{{ $fieldClass }} font-heading !text-lg font-medium" placeholder="Дайте вашей истории название" minlength="3" maxlength="255" required data-editor-title>
                @error('title')<p class="mt-2 text-[13px] text-red-500">{{ $message }}</p>@enderror

            <label for="image" class="mt-5 mb-2.5 block text-[13px] font-semibold text-slate-600">
    Изображение
</label>

<input type="file" id="image" name="image" accept="image/*"
       class="{{ $fieldClass }}">

@error('image')
    <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p>
@enderror

@if(isset($post) && $post->image)
<div class='mt-3'>
    <p class= 'text-sm text-gray-400'>Текущее изображение</p>
    <Img src={{ $post -> image_url }} alt = ></Img>
    <label>
        <input type ='checkbox' name = 'remove_image' value='1';>
        Удалить изображение
    </label>
</div>
@endif


                <div class="mt-5"><label for="slug" class="mb-2.5 block text-[13px] font-semibold text-slate-600">Короткое имя записи <span class="ml-1 font-normal text-slate-400">/ slug</span></label><div class="flex overflow-hidden rounded-lg border border-line focus-within:border-brand"><span class="flex items-center border-r border-line bg-[#fafbfc] px-3.5 font-mono text-sm text-slate-400">/</span><input type="text" id="slug" name="slug" value="{{ old('slug', $post->slug ?? '') }}" class="min-w-0 flex-1 border-0 bg-white px-3 py-3 font-mono text-[13px] outline-none !shadow-none" placeholder="moya-novaya-istoriya" maxlength="255" data-editor-slug></div><p class="mt-2 text-[13px] leading-5 text-slate-400">Латинские буквы и дефисы. Можно оставить предложенный вариант.</p></div>

                <div class="mt-6"><div class="mb-2.5 flex items-center justify-between gap-3"><label for="excerpt" class="text-[13px] font-semibold text-slate-600">Краткое описание <span class="text-brand">*</span></label><span class="text-[13px] text-slate-400"><span data-excerpt-count>0</span> символов</span></div><textarea id="excerpt" name="excerpt" rows="3" class="{{ $fieldClass }} resize-y leading-6" placeholder="Пара предложений, которые помогут читателю открыть именно эту запись." minlength="10" required data-editor-excerpt>{{ old('excerpt', $post->excerpt ?? '') }}</textarea><p class="mt-2 text-[13px] leading-5 text-slate-400">Появится в списке публикаций. Коротко, понятно, по делу.</p>@error('excerpt')<p class="mt-2 text-[13px] text-red-500">{{ $message }}</p>@enderror</div>
            </section>

            <section class="overflow-hidden rounded-xl border border-line bg-white" aria-labelledby="post-body-heading" id="editor-content">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-line px-5 py-4 sm:px-7"><h2 id="post-body-heading" class="font-heading text-sm font-medium">Текст публикации <span class="text-brand">*</span></h2><div class="inline-flex gap-1 rounded-lg bg-canvas p-1" role="tablist" aria-label="Режим редактора"><button type="button" id="editor-write-tab" class="editor-tab rounded-md px-3 py-1.5 text-[13px] font-semibold text-slate-400" data-editor-tab="write" role="tab" aria-selected="true" aria-controls="editor-write-panel">Редактор</button><button type="button" id="editor-preview-tab" class="editor-tab rounded-md px-3 py-1.5 text-[13px] font-semibold text-slate-400" data-editor-tab="preview" role="tab" aria-selected="false" aria-controls="editor-preview-panel" tabindex="-1">Предпросмотр</button></div></div>

                <div id="editor-write-panel" role="tabpanel" aria-labelledby="editor-write-tab">
                    <div class="flex flex-wrap items-center gap-0.5 border-b border-line bg-[#fcfdfd] px-4 py-2 sm:px-6" role="toolbar" aria-label="Разметка текста">
                        @foreach([['heading', 'Заголовок', 'heading'], ['bold', 'Жирный текст', 'bold'], ['italic', 'Курсив', 'italic'], ['link', 'Ссылка', 'link'], ['list', 'Список', 'list'], ['quote', 'Цитата', 'quote']] as [$icon, $label, $command])
                            <button type="button" data-format="{{ $command }}" title="{{ $label }}" aria-label="{{ $label }}" class="rounded-md p-2 text-slate-400 hover:bg-[#edf3f0] hover:text-brand"><x-admin.icon :name="$icon" width="16" height="16" /></button>
                        @endforeach
                        <span class="ml-auto hidden px-2 text-[12px] text-slate-400 sm:block">Markdown-разметка</span>
                    </div>
                    <label for="body" class="sr-only">Текст публикации</label><textarea id="body" name="body" rows="14" minlength="10" required data-editor-body class="editor-body block min-h-[330px] w-full resize-y border-0 bg-white px-5 py-6 text-slate-600 outline-none !shadow-none placeholder:text-slate-300 sm:px-7" placeholder="Здесь начинается ваша история…">{{ old('body', $post->body ?? '') }}</textarea>
                </div>

                <div id="editor-preview-panel" class="min-h-[376px] px-5 py-7 sm:px-7" role="tabpanel" aria-labelledby="editor-preview-tab" hidden><p class="mb-5 text-[12px] font-semibold tracking-[.1em] text-brand uppercase">Предпросмотр текста</p><h3 data-preview-title class="mb-4 font-heading text-2xl font-semibold leading-snug tracking-tight">Название публикации</h3><p data-preview-excerpt class="mb-6 text-sm leading-7 text-slate-500"></p><div data-preview-body class="whitespace-pre-wrap text-[15px] leading-8 text-slate-600">Добавьте текст в редакторе — он появится здесь.</div><p class="mt-8 border-t border-line pt-4 text-[13px] leading-5 text-slate-400">Быстрая проверка содержания. Разметка показана как текст.</p></div>
                <div class="flex flex-wrap items-center justify-between gap-3 border-t border-line px-5 py-3 text-[13px] text-slate-400 sm:px-7"><span><span data-word-count>0</span> слов <span class="mx-2 text-slate-300">·</span><span data-read-time>1</span> мин чтения</span><span>Пишите в своём ритме</span></div>
                @error('body')<p class="px-7 py-3 text-[13px] text-red-500">{{ $message }}</p>@enderror
            </section>

            <div class="flex items-center justify-between px-1"><a href="{{ route('admin.posts.index') }}" class="text-sm font-semibold text-slate-400 hover:text-ink">Отменить изменения</a><button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-brand px-5 py-3 text-sm font-semibold text-white hover:bg-[#095e57]"><x-admin.icon name="check" width="16" height="16" />Сохранить запись</button></div>
        </div>

        <aside class="space-y-5 xl:sticky xl:top-6" aria-label="Параметры публикации">
            <section class="rounded-xl border border-line bg-white p-5">
                <div class="mb-5 flex items-center justify-between"><h2 class="font-heading text-sm font-medium">Публикация</h2><span data-editor-status-label class="rounded-md bg-canvas px-2 py-1 text-[12px] font-semibold text-slate-500">{{ $published ? 'Опубликовано' : 'Черновик' }}</span></div>
                <div class="flex items-center justify-between gap-3"><div><label for="is_published" class="text-[13px] font-semibold text-slate-600">Показывать в блоге</label><p class="mt-1 text-[13px] text-slate-400">Запись доступна читателям</p></div><label class="relative inline-flex shrink-0 cursor-pointer items-center"><input type="hidden" name="is_published" value="0"><input type="checkbox" id="is_published" name="is_published" value="1" @checked($published) class="switch-input peer sr-only" data-editor-published><span class="switch-track block h-6 w-[42px] rounded-full bg-slate-200 peer-focus-visible:ring-2 peer-focus-visible:ring-brand peer-focus-visible:ring-offset-4"><span class="mt-[3px] ml-[3px] block size-[18px] rounded-full bg-white shadow-sm"></span></span></label></div>
                <div class="my-5 h-px bg-line"></div>
                <label for="published_at" class="mb-2.5 flex items-center gap-2 text-[13px] font-semibold text-slate-600"><x-admin.icon name="calendar" width="14" height="14" />Дата публикации</label><input type="datetime-local" id="published_at" name="published_at" value="{{ $dateValue }}" class="{{ $fieldClass }} !px-3 text-[13px]" data-editor-date><p class="mt-3 text-[13px] leading-5 text-slate-400">Проверьте дату перед сохранением. Статус публикации задаётся переключателем выше.</p>
                @if($editing)<div class="mt-5 border-t border-line pt-4 text-[13px] text-slate-400">Создано {{ $post->created_at?->format('d.m.Y') }}<span class="float-right font-mono">#{{ str_pad($post->id, 3, '0', STR_PAD_LEFT) }}</span></div>@endif
            </section>

            <section class="rounded-xl border border-line bg-white p-5"><h2 class="mb-5 font-heading text-sm font-medium">Перед публикацией</h2><div class="space-y-4">
                @foreach([['title', 'Есть заголовок'], ['excerpt', 'Добавлено описание'], ['body', 'История написана']] as [$key, $label])
                    <div class="checklist-item flex items-center gap-2.5 text-[13px] text-slate-500" data-checklist="{{ $key }}" data-complete="false"><span class="checklist-dot flex size-[18px] items-center justify-center rounded-full bg-canvas text-slate-300"><x-admin.icon name="check" width="11" height="11" class="opacity-0" /></span>{{ $label }}</div>
                @endforeach
            </div></section>

            <div class="rounded-xl bg-[#edf3f5] px-5 py-5"><x-admin.icon name="quote" class="mb-3 text-[#93a9af]" width="18" height="18" /><p class="font-heading text-[15px] font-medium leading-6 text-[#5b7781]">Пишите так, будто рассказываете другу.</p><p class="mt-2 text-[13px] leading-5 text-[#5b737d]">Простой язык помогает вашим идеям быть услышанными.</p></div>
        </aside>
    </div>
</form>
