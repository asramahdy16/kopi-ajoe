@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-4 py-3 text-sm font-medium rounded-lg bg-[#8B5A2B] text-white transition-colors'
            : 'flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-300 hover:bg-[#8B5A2B]/80 hover:text-white transition-colors';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
