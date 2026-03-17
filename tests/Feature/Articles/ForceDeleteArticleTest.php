<?php

use App\Livewire\Articles;
use App\Models\Article;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseMissing;

beforeEach(function () {
    $this->user = User::factory()->create();

    actingAs($this->user);
});

it('should be able to permanently delete an archived article', function () {
    $article = Article::factory()->create([
        'user_id' => $this->user->id,
    ]);
    $article->delete();

    Livewire::test(Articles\ForceDelete::class)
        ->set('article', $article)
        ->call('delete');

    assertDatabaseMissing('articles', [
        'id' => $article->id,
    ]);
});

test('when confirming force delete we should load the archived article and set modal to true', function () {
    $article = Article::factory()->create([
        'user_id' => $this->user->id,
    ]);
    $article->delete();

    Livewire::test(Articles\ForceDelete::class)
        ->call('confirmAction', $article->id)
        ->assertSet('article.id', $article->id)
        ->assertSet('modal', true);
});

test('after permanently deleting we should dispatch an event to tell the list to reload', function () {
    $article = Article::factory()->create([
        'user_id' => $this->user->id,
    ]);
    $article->delete();

    Livewire::test(Articles\ForceDelete::class)
        ->set('article', $article)
        ->call('delete')
        ->assertDispatched('article::reload');
});

test('after permanently deleting we should close the modal', function () {
    $article = Article::factory()->create([
        'user_id' => $this->user->id,
    ]);
    $article->delete();

    Livewire::test(Articles\ForceDelete::class)
        ->set('article', $article)
        ->call('delete')
        ->assertSet('modal', false);
});
