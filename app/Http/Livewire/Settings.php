<?php

namespace App\Http\Livewire;

use App\Models\Item;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class Settings extends Component
{
    use WithFileUploads;

    public $config;
    public $uploadMethod = 'file';
    public $confirmed = false;

    protected $listeners = ['confirm'];

//    public function configType($uploadMethod)
//    {
//        if ($this->$uploadMethod === 'file') {
//            $this->validate([
//                'config' => 'required|file|mimes:json',
//            ]);
//        } elseif ($this->$uploadMethod === 'input') {
//            $this->validate([
//                'config' => 'required|json',
//            ]);
//        } else {
//            session()->flash('error', 'Invalid upload method');
//        }
//    }

    public function confirm()
    {
        $this->confirmed = true;
        $this->emit('closeModal');
    }


    public function export()
    {
        $filename = 'intralab_config_'.date('Y-m-d').'.json';
        return response()->streamDownload(function () {
            $apps = Item::all()->toArray();
            $data = [
                'settings' => [
                    'synology_ldap' => config('sync.synology'),
                    'sync_type' => config('sync.sync_type'),
                    'default_group' => config('sync.default_group'),
                ],
                'apps' => $apps,
            ];
            echo json_encode($data);
        }, $filename);
    }

    public function updatedConfig()
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

    public function import()
    {
        $data = $this->getData();

        $data = $this->configImport($data);

        if (isset($data['apps'])) {
            $this->appsImport($data['apps']);
        }
        
        return redirect('/')->with('success', 'Import successful');
    }

    /**
     * @return mixed
     */
    public function getData(): mixed
    {
        $uploadMethod = $this->uploadMethod;
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
     * @param  mixed  $data
     * @return mixed
     */
    public function configImport(mixed $data): mixed
    {
        if (isset($data['config'])) {
            $settings = $data['config'];
            if (isset($settings['synology_ldap'])) {
                config(['sync.synology' => $settings['synology_ldap']]);
            }
            if (isset($settings['sync_type'])) {
                config(['sync.sync_type' => $settings['sync_type']]);
            }
            if (isset($settings['default_group'])) {
                config(['sync.default_group' => $settings['default_group']]);
            }
        }
        return $data;
    }

    /**
     * @param  mixed  $apps
     */
    public function appsImport(mixed $data): void
    {
        foreach ($data as $app) {
            Item::updateOrCreate(['name' => $app['name']], $app);
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('livewire.settings');
    }
}
