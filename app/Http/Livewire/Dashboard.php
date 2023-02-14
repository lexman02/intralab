<?php

namespace App\Http\Livewire;

use App\Models\Item;
use Illuminate\View\View;
use Livewire\Component;

class Dashboard extends Component
{
//    public Item $items;
    public $editMode = false;

    public $listeners = ['openEditModal'];


    public function openEditModal($item)
    {
        $this->editMode = true;
        $this->emit('openModal', 'edit-app-modal', ['id' => $item['id']]);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        $items = Item::all()->filter(function ($item) {
            return auth()->user()->hasRole(json_decode($item->allowed_roles), 'master-realm');
        });

        return view('livewire.dashboard', [
            'items' => $items,
        ]);
    }
}
