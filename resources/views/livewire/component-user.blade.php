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
                    Nuevo Usuario
                </h2>
            @else
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Editar Usuario
                </h2>
            @endif
        </div>
        <div class="m-2">
            <x-jet-label for="name" value="Nombre Completo" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model='name' />
            <x-jet-input-error for="name" class="mt-2" />
        </div>
        <div class="m-2">
            <x-jet-label for="email" value="Correo" />
            <x-jet-input id="email" type="text" class="mt-1 block w-full" wire:model='email' />
            <x-jet-input-error for="email" class="mt-2" />
        </div>
        <div class="m-2">
            <x-jet-label for="password" value="Password" />
            <x-jet-input id="password" type="password" class="mt-1 block w-full" wire:model='password' />
            <x-jet-input-error for="password" class="mt-2" />
        </div>
        <select wire:model="role"
            class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
            <option value="">Seleccione un opcion</option>
            @foreach ($roles as $rol)
                <option value="{{ $rol->name }}">{{ $rol->name }}</option>
            @endforeach
        </select>
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
                    <th class="p-3 text-left">Nombre</th>
                    <th class="p-3 text-left">Email</th>                    
                    <th class="p-3 text-left">Rol</th>
                    <th class="p-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="bg-blue-200 text-black">
                        <td class="p-3 ">
                            {{ $user->name }}
                        </td>
                        <td class="p-3 ">
                            {{ $user->email }}
                        </td>
                        <td class="p-3 ">
                            {{ $user->getRoleNames()[0] }}
                        </td>
                        <td class="p-3 flex gap-1 items-center">
                            <x-tooltip tooltip="Editar">
                                <a wire:click='edit({{ $user->id }})' class="cursor-pointer">
                                    <x-fas-pen-to-square class="w-6 h-6 text-green-500 hover:text-gray-100" />
                                </a>
                            </x-tooltip>
                            <x-tooltip tooltip="Eliminar">
                                <a wire:click='delete({{ $user->id }})' class="cursor-pointer">
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
        {{ $users->links() }}
    </x-slot>
</x-template_form>
