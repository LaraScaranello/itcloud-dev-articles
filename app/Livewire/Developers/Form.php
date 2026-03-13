<?php

namespace App\Livewire\Developers;

use App\Enums\Seniority;
use App\Models\Developer;
use Livewire\Form as BaseForm;

class Form extends BaseForm
{
    public ?Developer $developer = null;

    public string $name = '';

    public string $email = '';

    public string $seniority = '';

    public array $skills = [];

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:developers,email,'.$this->developer?->id],
            'seniority' => ['required', 'in:'.collect(Seniority::cases())->pluck('value')->implode(',')],
            'skills' => ['required', 'array', 'min:1'],
            'skills.*' => ['exists:skills,id'],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'name' => 'nome',
            'email' => 'e-mail',
            'seniority' => 'senioridade',
            'skills' => 'skills',
            'skills.*' => 'skill',
        ];
    }

    public function create(): void
    {
        $this->validate();

        $developer = Developer::create([
            'name' => $this->name,
            'email' => $this->email,
            'seniority' => $this->seniority,
        ]);

        $developer->skills()->sync($this->skills);

        $this->reset();
    }
}
