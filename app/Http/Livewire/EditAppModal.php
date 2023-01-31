<?php

namespace App\Http\Livewire;

use App\Models\Item;
use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;

class EditAppModal extends ModalComponent
{
    public Item $item;
    public $name;
    public $description;
    public $url;
    public $icon;
//    public $allowed_roles;

    protected $rules = [
        'name' => 'required|string',
        'description' => 'nullable|string',
        'url' => 'required|url',
        'icon' => 'nullable|string',
    ];

    public function mount($position)
    {
//        $this->item = $item;
        $this->item = Item::find($position);
        $this->fill($this->item);
    }

    /**
     * Validate the input live
     *
     * @param $propertyName
     * @return void
     */
    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function modifyApp()
    {
        $this->validate();

        $this->item->update([
            'name' => $this->name,
            'description' => $this->description,
            'url' => $this->url,
            'icon' => $this->icon,
        ]);

//        $this->emit('refreshDashboard');
        $this->emit('closeModal');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.edit-app-modal');
    }
}
