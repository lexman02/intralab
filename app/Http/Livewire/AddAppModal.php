<?php

namespace App\Http\Livewire;

use App\Models\Item;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Redirector;
use LivewireUI\Modal\ModalComponent;

class AddAppModal extends ModalComponent
{
    public $name;
    public $description;
    public $url;
    public $icon;
    public $allowed_roles = [];

    protected $rules = [
        'name' => 'required|string',
        'description' => 'nullable|string',
        'url' => 'required|url',
        'icon' => 'nullable|string',
        'allowed_roles' => 'nullable|array',
    ];

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

    /**
     * Add the new app to the database and refresh the dashboard
     *
     * @return Redirector|RedirectResponse
     */
    public function addApp(): Redirector|RedirectResponse
    {
        $this->validate();

        Item::create([
            'name' => $this->name,
            'description' => $this->description,
            'url' => $this->url,
            'icon' => $this->icon,
            'allowed_roles' => json_encode($this->allowed_roles),
        ]);

        return redirect()->route('home');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.add-app-modal');
    }
}
