<?php

use App\Livewire\Articles\Show;
use App\Models\Article;
use App\Models\Developer;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->create();

    actingAs($this->user);

    $this->article = Article::factory()->create([
        'user_id' => $this->user->id,
        'title' => 'Laravel Livewire Article',
        'slug' => 'laravel-livewire-article',
        'content' => '<h2>Conteúdo</h2><p>Artigo em HTML</p>',
        'published_at' => '2024-01-01 00:00:00',
    ]);

    $this->developers = Developer::factory()->count(2)->create();

    $this->article->developers()->sync($this->developers->pluck('id')->toArray());
});

it('should be able to load an article for viewing', function () {
    Livewire::test(Show::class)
        ->call('load', $this->article->id)
        ->assertSet('modal', true)
        ->assertSet('article.id', $this->article->id)
        ->assertSet('article.title', 'Laravel Livewire Article')
        ->assertSet('article.slug', 'laravel-livewire-article');
});

it('should render article content and developers in the modal', function () {
    Livewire::test(Show::class)
        ->call('load', $this->article->id)
        ->assertSee('Laravel Livewire Article')
        ->assertSee('laravel-livewire-article')
        ->assertSee('Artigo em HTML', false)
        ->assertSee($this->developers[0]->name)
        ->assertSee($this->developers[1]->name);
});

it('should allow authenticated users to view articles from other users', function () {
    $otherUser = User::factory()->create();

    $article = Article::factory()->create([
        'user_id' => $otherUser->id,
        'title' => 'Other User Article',
    ]);

    Livewire::test(Show::class)
        ->call('load', $article->id)
        ->assertSet('modal', true)
        ->assertSet('article.id', $article->id)
        ->assertSee('Other User Article');
});
