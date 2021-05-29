<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Performance extends Component
{
    public $results;
    public $data_page = 1, $testing_page = 1, $total_data_page, $total_testing_page;
    public $data_samples;

    public function mount()
    {
        $this->total_data_page = ceil(1061 / 5);

        $data = Http::get(Config::get('BASE_API') . 'sample/' . $this->data_page);
        $this->data_samples = $data->json();

        $response = Http::get(Config::get('BASE_API') . 'performa');
        $this->results = $response->json();
    }

    public function render()
    {
        return view('livewire.performance');
    }

    public function pagination($prev_next)
    {
        $this->data_page = $this->data_page + $prev_next;
        $data = Http::get(Config::get('BASE_API') . 'sample/' . $this->data_page);
        $this->data_samples = $data->json();
    }
}
