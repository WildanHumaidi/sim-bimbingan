@props([
    'show' => 'showModal', // nama variabel Alpine untuk mengatur visibilitas
    'maxWidth' => 'max-w-lg', // bisa diubah menjadi max-w-xl, max-w-2xl, dll
    'title' => '', // judul modal
])

<div x-show="{{ $show }}" @click.away="{{ $show }} = false" x-transition
    class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white rounded-xl shadow-2xl w-full {{ $maxWidth }} max-h-[90vh] overflow-y-auto p-6">
        @if ($title)
            <h2 class="text-xl sm:text-2xl font-bold text-center text-gray-800 border-b pb-2">{{ $title }}</h2>
        @endif
        <div class="mt-4">
            {{ $slot }}
        </div>
    </div>
</div>
