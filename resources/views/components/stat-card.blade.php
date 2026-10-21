@props(['label', 'value', 'icon', 'color' => 'text-gray-500'])

<div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-gray-500 text-sm">{{ $label }}</p>
            <h2 class="text-xl font-bold text-gray-900 mt-1">{{ $value }}</h2>
        </div>
        <div class="{{ $color }}">
            {{ $slot }}
        </div>
    </div>
</div>
