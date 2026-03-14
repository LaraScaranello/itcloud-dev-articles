<?php

namespace App\Livewire\Articles;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 15;

    public function render(): View
    {
        $articles = Article::query()
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('title', 'like', "%{$this->search}%")
                        ->orWhereHas('developers', function ($query2) {
                            $query2->where('name', 'like', "%{$this->search}%");
                        });
                });
            })
            ->with('developers')
            ->withCount('developers')
            ->orderBy('title')
            ->paginate($this->perPage);

        return view('livewire.articles.index', [
            'articles' => $articles,
        ]);
    }
}
