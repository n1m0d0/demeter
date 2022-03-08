<?php

namespace App\Http\Livewire;

use DateTimeZone;
use App\Models\Order;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ComponentCalendar extends Component
{
    public $date;

    public function mount()
    {
        $this->date = Carbon::now(new DateTimeZone('America/La_Paz'))->toDateString();
    }

    public function render()
    {
        $orders = DB::table('orders')
            ->select('orders.id AS title', 'orders.delivery AS start')
            ->where('orders.status', '=', Order::ACTIVO)
            //->where('orders.delivery', '>=', $this->date)
            ->get();

        foreach ($orders as $order) {
            $order->title = "Orden " . $order->title;
            $order->color = "purple";
        }

        return view('livewire.component-calendar', compact('orders'));
    }
}
