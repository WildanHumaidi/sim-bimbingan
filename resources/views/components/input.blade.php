@props(['label' => '', 'type' => 'text', 'placeholder' => '', 'required' => false])

<div>
    <label class="block text-sm text-gray-700 mb-1">{{ $label }} @if($required)<span class="text-red-500">*</span>@endif</label>
    <input type="{{ $type }}" placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500']) }} />
</div>
