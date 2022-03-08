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
                    Nueva Subcategoria
                </h2>
            @else
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Editar Subcategoria
                </h2>
            @endif
        </div>
        <div class="flex m-2 gap-2">
            @if ($action == 'create')
                @if ($image)
                    <div>
                        Imagen Preview:
                        <img src="{{ $image->temporaryUrl() }}" class="rounded-full h-20 w-20 object-cover">
                    </div>
                @endif
            @else
                <div>
                    Imagen Anterior
                    <img src="{{ Storage::url($imageBefore) }}" alt="{{ $name }}"
                        class="rounded-full h-20 w-20 object-cover">
                </div>
                <div>
                    @if ($image)
                        Imagen Nueva
                        <img src="{{ $image->temporaryUrl() }}" class="rounded-full h-20 w-20 object-cover">
                    @endif
                </div>

            @endif
        </div>
        <div class="m-2">
            <x-jet-label for="category_id" value="Categoria" />
            <select wire:model="category_id"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                <option value="">Seleccione un opcion</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <x-jet-input-error for="category_id" class="mt-2" />
        </div>
        <div class="m-2">
            <x-jet-label for="name" value="Nombre de la Categoria" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model='name' />
            <x-jet-input-error for="name" class="mt-2" />
        </div>
        <div class="m-2">
            <x-jet-label for="image" value="Image" />
            <x-jet-input id="upload{{ $iteration }}" type="file" class="mt-1 block w-full" accept=".bmp, .png, .jpg"
                wire:model='image' />
            <x-jet-input-error for="image" class="mt-2" />
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
                    <th class="p-3 text-left">Imagen</th>
                    <th class="p-3 text-left">Categoria</th>
                    <th class="p-3 text-left">Subcategoria</th>
                    <th class="p-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subcategories as $subcategory)
                    <tr class="bg-blue-200 text-black">
                        <td class="p-3">
                            <img src="{{ Storage::url($subcategory->image) }}" alt="{{ $subcategory->name }}"
                                class="rounded-full h-10 w-10 object-cover">
                        </td>
                        <td class="p-3 ">
                            {{ $subcategory->category->name }}
                        </td>
                        <td class="p-3 ">
                            {{ $subcategory->name }}
                        </td>
                        <td class="p-3 flex gap-1 items-center">
                            <x-tooltip tooltip="Editar">
                                <a wire:click='edit({{ $subcategory->id }})' class="cursor-pointer">
                                    <x-fas-pen-to-square class="w-6 h-6 text-green-500 hover:text-gray-100" />
                                </a>
                            </x-tooltip>
                            <x-tooltip tooltip="Eliminar">
                                <a wire:click='delete({{ $subcategory->id }})' class="cursor-pointer">
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
        {{ $subcategories->links() }}
    </x-slot>
</x-template_form>
