@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-4 py-3 bg-white/10 text-emerald-400 rounded-xl font-medium shadow-sm ring-1 ring-white/10 transition-all duration-200'
            : 'flex items-center px-4 py-3 text-slate-300 hover:bg-white/5 hover:text-white rounded-xl font-medium transition-all duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
