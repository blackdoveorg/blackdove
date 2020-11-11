<?php

namespace App\Http\Livewire\Perch;

use App\Models\Perch;
use Livewire\Component;

class Show extends Component
{
    protected $listeners = ['saved'];

    public function render()
    {
        $item = Perch::all();
        return view('livewire.perch.show', [ 'perch' => $item ]);
    }

    public function saved()
    {
        $this->render();
    }
}
