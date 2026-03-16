<?php

namespace Tests\Feature\Articles;

use App\Livewire\Articles;
use App\Models\Article;
use App\Models\Developer;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
    $user = User::factory()->create();
    actingAs($user);
});

it('should be able to access the route articles', function () {
    get(route('articles'))
        ->assertOk();
});

test("let's create a livewire component to list all articles in the page", function () {
    Article::factory()->count(10)->create();

    $lw = Livewire::test(Index::class);

    $articles = $lw->viewData('articles');

    expect($articles->count())->toBe(10);

    foreach ($articles as $article) {
        $lw->assertSee($article->title);
    }
});

it('should be able to filter by title, author name and published date', function () {
    $matchedByTitle = Article::factory()->create(['title' => 'Laravel Livewire Guide', 'published_at' => '2025-01-10']);
    $matchedByAuthor = Article::factory()->create(['title' => 'Testing in PHP', 'published_at' => '2025-02-15']);
    $notMatched = Article::factory()->create(['title' => 'Vue Basics', 'published_at' => '2025-03-20']);
    $author = Developer::factory()->create(['name' => 'John Doe']);
    $otherAuthor = Developer::factory()->create(['name' => 'Jane Smith']);

    $matchedByAuthor->developers()->sync([$author->id]);
    $notMatched->developers()->sync([$otherAuthor->id]);

    Livewire::test(Articles\Index::class)
        ->set('search', 'John')
        ->assertViewHas('articles', function (LengthAwarePaginator $items) use ($matchedByAuthor, $notMatched) {
            $ids = collect($items->items())->pluck('id');

            expect($ids)->toContain($matchedByAuthor->id)
                ->and($ids)->not->toContain($notMatched->id);

            return true;
        });

    Livewire::test(Articles\Index::class)
        ->set('search', 'Laravel')
        ->assertViewHas('articles', function (LengthAwarePaginator $items) use ($matchedByTitle, $notMatched) {
            $ids = collect($items->items())->pluck('id');

            expect($ids)->toContain($matchedByTitle->id)
                ->and($ids)->not->toContain($notMatched->id);

            return true;
        });

    Livewire::test(Articles\Index::class)
        ->set('search', '15/02/2025')
        ->assertViewHas('articles', function (LengthAwarePaginator $items) use ($matchedByAuthor, $notMatched) {
            $ids = collect($items->items())->pluck('id');

            expect($ids)->toContain($matchedByAuthor->id)
                ->and($ids)->not->toContain($notMatched->id);

            return true;
        });
});
