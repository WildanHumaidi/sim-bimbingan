<a
    href="{{ $href }}"
    {{ $attributes->merge(['class' => "inline-flex items-center px-4 py-2 bg-{$color}-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-{$color}-700 active:bg-{$color}-800 focus:outline-none focus:ring-2 focus:ring-{$color}-500 transition"]) }}
>
    {{ $slot }}
</a>
