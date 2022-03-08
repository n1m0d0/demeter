<x-template_form>
    <x-slot name='search'>
        <x-jet-input id="search" type="text" class="mt-1 block w-full" wire:model='search' placeholder="Buscar..." />
        <button wire:click='resetSearch' class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Reiniciar
        </button>
    </x-slot>
    <x-slot name='form'>
        <div class="m-2">
            @if ($action == 'create')
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Nuevo Cliente
                </h2>
            @else
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Editar Cliente
                </h2>
            @endif
        </div>
        <div class="m-2">
            <x-jet-label for="name" value="Nombre del Cliente" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model='name' />
            <x-jet-input-error for="name" class="mt-2" />
        </div>
        <div class="m-2">
            <x-jet-label for="telephone" value="telephone" />
            <x-jet-input id="telephone" type="text" class="mt-1 block w-full" wire:model='telephone' />
            <x-jet-input-error for="telephone" class="mt-2" />
        </div>
        <div class="m-2">
            <x-jet-danger-button wire:click="clear">
                Cancelar
            </x-jet-danger-button>
            @if ($action == 'create')
                <x-jet-secondary-button wire:click='store'>
                    Guardar
                </x-jet-secondary-button>
            @else
                <x-jet-secondary-button wire:click='update'>
                    Actualizar
                </x-jet-secondary-button>
            @endif
        </div>
    </x-slot>
    <x-slot name='table'>
        <table class="table w-full text-gray-400 border-separate space-y-6 text-sm">
            <thead class="bg-blue-500 text-white">
                <tr class="uppercase">
                    <th class="p-3 text-left">Cliente</th>
                    <th class="p-3 text-left">Telefono</th>
                    <th class="p-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                    <tr class="bg-blue-200 text-black">
                        <td class="p-3">
                            {{ $client->name }}
                        </td>
                        <td class="p-3 ">
                            {{ $client->telephone }}
                        </td>
                        <td class="p-3 flex gap-1 items-center">
                            <x-tooltip tooltip="Editar">
                                <a wire:click='edit({{ $client->id }})' class="cursor-pointer">
                                    <x-fas-pen-to-square class="w-6 h-6 text-green-500 hover:text-gray-100" />
                                </a>
                            </x-tooltip>
                            <x-tooltip tooltip="Eliminar">
                                <a wire:click='delete({{ $client->id }})' class="cursor-pointer">
                                    <x-fas-trash-can class="w-6 h-6 text-red-500 hover:text-gray-100" />
                                </a>
                            </x-tooltip>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-slot>
    <x-slot name='paginate'>
        {{ $clients->links() }}
    </x-slot>
</x-template_form>
