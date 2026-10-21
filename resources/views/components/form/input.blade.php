@props([
    'label' => '',
    'type' => 'text',
    'name' => '',
    'placeholder' => '',
    'value' => null
])

@php
    $inputValue = $value ?? old($name ?? '');
@endphp

<div class="flex flex-col">
    @if($label)
        <label for="{{ $name }}" class="text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
    @endif
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ $inputValue }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300']) }}
    >
</div>
