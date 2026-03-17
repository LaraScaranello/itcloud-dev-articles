<?php

namespace App\Livewire\Developers;

use App\Models\Developer;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Archive extends Component
{
    public Developer $developer;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.developers.archive');
    }

    #[On('developer::archive')]
    public function confirmAction(int $id): void
    {
        $this->developer = Developer::findOrFail($id);
        $this->modal = true;
    }

    public function archive(): void
    {
        $this->authorize('delete', $this->developer);

        $this->developer->delete();
        $this->modal = false;

        $this->dispatch('toast', message: 'Desenvolvedor arquivado com sucesso!', type: 'success');
        $this->dispatch('developer::reload')->to(Index::class);
    }
}
