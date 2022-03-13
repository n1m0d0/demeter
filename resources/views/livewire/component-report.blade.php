<div>
    <div class="p-2 grid grid-cols-1 md:grid-cols-12 gap-4">
        <div class="flex col-span-1 md:col-span-12 items-center gap-2">
            <x-jet-input id="beginning" type="datetime-local" class="mt-1 block w-full" wire:model='beginning' />
            <x-jet-input id="finish" type="datetime-local" class="mt-1 block w-full" wire:model='finish' />
            <button wire:click='resetDate' class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Reiniciar
            </button>
            <button wire:click='exportExcel' class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Exportar
            </button>
        </div>
        <div class="col-span-1 md:col-span-12 border-2 p-2">
            <div class="overflow-x-auto">
                <table class="table w-full text-gray-400 border-separate space-y-6 text-sm">
                    <thead class="bg-blue-500 text-white">
                        <tr class="uppercase">
                            <th class="p-3 text-left">Nro de Pedido</th>
                            <th class="p-3 text-left">Producto</th>
                            <th class="p-3 text-left">Precio</th>
                            <th class="p-3 text-left">Cantidad</th>
                            <th class="p-3 text-left">total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($details as $detail)
                            <tr class="bg-blue-200 text-black">
                                <td class="p-3 ">
                                    {{ $detail->order->id }}
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
                                    {{ $detail->price * $detail->amount }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $details->links() }}
        </div>
    </div>
</div>
