<?php

namespace App\Livewire\Articles;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Archive extends Component
{
    public Article $article;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.articles.archive');
    }

    #[On('article::archive')]
    public function confirmAction(int $id): void
    {
        $this->article = Article::findOrFail($id);
        $this->modal = true;
    }

    public function archive(): void
    {
        $this->authorize('delete', $this->article);

        $this->article->delete();
        $this->modal = false;

        $this->dispatch('toast', message: 'Artigo arquivado com sucesso!', type: 'success');
        $this->dispatch('article::reload')->to(Index::class);
    }
}
