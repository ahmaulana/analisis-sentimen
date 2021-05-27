<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Tweet extends Component
{
    public $tweet_id = 1;
    public $readyToLoad = false;
    public $loader = true;

    public function loadTweets()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.tweet', [
            'results' => $this->readyToLoad ? $this->getTweet() : []
        ]);
    }

    public function getTweet()
    {
        $response = Http::get(Config::get('BASE_API') . 'tweet/' . $this->tweet_id);
        $result = $response->json();
        $this->tweet_id = (string) 1397794626355007492;
        $this->loader = false;
        return $result['result'];
    }

    public function refreshTweet()
    {
        $this->loader = true;
    }
    
}
