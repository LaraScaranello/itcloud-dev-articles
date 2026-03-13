<?php

namespace App\Livewire\Developers;

use App\Models\Developer;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class ForceDelete extends Component
{
    public Developer $developer;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.developers.force-delete');
    }

    #[On('developer::force-delete')]
    public function confirmAction(int $id): void
    {
        $this->developer = Developer::query()->onlyTrashed()->findOrFail($id);
        $this->modal = true;
    }

    public function delete(): void
    {
        $this->developer->forceDelete();
        $this->modal = false;

        $this->dispatch('toast', message: 'Desenvolvedor excluído permanentemente com sucesso!', type: 'success');
        $this->dispatch('developer::reload')->to(Index::class);
    }
}
