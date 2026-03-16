<?php

namespace App\Livewire\Articles;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public $perPage = 15;

    public function render(): View
    {
        $search = trim($this->search);
        $driver = DB::connection()->getDriverName();

        $articles = Article::query()
            ->when($search !== '', function ($q) use ($search, $driver) {
                $q->where(function ($query) use ($search, $driver) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhereHas('developers', function ($query2) use ($search) {
                            $query2->where('name', 'like', "%{$search}%");
                        });

                    if ($driver === 'sqlite') {
                        $query->orWhereRaw("strftime('%d/%m/%Y', published_at) like ?", ["%{$search}%"]);
                    } elseif ($driver === 'mysql') {
                        $query->orWhereRaw("DATE_FORMAT(published_at, '%d/%m/%Y') like ?", ["%{$search}%"]);
                    }
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
