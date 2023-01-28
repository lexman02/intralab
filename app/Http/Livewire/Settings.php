<?php

namespace App\Http\Livewire;

use App\Models\Item;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Settings extends Component
{
    use WithFileUploads;

    public $config;
    public $uploadMethod = 'file';
    public $confirmed = false;

    protected $listeners = ['confirm'];

    public function confirm()
    {
        $this->confirmed = true;
        $this->emit('closeModal');
    }


    /**
     * Prepare application data for export and download as JSON
     * @return StreamedResponse
     */
    public function export(): StreamedResponse
    {
        $filename = 'intralab_config_'.date('Y-m-d').'.json';
        return response()->streamDownload(function () {
            $apps = Item::all()->toArray();
            $config = [];

            // Get config keys and values from sync config file
            foreach (config('sync') as $key => $value) {
                $config[$key] = $value;
            }

            $data = [
                'config' => $config,
                'apps' => $apps,
            ];
            echo json_encode($data);
        }, $filename);
    }

    /**
     * Validate the inputs in real-time
     */
    public function updatedConfig(): void
    {
        $uploadMethod = $this->uploadMethod;
        if ($uploadMethod === 'file') {
            $this->validate([
                'config' => 'required|file|mimes:json',
            ]);
        } elseif ($uploadMethod === 'input') {
            $this->validate([
                'config' => 'required|json',
            ]);
        } else {
            session()->flash('error', 'Invalid upload method');
        }
    }

    /**
     * Import the config file or input
     */
    public function import()
    {
        $data = $this->getData();

        if (session()->has('error')) {
            return;
        }

        if (isset($data['config'])) {
            $this->configImport($data['config']);
        }

        if (isset($data['apps'])) {
            $this->appsImport($data['apps']);
        }

        if ($data === null) {
            session()->flash('error', 'Invalid config file');
        } else {
            redirect('/')->with('success', 'Import successful');
        }
    }

    /**
     * Validate and sanitize the config import data and return it
     * @return mixed
     */
    public function getData(): mixed
    {
        $uploadMethod = $this->uploadMethod;
        $data = null;

        if ($uploadMethod === 'file') {
            $this->validate([
                'config' => 'required|file|mimes:json',
            ]);
            $file = $this->config->getRealPath();
            $data = json_decode(file_get_contents($file), true);
        } elseif ($uploadMethod === 'input') {
            $this->validate([
                'config' => 'required|json',
            ]);
            $data = json_decode($this->config, true);
        } else {
            session()->flash('error', 'Invalid upload method');
        }
        return $data;
    }

    /**
     * Sets the sync config settings from the config import if they exist
     * @param  mixed  $data
     */
    public function configImport(mixed $data): void
    {
        foreach ($data as $key => $value) {
            config(['sync.'.$key => $value]);
        }
    }

    /**
     * @param  mixed  $apps
     */
    public function appsImport(mixed $apps): void
    {
        foreach ($apps as $app) {
            Item::updateOrCreate(['name' => $app['name']], $app);
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.settings');
    }
}
