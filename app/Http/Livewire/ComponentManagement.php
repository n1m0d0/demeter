<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Way;
use App\Models\Order;
use App\Models\Detail;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Personalization;
use Illuminate\Database\Eloquent\Builder;

class ComponentManagement extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $action;
    public $step;
    public $search;
    public $searchProduct;
    public $beginning;
    public $finish;
    public $iteration;

    public $order_id;

    public $client_id;
    public $way_id;
    public $delivery;
    public $received_by;
    public $address;
    public $advance;
    public $nameClient;
    public $telephoneClient;
    public $deliveryOld;

    public $product_id;
    public $price;
    public $amount;
    public $nameProduct;

    public $description;
    public $image;
    public $detail_id;
    
    public $personalization = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->action = 'list';
        $this->search = '';
        $this->searchProduct = '';
        $this->step = 1;
        $this->iteration = rand(0, 999);
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

        $QueryProduct = Product::query();
        if ($this->searchProduct != null) {
            $this->updatingSearch();
            $QueryProduct = $QueryProduct->where('name', 'like', '%' . $this->searchProduct . '%');
        }

        $QueryDetail = Detail::query();
        if ($this->order_id != null) {
            $QueryDetail = Detail::where('order_id', $this->order_id);
            $details = $QueryDetail->where('status', Detail::ACTIVO)->orderBy('id', 'DESC')->paginate(5);
        } else {
            $details = null;
        }

        $orders = $Query->where('status', '!=', Order::ENTREGADO)->where('status', '!=', Order::INACTIVO)->paginate(10);
        $ways = Way::where('status', Way::ACTIVO)->orderBy('id', 'DESC')->get();
        $products = $QueryProduct->where('status', Product::ACTIVO)->orderBy('id', 'DESC')->paginate(5);
        return view('livewire.component-management', compact('orders', 'ways', 'products', 'details'));
    }

    public function edit($id)
    {
        $this->clearOrder();

        $this->order_id = $id;

        $order = Order::find($id);

        $this->client_id = $order->client_id;
        $this->way_id = $order->way_id;
        $this->delivery = $order->delivery;
        $this->received_by = $order->received_by;
        $this->address = $order->address;
        $this->advance = $order->advance;
        $this->nameClient = $order->client->name;
        $this->telephoneClient = $order->client->telephone;
        $this->deliveryOld = Carbon::parse($this->delivery)->format('Y-m-d H:i:s');

        $this->action = 'edit';

        $this->resetSearch();
    }

    public function update()
    {
        $this->validate([
            'client_id' => 'required',
            'way_id' => 'required',
            'delivery' => 'required|date',
            'received_by' => 'required'
        ]);

        $order = Order::find($this->order_id);
        $order->client_id = $this->client_id;
        $order->way_id = $this->way_id;
        $order->delivery = $this->delivery;
        $order->received_by = $this->received_by;
        $order->address = $this->address;
        $order->save();

        $this->resetSearch();
        $this->step = 2;
    }

    public function delete($id)
    {
        $order = Order::find($id);
        $order->status = Order::INACTIVO;
        $order->save();

        foreach ($order->details as $detail) {
            $detail->status = Detail::INACTIVO;
            $detail->save();
        }

        $this->resetSearch();
    }

    public function pickProduct($id)
    {
        $this->product_id = $id;
        $product =  Product::find($id);
        $this->nameProduct = $product->name;
        $this->price = $product->price;

        $this->formOrder = true;
        $this->resetSearch();
    }

    public function storeDetail()
    {
        $this->validate([
            'order_id' => 'required',
            'product_id' => 'required',
            'price' => 'required|numeric',
            'amount' => 'required|numeric'
        ]);

        $detail = new Detail();
        $detail->order_id = $this->order_id;
        $detail->product_id = $this->product_id;
        $detail->price = $this->price;
        $detail->amount = $this->amount;
        $detail->save();

        $this->clearDetail();
    }

    public function deleteDetail($id)
    {
        $detail = Detail::find($id);
        $detail->status = Detail::INACTIVO;
        $detail->save();
    }

    public function balance()
    {
        $this->step = 3;
    }

    public function storeAdvance()
    {
        $this->validate([
            'advance' => 'required',
        ]);

        $order = Order::find($this->order_id);
        $order->advance = $this->advance;
        $order->save();

        $this->clearAdvance();
        $this->activeOrder();
    }

    public function storePersonalization()
    {
        if ($this->image != null) {
            $this->validate([
                'description' => 'required',
                'image' => 'required|mimes:jpg,bmp,png|max:5120'
            ]);
            $personalization = new Personalization();
            $personalization->detail_id = $this->detail_id;
            $personalization->description = $this->description;
            $personalization->image = $this->image->store('public');
            $personalization->save();
        } else {
            $this->validate([
                'description' => 'required',
            ]);
            $personalization = new Personalization();
            $personalization->detail_id = $this->detail_id;
            $personalization->description = $this->description;
            $personalization->save();
        }

        $this->clearPersonalization();
        $this->personalization = false;
    }

    public function deletePersonalization($id)
    {
        $detail = Personalization::find($id);
        $detail->status = Personalization::INACTIVO;
        $detail->save();
    }

    public function activeOrder()
    {
        $order = Order::find($this->order_id);
        $order->status = Order::ACTIVO;
        $order->save();

        $this->step = 1;
        $this->action = 'list';
        $this->order_id = null;
        $this->clearDetail();
    }

    public function modal($id)
    {
        $this->clearPersonalization();
        $this->detail_id = $id;
        $this->personalization = true;
    }

    public function clearOrder()
    {
        $this->reset(['nameClient', 'telephoneClient', 'order_id', 'client_id', 'way_id', 'delivery', 'address', 'advance']);
    }

    public function clearDetail()
    {
        $this->reset(['nameProduct', 'price', 'amount', 'product_id']);
        $this->formOrder = false;
    }

    public function clearAdvance()
    {
        $this->reset(['advance']);
        $this->formOrder = false;
    }

    public function clearPersonalization()
    {
        $this->reset(['description', 'image']);
        $this->iteration++;
        $this->personalization = false;
    }

    public function resetSearch()
    {
        $this->reset(['search', 'searchProduct']);
        $this->updatingSearch();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
