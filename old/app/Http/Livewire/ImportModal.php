<?php

namespace App\Http\Livewire;

use Illuminate\View\View;
use LivewireUI\Modal\ModalComponent;

class ImportModal extends ModalComponent
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('livewire.import-modal');
    }
}
