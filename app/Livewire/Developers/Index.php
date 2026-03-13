<?php

namespace App\Livewire\Developers;

use App\Enums\Seniority;
use App\Models\Developer;
use App\Models\Skill;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $seniority = '';
    public array $skills = [];
    public $perPage = 15;
    public $sortField = 'name';
    public $sortDirection = 'asc';

    public function sortBy(string $field): void
    {
        $allowedFields = ['name', 'email', 'seniority'];

        if (! in_array($field, $allowedFields)) {
            return;
        }

        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    #[On('developer::reload')]
    public function render(): View
    {
        $developers = Developer::query()
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%");
                });
            })
            ->when($this->seniority, fn ($q) => $q->where('seniority', $this->seniority))
            ->when($this->skills, function ($q) {
                $q->whereHas('skills', function ($query) {
                    $query->whereIn('skills.id', $this->skills);
                });
            })
            ->with('skills')
            ->withCount('articles')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.developers.index', [
            'developers' => $developers,
            'seniorities' => Seniority::cases(),
            'skillsList' => Skill::orderBy('name')->get(),
        ]);
    }
}
