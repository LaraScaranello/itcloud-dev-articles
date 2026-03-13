<?php

namespace App\Livewire\Developers;

use App\Models\Skill;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Create extends Component
{
    public Form $form;

    public $skillsList;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.developers.create');
    }

    public function mount(): void
    {
        $this->skillsList = Skill::orderBy('name')->get();
    }

    #[On('developer::create')]
    public function open(): void
    {
        $this->form->reset();

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
