<?php

namespace App\Livewire\Articles;

use App\Models\Developer;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public Form $form;

    public $developersList;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.articles.create');
    }

    public function mount(): void
    {
        $this->developersList = Developer::orderBy('name')->get();
    }

    #[On('article::create')]
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

        $this->dispatch('toast', message: 'Artigo criado com sucesso!', type: 'success');
        $this->dispatch('article::reload')->to(Index::class);
    }
}
