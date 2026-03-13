<?php

namespace App\Livewire\Developers;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Create extends Component
{
    public Form $form;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.developers.create');
    }

    #[On('developer::create')]
    public function open(): void
    {
        $this->form->resetErrorBag();
        $this->modal = true;
    }

    public function save(): void
    {
        $this->form->create();

        $this->modal = false;

        $this->dispatch('toast', message: 'Desenvolvedor criado com sucesso!', type: 'success');
        $this->dispatch('developer::reload')->to(Index::class);
    }
}
