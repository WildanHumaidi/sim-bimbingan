<!-- Komponen Select -->
@props(['label' => '', 'name' => '', 'options' => []])
<div class="flex flex-col">
    @if($label)
        <label for="{{ $name }}" class="text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
    @endif
    <select
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $attributes->merge(['class' => 'w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300']) }}
    >
        @foreach ($options as $option)
            <option value="{{ $option }}">{{ $option }}</option>
        @endforeach
    </select>
</div>
