<?php

namespace App\Actions\Fortify;
namespace App\Http\Livewire\Report;

use App\Models\Reports;
use Livewire\Component;

class Show extends Component
{
    protected $listeners = ['saved'];

    public function render()
    {
        return view('livewire.report.show');
    }

    public function saved()
    {
        $this->render();
    }
}
