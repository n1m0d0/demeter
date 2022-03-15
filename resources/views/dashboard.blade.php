<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Entrega
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @livewire('component-control')
            </div>
        </div>
    </div>
    @push('scripts')
        <script type="text/javascript">
            function clickToCopyText(contentToCopy) {
                var textContent = document.getElementById(contentToCopy).innerText;
                navigator.clipboard.writeText(textContent);
            }
        </script>
    @endpush
</x-app-layout>
