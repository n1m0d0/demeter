<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ComponentUser extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $action;
    public $iteration;
    public $search;

    public $name;
    public $email;
    public $password;
    public $role;
    public $user_id;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'name' => 'required|max:200',
        'email' => 'required|unique:users|max:100',
        'password' => 'required|min:8|max:100',
        'role' => 'required'
    ];

    public function mount()
    {
        $this->action = 'create';
        $this->iteration = rand(0, 999);
        $this->search = '';
    }

    public function render()
    {
        $Query = User::query();
        if ($this->search != null) {
            $this->updatingSearch();
            $Query = $Query->where('name', 'like', '%' . $this->search . '%');
        }
        $users = $Query->where('status', User::ACTIVO)->orderBy('id', 'DESC')->paginate(5);
        $roles = DB::table('roles')->where('guard_name', 'web')->get();
        return view('livewire.component-user', compact('users', 'roles'));
    }

    public function store()
    {
        $this->validate();

        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = bcrypt($this->password);
        $user->save();

        $user->assignRole($this->role);

        $this->clear();
        $this->alerts('success', 'Usuario Registrado Correctamente');
    }

    public function edit($id)
    {
        $this->clear();

        $this->user_id = $id;
        $user = User::find($id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->getRoleNames()[0];

        $this->action = "edit";
    }

    public function update()
    {
        $user = User::find($this->user_id);

        if ($this->password != null) {
            $this->validate([
                'name' => 'required|max:200',
                'email' => ['required', 'max:100', Rule::unique('users')->ignore($this->user_id)],
                'password' => 'required|min:8|max:100',
                'role' => 'required'
            ]);

            $user->removeRole($user->getRoleNames()[0]);

            $user->name = $this->name;
            $user->email = $this->email;
            $user->password = bcrypt($this->password);
            $user->save();

            $user->assignRole($this->role);
        } else {
            $this->validate([
                'name' => 'required|max:200',
                'email' => ['required', 'max:100', Rule::unique('users')->ignore($this->user_id)],
                'role' => 'required'
            ]);

            $user->removeRole($user->getRoleNames()[0]);

            $user->name = $this->name;
            $user->email = $this->email;
            $user->save();

            $user->assignRole($this->role);
        }

        $this->action = "create";
        $this->clear();
        $this->alerts('info', 'Usuario Editado Correctamente');
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->status = User::INACTIVO;
        $user->save();

        $this->clear();
        $this->alerts('warning', 'Usuario Eliminado Correctamente');
    }

    public function clear()
    {
        $this->reset(['name', 'email', 'password', 'role']);
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
