<h3>Reporte del {{ \Carbon\Carbon::now()->toDateTimeString() }}</h3>
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
