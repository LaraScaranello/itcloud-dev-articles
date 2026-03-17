<?php

namespace App\Livewire\Developers;

use App\Models\Developer;
use App\Models\Skill;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\On;
use Livewire\Component;

class Update extends Component
{
    use AuthorizesRequests;

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
        $developer = Developer::findOrFail($id);

        $this->authorize('update', $developer);

        $this->form->setDeveloper($developer);
        $this->form->resetErrorBag();
        $this->modal = true;
    }

    public function save(): void
    {
        $this->authorize('update', $this->form->developer);

        $this->form->update();

        $this->modal = false;

        $this->dispatch('toast', message: 'Desenvolvedor atualizado com sucesso!', type: 'success');
        $this->dispatch('developer::reload')->to(Index::class);
    }
}
