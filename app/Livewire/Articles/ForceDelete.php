<?php

namespace App\Livewire\Articles;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class ForceDelete extends Component
{
    public Article $article;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.articles.force-delete');
    }

    #[On('article::force-delete')]
    public function confirmAction(int $id): void
    {
        $this->article = Article::query()->onlyTrashed()->findOrFail($id);
        $this->modal = true;
    }

    public function delete(): void
    {
        $this->authorize('forceDelete', $this->article);

        $this->article->forceDelete();
        $this->modal = false;

        $this->dispatch('toast', message: 'Artigo excluído permanentemente com sucesso!', type: 'success');
        $this->dispatch('article::reload')->to(Index::class);
    }
}
