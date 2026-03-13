<?php

namespace App\Livewire\Developers;

use App\Models\Developer;
use App\Models\Skill;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Update extends Component
{
    public Form $form;

    public $skillsList;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.developers.update', [
            'skillsList' => Skill::orderBy('name')->get(),
        ]);
    }

    public function mount(): void
    {
        $this->skillsList = Skill::orderBy('name')->get();
    }

    #[On('developer::update')]
    public function load(int $id): void
    {
        $customer = Developer::find($id);
        $this->form->setDeveloper($customer);
        $this->form->resetErrorBag();
        $this->modal = true;
    }

    public function save(): void
    {
        $this->form->update();

        $this->modal = false;

        $this->dispatch('toast', message: 'Desenvolvedor atualizado com sucesso!', type: 'success');
        $this->dispatch('developer::reload')->to(Index::class);
    }
}
