@php
    $iconName = $icon ?? 'dzuhur';
    $classes = trim(($class ?? '') . ' prayer-icon');
@endphp

<div class="{{ $classes }}" aria-hidden="true">
    @switch($iconName)
        @case('subuh')
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 18h16" />
                <path d="M6 18a6 6 0 0 1 12 0" />
                <path d="M12 6v4" />
                <path d="M7.5 10 6 8.5" />
                <path d="M16.5 10 18 8.5" />
            </svg>
            @break

        @case('ashar')
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="6.5" />
                <path d="M12 8.5v4l2.75 1.75" />
            </svg>
            @break

        @case('magrib')
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 18h16" />
                <path d="M6 18a6 6 0 0 0 12 0" />
                <path d="M12 6v4" />
                <path d="M7 14.5 5.5 16" />
                <path d="M17 14.5 18.5 16" />
            </svg>
            @break

        @case('isya')
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 4.5A8 8 0 1 0 19.5 16 7 7 0 0 1 18 4.5Z" />
                <path d="m18 7 1 2 2 1-2 1-1 2-1-2-2-1 2-1 1-2Z" />
            </svg>
            @break

        @default
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="4.5" />
                <path d="M12 2.5v3" />
                <path d="M12 18.5v3" />
                <path d="M2.5 12h3" />
                <path d="M18.5 12h3" />
                <path d="m5.75 5.75 2.1 2.1" />
                <path d="m16.15 16.15 2.1 2.1" />
                <path d="m18.25 5.75-2.1 2.1" />
                <path d="m7.85 16.15-2.1 2.1" />
            </svg>
    @endswitch
</div>
