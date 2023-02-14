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
    public $allowed_roles;

    protected $rules = [
        'name' => 'required|string',
        'description' => 'nullable|string',
        'url' => 'required|url',
        'icon' => 'nullable|string',
        'allowed_roles' => 'nullable|array',
    ];

    public function mount($id)
    {
        $this->item = Item::find($id);
        $this->fill($this->item);
        $this->allowed_roles = [];

        if (isset($this->item->allowed_roles)) {
            $this->allowed_roles = json_decode($this->item->allowed_roles);
        }
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

    public function addRole(): void
    {
        $this->allowed_roles[] = [''];
    }

    public function removeRole(int $index): void
    {
        unset($this->allowed_roles[$index]);
        $this->allowed_roles = array_values($this->allowed_roles);
    }

    public function modifyApp()
    {
        $this->validate();

        $this->item->update([
            'name' => $this->name,
            'description' => $this->description,
            'url' => $this->url,
            'icon' => $this->icon,
            'allowed_roles' => json_encode($this->allowed_roles),
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
