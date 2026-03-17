<?php

namespace App\Livewire\Developers;

use App\Models\Developer;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Restore extends Component
{
    public Developer $developer;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.developers.restore');
    }

    #[On('developer::restore')]
    public function confirmAction(int $id): void
    {
        $this->developer = Developer::query()->onlyTrashed()->findOrFail($id);
        $this->modal = true;
    }

    public function restore(): void
    {
        $this->authorize('restore', $this->developer);

        $this->developer->restore();
        $this->modal = false;

        $this->dispatch('toast', message: 'Desenvolvedor restaurado com sucesso!', type: 'success');
        $this->dispatch('developer::reload')->to(Index::class);
    }
}
