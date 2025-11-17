<?php

namespace App\Livewire;

use Livewire\Component;

class PublicThankYouPage extends Component
{
    protected string $layout = 'layouts.app';

    public function render()
    {
        return view('livewire.public-thank-you');
    }
}
