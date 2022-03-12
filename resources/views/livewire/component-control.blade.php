<div>
    <div class="p-2 grid grid-cols-1 md:grid-cols-12 gap-4">
        <div class="flex col-span-1 md:col-span-12 items-center gap-2">
            <x-jet-input id="beginning" type="datetime-local" class="mt-1 block w-full" wire:model='beginning' />
            <x-jet-input id="finish" type="datetime-local" class="mt-1 block w-full" wire:model='finish' />
            <x-jet-input id="search" type="text" class="mt-1 block w-full" wire:model='search' placeholder="Buscar..." />
            <button wire:click='resetSearch'
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Reiniciar
            </button>
        </div>
        <div class="col-span-1 md:col-span-12 border-2 p-2">
            <div class="overflow-x-auto">
                <table class="table w-full text-gray-400 border-separate space-y-6 text-sm">
                    <thead class="bg-blue-500 text-white">
                        <tr class="uppercase">
                            <th class="p-3 text-left">Nro</th>
                            <th class="p-3 text-left">Cliente</th>
                            <th class="p-3 text-left">Pedido</th>
                            <th class="p-3 text-left">Personalizacion</th>
                            <th class="p-3 text-left">Total</th>
                            <th class="p-3 text-left">Adelanto</th>
                            <th class="p-3 text-left">Saldo</th>
                            <th class="p-3 text-left">Entrega</th>
                            <th class="p-3 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr class="bg-blue-200 text-black">
                                <td class="p-3 ">
                                    {{ $order->id }}
                                </td>
                                <td class="p-3 ">
                                    {{ $order->client->name }}
                                </td>
                                <td class="p-3 ">
                                    @foreach ($order->details as $detail)
                                        <ul>
                                            <li class="list-disc list-inside">
                                                Producto: {{ $detail->product->name }}
                                                Precio: {{ $detail->price }}
                                                cantidad: {{ $detail->amount }}
                                            </li>
                                        </ul>
                                    @endforeach
                                </td>
                                <td class="p-3 ">
                                    @foreach ($order->details as $detail)
                                        @foreach ($detail->personalizations as $personalization)
                                            <ul>
                                                <li class="list-disc list-inside">
                                                    <div class="flex justify-start items-center mt-2 gap-1">
                                                        {{ $personalization->description }}
                                                        @if ($personalization->image != null)
                                                            <img src="{{ Storage::url($personalization->image) }}"
                                                                class="rounded-full h-10 w-10 object-cover" data-action="zoom">
                                                        @endif
                                                    </div>
                                                </li>
                                            </ul>
                                        @endforeach
                                    @endforeach
                                </td>
                                <td class="p-3 ">
                                    @php
                                        $suma = 0;
                                    @endphp
                                    @foreach ($order->details as $detail)
                                        @php
                                            $suma += $detail->price * $detail->amount;
                                        @endphp
                                    @endforeach
                                    {{ $suma }}
                                </td>
                                <td class="p-3 ">
                                    {{ $order->advance }}
                                </td>
                                <td class="p-3 ">
                                    {{ $suma - $order->advance }}
                                </td>
                                <td class="p-3 ">
                                    {{ $order->delivery }}
                                </td>
                                <td class="p-3 flex gap-1 items-center">
                                    <x-tooltip tooltip="Entregar">
                                        <a wire:click='delivered({{ $order->id }})' class="cursor-pointer">
                                            <x-fas-check-circle class="w-6 h-6 text-green-500 hover:text-gray-100" />
                                        </a>
                                    </x-tooltip>
                                    <x-tooltip tooltip="Eliminar">
                                        <a wire:click='delete({{ $order->id }})' class="cursor-pointer">
                                            <x-fas-trash-can class="w-6 h-6 text-red-500 hover:text-gray-100" />
                                        </a>
                                    </x-tooltip>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
