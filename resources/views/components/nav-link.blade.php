@props([
    'href' => '#',
    'active' => false,
    'dropdown' => false,
    'items' => [], // untuk isi dropdown
    'label' => $slot,
])

@if ($dropdown)
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open"
            class="flex items-center gap-1 {{ $active ? 'text-yellow-300 underline underline-offset-4' : 'text-white hover:text-yellow-300 hover:underline underline-offset-4' }} transition duration-300 px-3 py-2 text-sm font-medium">
            {{ $label }}
            <svg :class="{ 'rotate-180': open }"
                class="h-4 w-4 transform transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.23 8.29a.75.75 0 01.02-1.08z"
                    clip-rule="evenodd" />
            </svg>
        </button>
        <div x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            @click.away="open = false"
            class="absolute bg-white text-black mt-2 py-2 w-48 rounded shadow-xl z-20 origin-top">
            @foreach ($items as $item)
                <a href="{{ $item['href'] }}" class="block px-4 py-2 hover:bg-gray-100 transition duration-200">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </div>
    </div>
@else
    <a href="{{ $href }}"
        class="{{ $active
            ? 'text-yellow-300 underline hover:underline underline-offset-4'
            : 'text-white hover:underline underline-offset-4' }} transition duration-300 rounded-md px-3 py-2 text-sm font-medium"
        aria-current="{{ $active ? 'page' : false }}">
        {{ $label }}
    </a>
@endif
