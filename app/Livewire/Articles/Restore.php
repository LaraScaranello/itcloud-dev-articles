<?php

namespace App\Livewire\Articles;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Restore extends Component
{
    public Article $article;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.articles.restore');
    }

    #[On('article::restore')]
    public function confirmAction(int $id): void
    {
        $this->article = Article::query()->onlyTrashed()->findOrFail($id);
        $this->modal = true;
    }

    public function restore(): void
    {
        $this->authorize('restore', $this->article);

        $this->article->restore();
        $this->modal = false;

        $this->dispatch('toast', message: 'Artigo restaurado com sucesso!', type: 'success');
        $this->dispatch('article::reload')->to(Index::class);
    }
}
