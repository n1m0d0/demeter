<?php

namespace App\Http\Livewire;

use App\Models\Way;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ComponentWay extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $action;
    public $iteration;
    public $search;

    public $name;
    public $way_id;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'name' => 'required|max:200'
    ];

    public function mount()
    {
        $this->action = 'create';
        $this->iteration = rand(0, 999);
        $this->search = '';
    }

    public function render()
    {
        $Query = Way::query();
        if ($this->search != null) {
            $this->updatingSearch();
            $Query = $Query->where('name', 'like', '%' . $this->search . '%');
        }
        $ways = $Query->where('status', Way::ACTIVO)->orderBy('id', 'DESC')->paginate(5);
        return view('livewire.component-way', compact('ways'));
    }

    public function store()
    {
        $this->validate();

        $way = new Way();
        $way->name = $this->name;
        $way->save();

        $this->clear();
        $this->alerts('success', 'Contacto Registrado Correctamente');
    }

    public function edit($id)
    {
        $this->clear();
        
        $this->way_id = $id;
        $way = Way::find($id);
        $this->name = $way->name;

        $this->action = "edit";
    }

    public function update()
    {
        $way = Way::find($this->way_id);

        $this->validate();

        $way->name = $this->name;
        $way->save();

        $this->action = "create";
        $this->clear();
        $this->alerts('info', 'Contacto Editado Correctamente');
    }

    public function delete($id)
    {
        $way = Way::find($id);
        $way->status = Way::INACTIVO;
        $way->save();

        $this->clear();
        $this->alerts('warning', 'Contacto Eliminado Correctamente');
    }

    public function clear()
    {
        $this->reset(['name']);
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
