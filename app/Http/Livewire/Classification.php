<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Classification extends Component
{
    public $text;
    public $active = false;
    public $result;

    protected $rules = [
        'text' => ['required', 'string', 'min:100']
    ];

    protected $messages = [
        'text.required' => 'Teks tidak boleh kosong!',
        'text.min' => 'Panjang teks minimal 100 karakter'
    ];

    public function render()
    {
        return view('livewire.classification');
    }

    public function predict()
    {
        $text = $this->validate();
        $response = Http::asForm()->post(Config::get('BASE_API') . 'prepro', [
            'text' => $text['text'],
        ]);

        $this->result = $response->json();
        $this->active = true;
    }
}
