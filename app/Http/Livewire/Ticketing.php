<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Ticketing extends Component
{
    public $subject;
    public $message;

    public function init(): void
    {
        $system = config('ticketing.platform');
        $response = null;

        switch ($system) {
            case 'zammad':
//                $response = $this->zammad();
                break;
            case 'osticket':
                $this->osticket($this->subject, $this->message);
                break;
        }
    }

    // Submit a ticket using the zammad API library
//    public function zammad($title, $description): \Response
//    {
//
//    }

    // Submit a ticket using the osTicket API
    public function osticket($title, $description): void
    {
        $base_url = config('ticketing.osticket_base_url');

        $url = $base_url.'/api/tickets.json';

        $headers = [
            'X-API-Key' => config('ticketing.osticket_api_key'),
        ];

        $response = Http::withHeaders($headers)->post($url, [
            'alert' => true,
            'source' => 'API',
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'subject' => $title,
            'message' => 'data:text/plain,'.$description
        ]);

        if ($response->successful()) {
            session()->flash('success', 'Issue reported successfully!');
        } else {
            Log::error('Error reporting issue to osTicket: '.$response->body());
            session()->flash('error', 'There was an error reporting your issue. Please try again.');
        }
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.ticketing');
    }
}
