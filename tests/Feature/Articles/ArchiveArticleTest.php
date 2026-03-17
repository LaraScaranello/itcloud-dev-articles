<?php

use App\Livewire\Articles;
use App\Models\Article;

use Illuminate\Pagination\LengthAwarePaginator;
use function Pest\Laravel\assertSoftDeleted;


it('should be able to archive an article', function () {
    $article = Article::factory()->create();

    Livewire::test(Articles\Archive::class)
        ->set('article', $article)
        ->call('archive');

    assertSoftDeleted('articles', [
        'id' => $article->id,
    ]);
});

test('when confirming we should load the article and set modal to true', function () {
    $article = Article::factory()->create();

    Livewire::test(Articles\Archive::class)
        ->call('confirmAction', $article->id)
        ->assertSet('article.id', $article->id)
        ->assertSet('modal', true);
});

test('after archiving we should dispatch an event to tell the list to reload', function () {
    $article = Article::factory()->create();

    Livewire::test(Articles\Archive::class)
        ->set('article', $article)
        ->call('archive')
        ->assertDispatched('article::reload');
});

test('after archiving we should close the modal', function () {
    $article = Article::factory()->create();

    Livewire::test(Articles\Archive::class)
        ->set('article', $article)
        ->call('archive')
        ->assertSet('modal', false);
});

it('should list archived items', function () {
    Article::factory()->count(2)->create();

    $archived = Article::factory()->create();
    $archived->delete();

    Livewire::test(Articles\Index::class)
        ->set('search_trash', false)
        ->assertViewHas('articles', function (LengthAwarePaginator $items) use ($archived) {
            expect($items->items())->toHaveCount(2)
                ->and(
                    collect($items->items())
                        ->filter(fn (Article $article) => $article->id === $archived->id)
                )->toBeEmpty();

            return true;

        })
        ->set('search_trash', true)
        ->assertViewHas('articles', function (LengthAwarePaginator $items) use ($archived) {
            expect($items->items())->toHaveCount(3)
                ->and(
                    collect($items->items())
                        ->filter(fn (Article $article) => $article->id === $archived->id)
                )->not->toBeEmpty();

            return true;
        });
});