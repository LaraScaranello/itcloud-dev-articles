<?php

namespace App\Livewire\Articles;

use App\Models\Article;
use App\Models\Developer;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public Form $form;

    public $developersList;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.articles.update', [
            'developersList' => Developer::orderBy('name')->get(),
        ]);
    }

    public function mount(): void
    {
        $this->developersList = Developer::orderBy('name')->get();
    }

    #[On('article::update')]
    public function load(int $id): void
    {
        $article = Article::find($id);
        $this->form->setArticle($article);
        $this->form->resetErrorBag();
        $this->modal = true;
    }

    public function save(): void
    {
        $this->form->update();

        $this->modal = false;

        $this->dispatch('toast', message: 'Artigo atualizado com sucesso!', type: 'success');
        $this->dispatch('article::reload')->to(Index::class);
    }
}
