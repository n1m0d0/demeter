<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;

class OrderExport implements FromView, WithTitle
{
    use Exportable;
    private $orderQuery;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($orderQuery)
    {
        $this->orderQuery = $orderQuery;
    }

    public function view(): View
    {
        return view('exports.order', [
            'details' => $this->orderQuery
        ]);
    }
    
    public function title(): string
    {
        return 'Pedidos';
    }
}
