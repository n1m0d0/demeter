<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Detail;
use App\Models\Order;
use App\Models\Personalization;
use App\Models\Product;
use App\Models\Way;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ComponentOrder extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $iteration;
    public $searchClient;
    public $searchProduct;
    public $step;
    public $formOrder = false;
    public $personalization = false;

    public $client_id;
    public $way_id;
    public $delivery;
    public $received_by;
    public $address;
    public $advance;
    public $nameClient;
    public $telephoneClient;

    public $order_id;
    public $product_id;
    public $price;
    public $amount;
    public $nameProduct;

    public $description;
    public $image;
    public $detail_id;

    public function mount()
    {
        $this->searchClient = '';
        $this->searchProduct = '';
        $this->step = 1;
        $this->iteration = rand(0, 999);
    }

    public function render()
    {
        $QueryClient = Client::query();
        if ($this->searchClient != null) {
            $this->updatingSearch();
            $QueryClient = $QueryClient->where('name', 'like', '%' . $this->searchClient . '%');
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

        $clients = $QueryClient->where('status', Client::ACTIVO)->orderBy('id', 'DESC')->paginate(5);
        $ways = Way::where('status', Way::ACTIVO)->orderBy('id', 'DESC')->get();
        $products = $QueryProduct->where('status', Product::ACTIVO)->orderBy('id', 'DESC')->paginate(5);
        return view('livewire.component-order', compact('clients', 'ways', 'products', 'details'));
    }

    public function pickClient($id)
    {
        $this->client_id = $id;
        $client =  Client::find($id);
        $this->nameClient = $client->name;
        $this->telephoneClient = $client->telephone;
        $this->received_by = $client->name;

        $this->formOrder = true;
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

    public function storeOrder()
    {
        $this->validate([
            'client_id' => 'required',
            'way_id' => 'required',
            'delivery' => 'required|date',
            'received_by' => 'required'
        ]);

        $order = new Order();
        $order->client_id = $this->client_id;
        $order->way_id = $this->way_id;
        $order->delivery = $this->delivery;
        $order->received_by = $this->received_by;
        $order->address = $this->address;
        $order->save();

        $this->order_id = $order->id;

        $this->formOrder = false;
        $this->step = 2;
        $this->clearOrder();
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
        $this->order_id = null;
        $this->clearDetail();
        $this->alerts('success', 'Pedido Registrado Correctamente');
    }

    public function modal($id)
    {
        $this->clearPersonalization();
        $this->detail_id = $id;
        $this->personalization = true;
    }

    public function clearOrder()
    {
        $this->reset(['nameClient', 'telephoneClient', 'client_id', 'way_id', 'delivery', 'address']);
        $this->formOrder = false;
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
        $this->reset(['searchClient', 'searchProduct']);
        $this->updatingSearch();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function alerts($typeMessage, $message)
    {
        $this->dispatchBrowserEvent($typeMessage, ['message' => $message]);
    }
}
