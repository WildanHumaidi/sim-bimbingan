<div class="overflow-x-auto bg-white rounded-xl shadow-lg border border-gray-200">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
        @isset($head)
            <thead class="bg-indigo-400 text-gray-50 uppercase text-xs font-semibold tracking-wider">
                {{ $head }}
            </thead>
        @endisset

        @isset($body)
            <tbody class="divide-y divide-gray-50">
                {{ $body }}
            </tbody>
        @endisset

        @isset($footer)
            <tfoot class="bg-gray-100 text-gray-600 text-sm font-medium">
                {{ $footer }}
            </tfoot>
        @endisset
    </table>
</div>
