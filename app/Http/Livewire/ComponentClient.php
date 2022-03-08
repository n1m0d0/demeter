<?php

namespace App\Http\Livewire;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;

class ComponentClient extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $action;
    public $iteration;
    public $search;

    public $name;
    public $telephone;
    public $client_id;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->action = 'create';
        $this->iteration = rand(0, 999);
        $this->search = '';
    }

    public function render()
    {
        $Query = Client::query();
        if ($this->search != null) {
            $this->updatingSearch();
            $Query = $Query->where('name', 'like', '%' . $this->search . '%');
        }
        $clients = $Query->where('status', Client::ACTIVO)->orderBy('id', 'DESC')->paginate(5);
        return view('livewire.component-client', compact('clients'));
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'telephone' => 'required|unique:clients'
        ]);

        $client = new Client();
        $client->name = $this->name;
        $client->telephone = $this->telephone;
        $client->save();

        $this->clear();
    }

    public function edit($id)
    {
        $this->clear();
        
        $this->client_id = $id;
        $client = Client::find($id);
        $this->name = $client->name;
        $this->telephone = $client->telephone;

        $this->action = "edit";
    }

    public function update()
    {
        $client = Client::find($this->client_id);

        $this->validate([
            'name' => 'required',
            'telephone' => ['required', Rule::unique('clients')->ignore($this->client_id)]
        ]);

        $client->name = $this->name;        
        $client->telephone = $this->telephone;
        $client->save();

        $this->action = "create";
        $this->clear();
    }

    public function delete($id)
    {
        $client = Client::find($id);
        $client->status = Client::INACTIVO;
        $client->save();

        $this->clear();
    }

    public function clear()
    {
        $this->reset(['name', 'telephone']);
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
