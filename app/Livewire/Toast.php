<?php

namespace App\Livewire;

use Livewire\Component;

class Toast extends Component
{
    public $message = '';
    public $type = 'info';
    public $show = false;

    protected $listeners = ['showToast'];

    public function showToast($message, $type = 'info')
    {
        $this->message = $message;
        $this->type = $type;
        $this->show = true;

        $this->dispatch('show-toast');

        // Programmer la fermeture du toast après 5 secondes
        $this->dispatch('close-toast-timer');
    }

    public function render()
    {
        return view('livewire.toast');
    }
}
