<?php

namespace App\Http\Livewire;

use App\Models\Item;
use Illuminate\View\View;
use Livewire\Component;

class Dashboard extends Component
{
//    public Item $items;

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('livewire.dashboard', [
            'items' => Item::all(),
        ]);
    }
}
