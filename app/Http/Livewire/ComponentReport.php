<?php

namespace App\Http\Livewire;

use App\Exports\OrderExport;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Detail;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithFileUploads;
use Illuminate\Database\Eloquent\Builder;

class ComponentReport extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $beginning;
    public $finish;
    public $reportOrder;

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
        $this->reportOrder = $Query->where('status', Detail::ACTIVO)->orderBy('id', 'DESC')->get();
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

    public function exportExcel()
    {
        $date = Carbon::now()->toDateTimeString();
        return Excel::download(new OrderExport($this->reportOrder), "Pedidos$date.xlsx");
    }
}
