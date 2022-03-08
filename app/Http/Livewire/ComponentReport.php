<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Detail;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Database\Eloquent\Builder;

class ComponentReport extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $beginning;
    public $finish;

    protected $queryString = [
        'page' => ['except' => 1]
    ];

    public function mount()
    {
        $this->beginning = null;
        $this->finish = null;
    }

    public function render()
    {
        $Query = Detail::query();
        
        if (($this->beginning != null) && ($this->finish != null)) {
            $this->updatingSearch();
            $Query = $Query->whereHas('order', function (Builder $query) {
                $query->whereBetween('delivery', [$this->beginning, $this->finish]);
            });
        }
        $Query = $Query->whereHas('order', function (Builder $query) {
            $query->where('status', Order::ENTREGADO);
        });
        $details = $Query->where('status', Detail::ACTIVO)->orderBy('id', 'DESC')->paginate(5);
        return view('livewire.component-report', compact('details'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetDate()
    {
        $this->reset(['beginning', 'finish']);
        $this->updatingSearch();
    }
}
