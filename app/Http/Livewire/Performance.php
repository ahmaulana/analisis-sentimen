<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Performance extends Component
{
    public $results;
    public $training_page = 1, $testing_page = 1, $total_training_page, $total_testing_page;
    public $testing_samples, $training_samples;

    public function mount()
    {
        $this->total_training_page = ceil(1061 / 5);
        $this->total_testing_page = ceil(266 / 5);

        $training = Http::get(Config::get('BASE_API') . 'sample/training/' . $this->training_page);
        $this->training_samples = $training->json();

        $testing = Http::get(Config::get('BASE_API') . 'sample/testing/1' . $this->testing_page);
        $this->testing_samples = $testing->json();

        $response = Http::get(Config::get('BASE_API') . 'performa');
        $this->results = $response->json();
    }

    public function render()
    {
        return view('livewire.performance');
    }

    public function pagination($data, $prev_next)
    {
        if($data == 'training'){
            $this->training_page = $this->training_page + $prev_next;
            $training = Http::get(Config::get('BASE_API') . 'sample/training/' . $this->training_page);
            $this->training_samples = $training->json();
        } else {
            $this->testing_page = $this->testing_page + $prev_next;
            $testing = Http::get(Config::get('BASE_API') . 'sample/testing/' . $this->testing_page);
            $this->testing_samples = $testing->json();
        }
    }
}
