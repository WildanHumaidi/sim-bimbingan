@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        <strong>Berhasil!</strong> {{ session('success') }}
    </div>
@endif
