@props([
    'variant' => 'primary', // primary, secondary, danger, dll
    'size' => 'md',         // sm, md, lg
])

@php
$base = 'inline-flex items-center rounded-full focus:outline-none transition duration-150 ease-in-out hover:scale-105';
$colors = [
    'primary' => 'bg-indigo-400 hover:bg-indigo-600 text-white',
    'secondary' => 'bg-gray-200 hover:bg-gray-300 text-gray-700',
    'warning' => 'bg-amber-200 hover:bg-amber-300 text-gray-700',
    'danger' => 'bg-red-400 hover:bg-red-500 text-white',
];
$sizes = [
    'sm' => 'text-xs px-3 py-1',
    'md' => 'text-sm px-4 py-2',
    'lg' => 'text-base px-5 py-3',
];
@endphp

<button {{ $attributes->merge([
    'class' => "$base {$colors[$variant]} {$sizes[$size]}"
]) }}>
    {{ $slot }}
</button>

{{-- contoh pemanggilan --}}
{{-- <x-button type="submit" variant="primary" size="sm" class="absolute right-1 top-1 bottom-1">
    Cari
</x-button> --}}
