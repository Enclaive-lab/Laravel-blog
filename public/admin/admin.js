(() => {
    'use strict';

    const find = (selector, root = document) => root.querySelector(selector);
    const all = (selector, root = document) => [...root.querySelectorAll(selector)];
    const toast = find('#admin-toast');
    let toastTimer;

    function notify(message) {
        if (!toast) return;
        clearTimeout(toastTimer);
        toast.textContent = message;
        toast.hidden = false;
        toastTimer = setTimeout(() => { toast.hidden = true; }, 3500);
    }

    const sidebar = find('#admin-sidebar');
    const sidebarButton = find('#sidebar-toggle');
    const overlay = find('#sidebar-overlay');
    const desktop = window.matchMedia('(min-width: 1024px)');
    let menuOpen = false;

    function setMenu(open) {
        menuOpen = open && !desktop.matches;
        sidebar?.classList.toggle('-translate-x-full', !menuOpen);
        if (sidebar) sidebar.inert = !desktop.matches && !menuOpen;
        if (overlay) overlay.hidden = !menuOpen;
        const shell = find('#admin-shell');
        if (shell) shell.inert = menuOpen;
        sidebarButton?.setAttribute('aria-expanded', String(menuOpen));
        document.body.style.overflow = menuOpen ? 'hidden' : '';
        if (menuOpen) find('a', sidebar)?.focus();
    }

    sidebarButton?.addEventListener('click', () => setMenu(!menuOpen));
    find('#sidebar-close')?.addEventListener('click', () => { setMenu(false); sidebarButton?.focus(); });
    overlay?.addEventListener('click', () => { setMenu(false); sidebarButton?.focus(); });
    desktop.addEventListener('change', () => setMenu(false));
    setMenu(false);

    all('[data-open-help]').forEach(button => button.addEventListener('click', () => find('#help-dialog')?.showModal()));
    all('[data-close-dialog]').forEach(button => button.addEventListener('click', () => button.closest('dialog')?.close()));
    all('dialog').forEach(dialog => dialog.addEventListener('click', event => {
        const bounds = dialog.getBoundingClientRect();
        if (event.target === dialog && (event.clientX < bounds.left || event.clientX > bounds.right || event.clientY < bounds.top || event.clientY > bounds.bottom)) dialog.close();
    }));

    let pendingDelete;
    const deleteDialog = find('#delete-dialog');
    all('[data-delete-form]').forEach(form => form.addEventListener('submit', event => {
        event.preventDefault();
        pendingDelete = form;
        find('#delete-post-title').textContent = form.dataset.postTitle;
        deleteDialog.showModal();
    }));
    find('#confirm-delete')?.addEventListener('click', event => {
        if (!pendingDelete) return;
        event.currentTarget.disabled = true;
        HTMLFormElement.prototype.submit.call(pendingDelete);
    });
    deleteDialog?.addEventListener('close', () => { pendingDelete = null; });

    const rowMenus = all('.row-menu');
    rowMenus.forEach(menu => menu.addEventListener('toggle', () => {
        if (menu.open) rowMenus.forEach(other => { if (other !== menu) other.open = false; });
    }));
    document.addEventListener('click', event => {
        if (!event.target.closest('.row-menu')) rowMenus.forEach(menu => { menu.open = false; });
    });

    const postList = find('[data-post-list]');
    if (postList) {
        const rows = all('[data-post-row]', postList);
        const search = find('[data-post-search]', postList);
        const selectAll = find('[data-select-all]', postList);
        const filters = all('[data-status-filter]', postList);
        const selectedToolbar = find('[data-selected-toolbar]', postList);
        const resultLabel = find('[data-filter-result]');
        let status = 'all';

        function updateSelection() {
            const visible = rows.filter(row => !row.hidden);
            const selected = visible.filter(row => find('[data-row-select]', row).checked);
            rows.forEach(row => row.classList.toggle('is-selected', find('[data-row-select]', row).checked));
            selectAll.checked = visible.length > 0 && selected.length === visible.length;
            selectAll.indeterminate = selected.length > 0 && selected.length < visible.length;
            selectAll.disabled = visible.length === 0;
            selectedToolbar.hidden = selected.length === 0;
            find('[data-selected-count]', postList).textContent = selected.length;
        }

        function filterRows() {
            const query = search.value.trim().toLocaleLowerCase('ru');
            let visibleCount = 0;
            rows.forEach(row => {
                const visible = (status === 'all' || row.dataset.status === status) && row.dataset.search.toLocaleLowerCase('ru').includes(query);
                row.hidden = !visible;
                if (visible) visibleCount++;
                else find('[data-row-select]', row).checked = false;
            });
            find('[data-search-empty]', postList).hidden = visibleCount > 0 || rows.length === 0;
            if (resultLabel) resultLabel.textContent = rows.length ? `На странице: ${visibleCount} из ${rows.length}` : '';
            filters.forEach(button => button.setAttribute('aria-pressed', String(button.dataset.statusFilter === status)));
            updateSelection();
        }

        search.addEventListener('input', filterRows);
        filters.forEach(button => button.addEventListener('click', () => { status = button.dataset.statusFilter; filterRows(); }));
        find('[data-reset-filters]', postList)?.addEventListener('click', () => { status = 'all'; search.value = ''; filterRows(); search.focus(); });
        selectAll.addEventListener('change', () => { rows.filter(row => !row.hidden).forEach(row => { find('[data-row-select]', row).checked = selectAll.checked; }); updateSelection(); });
        all('[data-row-select]', postList).forEach(input => input.addEventListener('change', updateSelection));
        find('[data-clear-selection]', postList)?.addEventListener('click', () => { rows.forEach(row => { find('[data-row-select]', row).checked = false; }); updateSelection(); });

        find('[data-post-sort]', postList)?.addEventListener('change', event => {
            const mode = event.target.value;
            const sorted = [...rows].sort((left, right) => mode === 'title'
                ? left.dataset.title.localeCompare(right.dataset.title, 'ru')
                : (Number(left.dataset.order) - Number(right.dataset.order)) * (mode === 'oldest' ? 1 : -1));
            const container = find('[data-post-rows]', postList);
            sorted.forEach(row => container.appendChild(row));
        });
        filterRows();
    }

    const editor = find('[data-editor-form]');
    if (editor) {
        const title = find('[data-editor-title]', editor);
        const excerpt = find('[data-editor-excerpt]', editor);
        const body = find('[data-editor-body]', editor);
        const slug = find('[data-editor-slug]', editor);
        const published = find('[data-editor-published]', editor);
        const tabs = all('[data-editor-tab]', editor);
        let slugEdited = slug.value.trim() !== '' || editor.dataset.editorMode === 'edit';

        const cyrillic = { а:'a', б:'b', в:'v', г:'g', д:'d', е:'e', ё:'e', ж:'zh', з:'z', и:'i', й:'y', к:'k', л:'l', м:'m', н:'n', о:'o', п:'p', р:'r', с:'s', т:'t', у:'u', ф:'f', х:'h', ц:'ts', ч:'ch', ш:'sh', щ:'sch', ъ:'', ы:'y', ь:'', э:'e', ю:'yu', я:'ya' };
        const slugify = value => value.toLowerCase().replace(/[а-яё]/g, letter => cyrillic[letter]).normalize('NFKD').replace(/[\u0300-\u036f]/g, '').replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');

        function updateEditor() {
            const words = body.value.trim() ? body.value.trim().split(/\s+/u).length : 0;
            find('[data-excerpt-count]', editor).textContent = excerpt.value.length;
            find('[data-word-count]', editor).textContent = words;
            find('[data-read-time]', editor).textContent = Math.max(1, Math.ceil(words / 180));
            find('[data-preview-title]', editor).textContent = title.value.trim() || 'Название публикации';
            find('[data-preview-excerpt]', editor).textContent = excerpt.value;
            find('[data-preview-body]', editor).textContent = body.value || 'Добавьте текст в редакторе — он появится здесь.';
            for (const [key, field, min] of [['title', title, 3], ['excerpt', excerpt, 10], ['body', body, 10]]) {
                find(`[data-checklist="${key}"]`, editor).dataset.complete = String(field.value.trim().length >= min);
            }
        }

        function setEditorTab(mode) {
            tabs.forEach(button => {
                const active = button.dataset.editorTab === mode;
                button.setAttribute('aria-selected', String(active));
                button.tabIndex = active ? 0 : -1;
            });
            find('#editor-write-panel').hidden = mode !== 'write';
            find('#editor-preview-panel').hidden = mode !== 'preview';
            updateEditor();
        }

        tabs.forEach(button => {
            button.addEventListener('click', () => setEditorTab(button.dataset.editorTab));
            button.addEventListener('keydown', event => {
                if (!['ArrowLeft', 'ArrowRight', 'Home', 'End'].includes(event.key)) return;
                event.preventDefault();
                const next = event.key === 'Home' ? tabs[0] : event.key === 'End' ? tabs[tabs.length - 1] : tabs[(tabs.indexOf(button) + 1) % tabs.length];
                setEditorTab(next.dataset.editorTab);
                next.focus();
            });
        });
        find('[data-editor-preview-button]', editor)?.addEventListener('click', () => { setEditorTab('preview'); find('#editor-content').scrollIntoView({ behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'instant' : 'smooth', block: 'start' }); });
        editor.addEventListener('invalid', () => setEditorTab('write'), true);

        title.addEventListener('input', () => { if (!slugEdited) slug.value = slugify(title.value); updateEditor(); });
        slug.addEventListener('input', () => { slugEdited = true; });
        excerpt.addEventListener('input', updateEditor);
        body.addEventListener('input', updateEditor);
        const updateStatus = () => { find('[data-editor-status-label]', editor).textContent = published.checked ? 'Опубликовано' : 'Черновик'; };
        published.addEventListener('change', updateStatus);

        all('[data-format]', editor).forEach(button => button.addEventListener('click', () => {
            const start = body.selectionStart;
            const end = body.selectionEnd;
            const selected = body.value.slice(start, end) || 'текст';
            const patterns = { heading: ['\n## ', '\n'], bold: ['**', '**'], italic: ['*', '*'], link: ['[', '](https://)'], list: ['\n- ', '\n'], quote: ['\n> ', '\n'] };
            const [before, after] = patterns[button.dataset.format];
            body.setRangeText(before + selected + after, start, end, 'end');
            body.focus();
            body.setSelectionRange(start + before.length, start + before.length + selected.length);
            body.dispatchEvent(new Event('input', { bubbles: true }));
        }));
        updateStatus();
        updateEditor();
    }

    all('[data-copy-url]').forEach(button => button.addEventListener('click', async () => {
        try {
            if (!navigator.clipboard) throw new Error('Clipboard unavailable');
            await navigator.clipboard.writeText(button.dataset.copyUrl);
            notify('Ссылка скопирована');
        } catch {
            notify('Не удалось скопировать. Ссылку можно взять из адресной строки.');
        }
    }));

    document.addEventListener('keydown', event => {
        const typing = event.target.closest('input, textarea, select, [contenteditable="true"]');
        if (event.key === '/' && !typing && !find('dialog[open]')) {
            const search = find('[data-post-search]');
            if (search) { event.preventDefault(); search.focus(); }
        }
        if (event.key === 'Escape' && menuOpen) { setMenu(false); sidebarButton?.focus(); }
        if (event.key === 'Tab' && menuOpen) {
            const focusable = all('a[href], button:not(:disabled)', sidebar);
            const first = focusable[0];
            const last = focusable[focusable.length - 1];
            if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
            else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
        }
    });
})();
