<?php

use App\Livewire\Articles;
use App\Models\Article;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertNotSoftDeleted;

beforeEach(function () {
    $this->user = User::factory()->create();

    actingAs($this->user);
});

it('should be able to restore an article', function () {
    $article = Article::factory()->create([
        'user_id' => $this->user->id,
    ]);
    $article->delete();

    Livewire::test(Articles\Restore::class)
        ->set('article', $article)
        ->call('restore');

    assertNotSoftDeleted('articles', [
        'id' => $article->id,
    ]);
});

test('when confirming we should load the article and set modal to true', function () {
    $article = Article::factory()->create([
        'user_id' => $this->user->id,
    ]);
    $article->delete();

    Livewire::test(Articles\Restore::class)
        ->call('confirmAction', $article->id)
        ->assertSet('article.id', $article->id)
        ->assertSet('modal', true);
});

test('after restoring we should dispatch an event to tell the list to reload', function () {
    $article = Article::factory()->create([
        'user_id' => $this->user->id,
    ]);
    $article->delete();

    Livewire::test(Articles\Restore::class)
        ->set('article', $article)
        ->call('restore')
        ->assertDispatched('article::reload');
});

test('after restoring we should close the modal', function () {
    $article = Article::factory()->create([
        'user_id' => $this->user->id,
    ]);
    $article->delete();

    Livewire::test(Articles\Restore::class)
        ->set('article', $article)
        ->call('restore')
        ->assertSet('modal', false);
});
