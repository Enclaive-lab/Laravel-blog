@props(['name'])
<svg {{ $attributes->merge(['class' => 'shrink-0']) }} width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    @switch($name)
        @case('logo')<path d="M5 5h8a6 6 0 0 1 6 6v8h-8a6 6 0 0 1-6-6Z"/><path d="M9 9h6M9 13h4"/>@break
        @case('grid')<rect x="3" y="3" width="7" height="7" rx="2"/><rect x="14" y="3" width="7" height="7" rx="2"/><rect x="3" y="14" width="7" height="7" rx="2"/><rect x="14" y="14" width="7" height="7" rx="2"/>@break
        @case('file')<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/><path d="M14 2v6h6M8 13h8M8 17h5"/>@break
        @case('plus')<path d="M12 5v14M5 12h14"/>@break
        @case('search')<circle cx="10.5" cy="10.5" r="6.5"/><path d="m16 16 4.5 4.5"/>@break
        @case('chevron-down')<path d="m6 9 6 6 6-6"/>@break
        @case('chevron-left')<path d="m14 6-6 6 6 6"/>@break
        @case('chevron-right')<path d="m10 6 6 6-6 6"/>@break
        @case('arrow-left')<path d="M19 12H5m6-6-6 6 6 6"/>@break
        @case('arrow-up-right')<path d="M7 17 17 7M7 7h10v10"/>@break
        @case('settings')<path d="M4 7h16M4 17h16M8 4v6M16 14v6"/>@break
        @case('help')<circle cx="12" cy="12" r="9"/><path d="M9.5 9a2.5 2.5 0 0 1 5 .5c0 2-2.5 2-2.5 4M12 17h.01"/>@break
        @case('more')<circle cx="5" cy="12" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/>@break
        @case('edit')<path d="m16 3 5 5M4 20l5-1L21 7a2 2 0 0 0-4-4L5 15Z"/>@break
        @case('eye')<path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/>@break
        @case('trash')<path d="M3 6h18M9 6V3h6v3M5 6l1 15h12l1-15M10 10v7M14 10v7"/>@break
        @case('calendar')<rect x="3" y="5" width="18" height="16" rx="3"/><path d="M16 3v4M8 3v4M3 11h18M8 15h2M14 15h2"/>@break
        @case('clock')<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>@break
        @case('check')<path d="m5 12 4 4L19 6"/>@break
        @case('x')<path d="m6 6 12 12M6 18 18 6"/>@break
        @case('menu')<path d="M4 6h16M4 12h16M4 18h16"/>@break
        @case('bold')<path d="M6 4h7a4 4 0 0 1 0 8H6Zm0 8h8a4 4 0 0 1 0 8H6Z"/>@break
        @case('italic')<path d="M10 4h9M5 20h9M15 4 9 20"/>@break
        @case('link')<path d="m10 13 4-4m-6 6-2 2a3.5 3.5 0 0 1-5-5l5-5a3.5 3.5 0 0 1 5 0m2 2 2-2a3.5 3.5 0 0 1 5 5l-5 5a3.5 3.5 0 0 1-5 0"/>@break
        @case('list')<path d="M9 6h12M9 12h12M9 18h12M3 6h.01M3 12h.01M3 18h.01"/>@break
        @case('quote')<path d="M4 12h5v7H2v-7a9 9 0 0 1 7-9M16 12h5v7h-7v-7a9 9 0 0 1 7-9"/>@break
        @case('heading')<path d="M5 4v16M19 4v16M5 12h14"/>@break
        @case('copy')<rect x="8" y="8" width="12" height="13" rx="2"/><path d="M16 8V4a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h4"/>@break
        @case('sparkles')<path d="m12 3 2.5 6.5L21 12l-6.5 2.5L12 21l-2.5-6.5L3 12l6.5-2.5ZM20 2v4M18 4h4"/>@break
        @default<circle cx="12" cy="12" r="8"/>
    @endswitch
</svg>
