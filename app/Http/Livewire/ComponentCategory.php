<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ComponentCategory extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $action;
    public $iteration;
    public $search;

    public $name;
    public $image;
    public $imageBefore;
    public $category_id;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
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
        $Query = Category::query();
        if ($this->search != null) {
            $this->updatingSearch();
            $Query = $Query->where('name', 'like', '%' . $this->search . '%');
        }
        $categories = $Query->where('status', Category::ACTIVO)->orderBy('id', 'DESC')->paginate(5);
        return view('livewire.component-category', compact('categories'));
    }

    public function store()
    {
        $this->validate();

        $category = new Category();
        $category->name = $this->name;
        $category->image = $this->image->store('public');
        $category->save();

        $this->clear();
    }

    public function edit($id)
    {
        $this->clear();

        $this->category_id = $id;
        $category = Category::find($id);
        $this->name = $category->name;
        $this->imageBefore = $category->image;

        $this->action = "edit";
    }

    public function update()
    {
        $category = Category::find($this->category_id);

        if ($this->image != null) {
            $this->validate();
            Storage::delete($category->image);
            $category->name = $this->name;
            $category->image = $this->image->store('public');
            $category->save();
        } else {
            $this->validate([
                'name' => 'required'
            ]);
            $category->name = $this->name;
            $category->save();
        }

        $this->action = "create";
        $this->clear();
    }

    public function delete($id)
    {
        $category = Category::find($id);
        $category->status = Category::INACTIVO;
        $category->save();

        $this->clear();
    }

    public function clear()
    {
        $this->reset(['name', 'image']);
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
}
