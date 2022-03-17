<div>
    <x-template_order>
        <x-slot name='step'>
            <x-step step="{{ $step }}" />
        </x-slot>
        <x-slot name='body1'>
            @if ($step == 1)
                <div class="flex gap-2">
                    <x-jet-input id="searchClient" type="text" class="mt-1 block w-full" wire:model='searchClient'
                        placeholder="Buscar..." />
                    <button wire:click='resetSearch'
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Reiniciar
                    </button>
                </div>
                <div class="overflow-x-auto">
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
                                        <x-tooltip tooltip="Elegir">
                                            <a wire:click='pickClient({{ $client->id }})' class="cursor-pointer">
                                                <x-fas-plus class="w-6 h-6 text-green-500 hover:text-gray-100" />
                                            </a>
                                        </x-tooltip>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $clients->links() }}
            @endif
            @if ($step == 2)
                <div class="flex gap-2">
                    <x-jet-input id="searchProduct" type="text" class="mt-1 block w-full" wire:model='searchProduct'
                        placeholder="Buscar..." />
                    <button wire:click='resetSearch'
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Reiniciar
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="table w-full text-gray-400 border-separate space-y-6 text-sm">
                        <thead class="bg-blue-500 text-white">
                            <tr class="uppercase">
                                <th class="p-3 text-left">Imagen</th>
                                <th class="p-3 text-left">Producto</th>
                                <th class="p-3 text-left">Precio</th>
                                <th class="p-3 text-left">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr class="bg-blue-200 text-black">
                                    <td class="p-3">
                                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                            class="rounded-full h-10 w-10 object-cover">
                                    </td>
                                    <td class="p-3 ">
                                        {{ $product->name }}
                                    </td>
                                    <td class="p-3 ">
                                        {{ $product->price }}
                                    </td>
                                    <td class="p-3 flex gap-1 items-center">
                                        <x-tooltip tooltip="Elegir">
                                            <a wire:click='pickProduct({{ $product->id }})' class="cursor-pointer">
                                                <x-fas-plus class="w-6 h-6 text-green-500 hover:text-gray-100" />
                                            </a>
                                        </x-tooltip>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $products->links() }}
            @endif
            @if ($step == 3)
                <div class="p-6">
                    @php
                        $suma = 0;
                    @endphp
                    @foreach ($details as $detail)
                        @php
                            $suma += $detail->price * $detail->amount;
                        @endphp
                    @endforeach
                    <div>
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            Total
                        </h2>
                        <h1 class="text-center text-indigo-600 text-4xl">
                            {{ $suma }}
                        </h1>
                    </div>
                </div>
            @endif
        </x-slot>
        <x-slot name='body2'>
            @if ($step == 1)
                @if ($formOrder)
                    <div class="m-2">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            Nuevo Pedido
                        </h2>
                    </div>
                    <div class="m-2">
                        <x-jet-label for="nameClient" value="Nombre del Cliente" />
                        <x-jet-input id="nameClient" type="text" class="mt-1 block w-full" wire:model='nameClient'
                            disabled="true" />
                    </div>
                    <div class="m-2">
                        <x-jet-label for="telephoneClient" value="Telephone" />
                        <x-jet-input id="telephoneClient" type="text" class="mt-1 block w-full"
                            wire:model='telephoneClient' disabled="true" />
                        <x-jet-input-error for="telephone" class="mt-2" />
                    </div>
                    <div class="m-2">
                        <x-jet-label for="way_id" value="Metodo de solicitud" />
                        <select wire:model="way_id"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <option value="">Seleccione un opcion</option>
                            @foreach ($ways as $way)
                                <option value="{{ $way->id }}">{{ $way->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="way_id" class="mt-2" />
                    </div>
                    <div class="m-2">
                        <x-jet-label for="delivery" value="Fecha de Entrega" />
                        <x-jet-input id="delivery" type="datetime-local" class="mt-1 block w-full"
                            wire:model='delivery' />
                        <x-jet-input-error for="delivery" class="mt-2" />
                    </div>
                    <div class="m-2">
                        <x-jet-label for="received_by" value="Entregar a" />
                        <x-jet-input id="received_by" type="text" class="mt-1 block w-full" wire:model='received_by' />
                        <x-jet-input-error for="received_by" class="mt-2" />
                    </div>
                    <div class="m-2">
                        <x-jet-label for="address" value="Ubicacion" />
                        <x-jet-input id="address" type="text" class="mt-1 block w-full" wire:model='address' />
                        <x-jet-input-error for="address" class="mt-2" />
                    </div>
                    <div class="m-2">
                        <x-jet-danger-button wire:click="clearOrder">
                            Cancelar
                        </x-jet-danger-button>
                        <x-jet-secondary-button wire:click='storeOrder'>
                            Guardar
                        </x-jet-secondary-button>
                    </div>
                @endif
            @endif
            @if ($step == 2)
                <div class="m-2">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Pedido Nro. {{ $order_id }}
                    </h2>
                </div>
                <div class="m-2">
                    <x-jet-label for="nameProduct" value="Nombre del Producto" />
                    <x-jet-input id="nameProduct" type="text" class="mt-1 block w-full" wire:model='nameProduct'
                        disabled="true" />
                </div>
                <div class="m-2">
                    <x-jet-label for="price" value="Precio" />
                    <x-jet-input id="price" type="number" class="mt-1 block w-full" step="0.01" wire:model='price' />
                    <x-jet-input-error for="price" class="mt-2" />
                </div>
                <div class="m-2">
                    <x-jet-label for="amount" value="Cantidad" />
                    <x-jet-input id="amount" type="number" class="mt-1 block w-full" wire:model='amount' />
                    <x-jet-input-error for="amount" class="mt-2" />
                </div>
                <div class="m-2">
                    <x-jet-danger-button wire:click="clearDetail">
                        Cancelar
                    </x-jet-danger-button>
                    <x-jet-secondary-button wire:click='storeDetail'>
                        Añadir
                    </x-jet-secondary-button>
                </div>
            @endif
            @if ($step == 3)
                <div class="m-2">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Pedido Nro. {{ $order_id }}
                    </h2>
                </div>
                <div class="m-2">
                    <x-jet-label for="advance" value="Adelanto" />
                    <x-jet-input id="advance" type="number" class="mt-1 block w-full" step="0.01"
                        wire:model='advance' />
                    <x-jet-input-error for="advance" class="mt-2" />
                </div>
                <div class="m-2">
                    <x-jet-danger-button wire:click="clearAdvance">
                        Cancelar
                    </x-jet-danger-button>
                    <x-jet-secondary-button wire:click='storeAdvance'>
                        Guardar
                    </x-jet-secondary-button>
                </div>
            @endif
        </x-slot>
        <x-slot name="body3">
            @if ($step == 2)
                @if ($order_id != null)
                    <div class="overflow-x-auto">
                        <table class="table w-full text-gray-400 border-separate space-y-6 text-sm">
                            <thead class="bg-blue-500 text-white">
                                <tr class="uppercase">
                                    <th class="p-3 text-left">Imagen</th>
                                    <th class="p-3 text-left">Producto</th>
                                    <th class="p-3 text-left">Precio</th>
                                    <th class="p-3 text-left">Cantidad</th>
                                    <th class="p-3 text-left">Personalizacion</th>
                                    <th class="p-3 text-left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($details as $detail)
                                    <tr class="bg-blue-200 text-black">
                                        <td class="p-3">
                                            <img src="{{ Storage::url($detail->product->image) }}"
                                                alt="{{ $detail->product->name }}"
                                                class="rounded-full h-10 w-10 object-cover">
                                        </td>
                                        <td class="p-3 ">
                                            {{ $detail->product->name }}
                                        </td>
                                        <td class="p-3 ">
                                            {{ $detail->price }}
                                        </td>
                                        <td class="p-3 ">
                                            {{ $detail->amount }}
                                        </td>
                                        <td class="p-3 ">
                                            @foreach ($detail->personalizations as $personalization)
                                                @if ($personalization->status == 1)                                                    
                                                <ul>
                                                    <li>
                                                        <div class="flex justify-start items-center mt-2 gap-2">
                                                            {{ $personalization->description }}
                                                            @if ($personalization->image != null)
                                                                <img src="{{ Storage::url($personalization->image) }}"
                                                                    class="rounded-full h-10 w-10 object-cover">
                                                            @endif
                                                            <x-tooltip tooltip="Eliminar">
                                                                <a wire:click='deletePersonalization({{ $personalization->id }})'
                                                                    class="cursor-pointer">
                                                                    <x-fas-trash-can class="w-6 h-6 text-red-500 hover:text-gray-100" />
                                                                </a>
                                                            </x-tooltip>
                                                        </div>
                                                    </li>
                                                </ul>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="p-3 flex gap-1 items-center">
                                            <x-tooltip tooltip="Personalizar">
                                                <a wire:click='modal({{ $detail->id }})' class="cursor-pointer">
                                                    <x-fas-file-image
                                                        class="w-6 h-6 text-green-500 hover:text-gray-100" />
                                                </a>
                                            </x-tooltip>
                                            <x-tooltip tooltip="Eliminar">
                                                <a wire:click='deleteDetail({{ $detail->id }})'
                                                    class="cursor-pointer">
                                                    <x-fas-trash-can class="w-6 h-6 text-red-500 hover:text-gray-100" />
                                                </a>
                                            </x-tooltip>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $details->links() }}
                    <div class="flex justify-end mt-2">
                        <x-jet-secondary-button wire:click='balance'>
                            Siguiente
                        </x-jet-secondary-button>
                    </div>
                @endif
            @endif
            @if ($step == 3)
            @endif
        </x-slot>
    </x-template_order>

    <x-jet-dialog-modal wire:model="personalization">
        <x-slot name="title">
            <div class="flex col-span-6 sm:col-span-4 items-center">
                <x-fas-file-word class="text-red-500 h-6 w-6 mr-2" />
                Personalizacion
            </div>
        </x-slot>

        <x-slot name="content">
            @if ($image)
                <div>
                    Imagen Preview:
                    <img src="{{ $image->temporaryUrl() }}" class="rounded-full h-20 w-20 object-cover">
                </div>
            @endif
            <div class="m-2">
                <x-jet-label for="description" value="Descripcion del Producto" />
                <textarea id="description" wire:model.defer='description'
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                    rows="4"></textarea>
                <x-jet-input-error for="description" class="mt-2" />
            </div>
            <div class="m-2">
                <x-jet-label for="image" value="Image" />
                <x-jet-input id="upload{{ $iteration }}" type="file" accept=".bmp, .png, .jpg"
                    class="mt-1 block w-full" wire:model='image' />
                <x-jet-input-error for="image" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-danger-button wire:click="clearPersonalization" wire:loading.attr="disabled">
                Cerrar
            </x-jet-danger-button>
            <x-jet-secondary-button wire:click='storePersonalization'>
                Guardar
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
