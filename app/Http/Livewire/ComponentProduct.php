<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\Subcategory;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ComponentProduct extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $action;
    public $iteration;
    public $search;

    public $subcategory_id;
    public $name;
    public $description;
    public $image;
    public $imageBefore;
    public $price;
    public $product_id;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'subcategory_id' => 'required',
        'name' => 'required',
        'description' => 'required',
        'image' => 'required|mimes:jpg,bmp,png|max:5120',
        'price' => 'required|numeric'
    ];

    public function mount()
    {
        $this->action = 'create';
        $this->iteration = rand(0, 999);
        $this->search = '';
    }

    public function render()
    {
        $Query = Product::query();
        if ($this->search != null) {
            $this->updatingSearch();
            $Query = $Query->where('name', 'like', '%' . $this->search . '%');
        }
        $products = $Query->where('status', Product::ACTIVO)->orderBy('id', 'DESC')->paginate(5);
        $subcategories = Subcategory::where('status', Subcategory::ACTIVO)->orderBy('id', 'DESC')->get();
        return view('livewire.component-product', compact('products', 'subcategories'));
    }

    public function store()
    {
        $this->validate();

        $product = new Product();
        $product->subcategory_id = $this->subcategory_id;
        $product->name = $this->name;
        $product->description = $this->description;
        $product->image = $this->image->store('public');
        $product->price = $this->price;
        $product->save();

        $this->clear();
        $this->alerts('success', 'Producto Registrado Correctamente');
    }

    public function edit($id)
    {
        $this->clear();
        
        $this->product_id = $id;
        $product = Product::find($id);
        $this->subcategory_id = $product->subcategory_id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->imageBefore = $product->image;
        $this->price = $product->price;

        $this->action = "edit";
    }

    public function update()
    {
        $product = Product::find($this->product_id);

        if ($this->image != null) {
            $this->validate();
            Storage::delete($product->image);
            $product->subcategory_id = $this->subcategory_id;
            $product->name = $this->name;
            $product->description = $this->description;
            $product->image = $this->image->store('public');
            $product->price = $this->price;
            $product->save();
        } else {
            $this->validate([
                'subcategory_id' => 'required',
                'name' => 'required',
                'description' => 'required',
                'price' => 'required|numeric'
            ]);
            $product->subcategory_id = $this->subcategory_id;
            $product->name = $this->name;
            $product->description = $this->description;
            $product->price = $this->price;
            $product->save();
        }

        $this->action = "create";
        $this->clear();
        $this->alerts('info', 'Producto Editado Correctamente');
    }

    public function delete($id)
    {
        $product = Product::find($id);
        $product->status = Product::INACTIVO;
        $product->save();

        $this->clear();
        $this->alerts('warning', 'Producto Eliminado Correctamente');
    }

    public function clear()
    {
        $this->reset(['subcategory_id' ,'name', 'description', 'image', 'price']);
        $this->iteration++;
        $this->action = "create";
    }

    public function resetSearch()
    {
        $this->reset(['search']);
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
