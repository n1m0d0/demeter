<?php

namespace App\Http\Livewire;

use App\Models\Detail;
use DateTimeZone;
use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ComponentControl extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search;
    public $beginning;
    public $finish;

    public $message = false;
    public $paragraph;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->search = '';
    }

    public function render()
    {
        $Query = Order::query();
        if ($this->search != null) {
            $this->updatingSearch();
            $Query = Order::whereHas('client', function (Builder $query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        }
        if (($this->beginning != null) && ($this->finish != null)) {
            $this->updatingSearch();
            $Query = $Query->whereBetween('delivery', [$this->beginning, $this->finish]);
        }
        $orders = $Query->where('status', Order::ACTIVO)->paginate(10);
        return view('livewire.component-control', compact('orders'));
    }

    public function delivered($id)
    {
        $order = Order::find($id);
        $order->status = Order::ENTREGADO;
        $order->save();
    }

    public function delete($id)
    {
        $order = Order::find($id);
        $order->status = Order::INACTIVO;
        $order->save();

        foreach($order->details as $detail)
        {
            $detail->status = Detail::INACTIVO;
            $detail->save();
        }
    }

    public function modal($id)
    {
        $order = Order::find($id);
        $this->paragraph = 'Estimado Cliente ' . $order->client->name . ' gracias por realizar su compra en la pasteleria';
        $this->message = true;
    }

    public function resetSearch()
    {
        $this->reset(['search', 'beginning', 'finish']);
        $this->updatingSearch();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
