<?php

namespace App\Livewire\Articles;

use App\Models\Article;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Form as BaseForm;

class Form extends BaseForm
{
    public ?Article $article = null;

    public string $title = '';

    public string $content = '';

    public string $published_at = '';

    public array $developers = [];

    public ?TemporaryUploadedFile $cover_image = null;

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'content' => ['required', 'string'],
            'published_at' => ['required', 'date'],
            'developers' => ['required', 'array', 'min:1'],
            'developers.*' => ['exists:developers,id'],
            'cover_image' => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'title' => 'título',
            'content' => 'conteúdo',
            'published_at' => 'data de publicação',
            'developers' => 'desenvolvedores',
            'developers.*' => 'desenvolvedor',
            'cover_image' => 'imagem de capa',
        ];
    }

    public function create(): void
    {
        $this->validate();

        $coverPath = $this->cover_image?->store('articles', 'public');

        $article = Article::create([
            'title' => $this->title,
            'content' => $this->content,
            'published_at' => $this->published_at,
            'cover_image' => $coverPath,
        ]);

        $article->developers()->sync($this->developers);

        $this->reset();
    }
}
