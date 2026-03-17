<?php

namespace App\Livewire\Articles;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    use AuthorizesRequests;

    public ?Article $article = null;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.articles.show');
    }

    #[On('article::show')]
    public function load(int $id): void
    {
        $article = Article::query()
            ->with(['developers'])
            ->findOrFail($id);

        $this->authorize('view', $article);

        $this->article = $article;
        $this->modal = true;
    }
}
