<?php

namespace App\Http\Livewire\Perch;

use App\Models\Perches;
use Livewire\Component;

class Show extends Component
{
    protected $listeners = ['saved' => 'saved'];

    public function render()
    {
        return view('livewire.perch.show');
    }

    public function saved()
    {
        $this->render();
    }
}
