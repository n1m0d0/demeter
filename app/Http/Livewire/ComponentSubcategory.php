<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Subcategory;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ComponentSubcategory extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $action;
    public $iteration;
    public $search;

    public $category_id;
    public $name;
    public $image;
    public $imageBefore;
    public $subcategory_id;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'category_id' => 'required',
        'name' => 'required',
        'image' => 'required|mimes:jpg,bmp,png|max:5120'
    ];

    public function mount()
    {
        $this->action = 'create';
        $this->iteration = rand(0, 999);
        $this->search = '';
    }
    public function render()
    {
        $Query = Subcategory::query();
        if ($this->search != null) {
            $this->updatingSearch();
            $Query = $Query->where('name', 'like', '%' . $this->search . '%');
        }
        $subcategories = $Query->where('status', Subcategory::ACTIVO)->orderBy('id', 'DESC')->paginate(5);
        $categories = Category::where('status', Category::ACTIVO)->orderBy('id', 'DESC')->get();
        return view('livewire.component-subcategory', compact('subcategories', 'categories'));
    }

    public function store()
    {
        $this->validate();

        $subcategory = new Subcategory();
        $subcategory->category_id = $this->category_id;
        $subcategory->name = $this->name;
        $subcategory->image = $this->image->store('public');
        $subcategory->save();

        $this->clear();
        $this->alerts('success', 'Subcategoria Registrada Correctamente');
    }

    public function edit($id)
    {
        $this->clear();
        
        $this->subcategory_id = $id;
        $subcategory = Subcategory::find($id);
        $this->category_id = $subcategory->category_id;
        $this->name = $subcategory->name;
        $this->imageBefore = $subcategory->image;

        $this->action = "edit";
    }

    public function update()
    {
        $subcategory = Subcategory::find($this->subcategory_id);

        if ($this->image != null) {
            $this->validate();
            Storage::delete($subcategory->image);
            $subcategory->category_id = $this->category_id;
            $subcategory->name = $this->name;
            $subcategory->image = $this->image->store('public');
            $subcategory->save();
        } else {
            $this->validate([
                'category_id' => 'required',
                'name' => 'required'
            ]);
            $subcategory->category_id = $this->category_id;
            $subcategory->name = $this->name;
            $subcategory->save();
        }

        $this->action = "create";
        $this->clear();
        $this->alerts('info', 'Subcategoria Editada Correctamente');
    }

    public function delete($id)
    {
        $subcategory = Subcategory::find($id);
        $subcategory->status = Subcategory::INACTIVO;
        $subcategory->save();

        foreach($subcategory->products as $product){
            $product->status = Product::INACTIVO;
            $product->save();
        }

        $this->clear();
        $this->alerts('warning', 'Subcategoria Eliminada Correctamente');
    }

    public function clear()
    {
        $this->reset(['category_id', 'name', 'image']);
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
