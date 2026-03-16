<?php

use App\Livewire\Articles;
use App\Models\Article;
use App\Models\Developer;
use App\Models\User;

use Illuminate\Http\UploadedFile;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    actingAs(User::factory()->create());

    $this->article = Article::factory()->create([
        'title' => 'Old Title',
        'content' => 'Old Content',
        'published_at' => '2024-01-01',
        'cover_image' => null,
    ]);

    $this->developers = Developer::factory()->count(3)->create();

    $this->article->developers()->sync([
        $this->developers[0]->id,
        $this->developers[1]->id,
    ]);
});

it('should be able to update an article', function () {
    Livewire::test(Articles\Update::class)
        ->call('load', $this->article->id)
        ->set('form.title', 'New Title')
        ->assertSet('form.title', 'New Title')
        ->set('form.content', 'Updated article content')
        ->assertSet('form.content', 'Updated article content')
        ->set('form.published_at', '2024-02-10')
        ->assertSet('form.published_at', '2024-02-10')
        ->set('form.developers', [
            $this->developers[1]->id,
            $this->developers[2]->id,
        ])
        ->call('save')
        ->assertHasNoErrors();

    assertDatabaseHas('articles', [
        'id' => $this->article->id,
        'title' => 'New Title',
        'content' => 'Updated article content',
        'published_at' => '2024-02-10 00:00:00',
    ]);

    $article = Article::query()->with('developers')->find($this->article->id);

    expect($article)->not->toBeNull()
        ->and($article->developers->pluck('id')->sort()->values()->toArray())
        ->toBe([
            $this->developers[1]->id,
            $this->developers[2]->id,
        ]);
});

it('should load article data when editing', function () {
    $component = Livewire::test(Articles\Update::class)
        ->call('load', $this->article->id)
        ->assertSet('form.title', 'Old Title')
        ->assertSet('form.content', 'Old Content')
        ->assertSet('form.published_at', '2024-01-01')
        ->assertSet('modal', true);

    expect(collect($component->get('form.developers'))->sort()->values()->toArray())
        ->toBe(collect([
            $this->developers[0]->id,
            $this->developers[1]->id,
        ])->sort()->values()->toArray());
});

it('should accept html content when updating an article', function () {
    $html = '<h1>Updated title</h1><p>Updated <strong>formatted</strong> content.</p>';

    Livewire::test(Articles\Update::class)
        ->call('load', $this->article->id)
        ->set('form.title', 'Updated HTML Article')
        ->assertSet('form.title', 'Updated HTML Article')
        ->set('form.content', $html)
        ->assertSet('form.content', $html)
        ->set('form.published_at', '2024-03-01')
        ->assertSet('form.published_at', '2024-03-01')
        ->set('form.developers', [$this->developers[0]->id])
        ->assertSet('form.developers', [$this->developers[0]->id])
        ->call('save')
        ->assertHasNoErrors();

    assertDatabaseHas('articles', [
        'id' => $this->article->id,
        'title' => 'Updated HTML Article',
        'content' => $html,
        'published_at' => '2024-03-01 00:00:00',
    ]);
});

it('should allow cover image upload when updating an article', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->image('updated-cover.jpg');

    Livewire::test(Articles\Update::class)
        ->call('load', $this->article->id)
        ->set('form.title', 'Article with Updated Cover')
        ->assertSet('form.title', 'Article with Updated Cover')
        ->set('form.content', 'Updated content')
        ->assertSet('form.content', 'Updated content')
        ->set('form.published_at', '2025-01-10')
        ->assertSet('form.published_at', '2025-01-10')
        ->set('form.developers', $this->developers->pluck('id')->toArray())
        ->assertSet('form.developers', $this->developers->pluck('id')->toArray())
        ->set('form.cover_image', $file)
        ->assertSet('form.cover_image', function ($value) {
            expect($value)->toBeInstanceOf(TemporaryUploadedFile::class);

            return true;
        })
        ->call('save')
        ->assertHasNoErrors();

    $article = Article::find($this->article->id);

    expect($article->cover_image)->not->toBeNull();

    Storage::disk('public')->assertExists($article->cover_image);
});

it('should dispatch an event to reload the articles list after updating', function () {
    Livewire::test(Articles\Update::class)
        ->call('load', $this->article->id)
        ->set('form.title', 'Updated Reload Event')
        ->assertSet('form.title', 'Updated Reload Event')
        ->set('form.content', 'Updated content')
        ->assertSet('form.content', 'Updated content')
        ->set('form.published_at', '2025-05-01')
        ->assertSet('form.published_at', '2025-05-01')
        ->set('form.developers', $this->developers->pluck('id')->toArray())
        ->assertSet('form.developers', $this->developers->pluck('id')->toArray())
        ->call('save')
        ->assertDispatched('article::reload');
});

describe('validations', function () {
    test('title', function ($rule, $value) {
        Livewire::test(Articles\Update::class)
            ->call('load', $this->article->id)
            ->set('form.title', $value)
            ->call('save')
            ->assertHasErrors(['form.title' => $rule]);
    })->with([
        'required' => ['required', ''],
        'min' => ['min', 'La'],
        'max' => ['max', str_repeat('a', 256)],
    ]);

    test('content', function ($rule, $value) {
        Livewire::test(Articles\Update::class)
            ->call('load', $this->article->id)
            ->set('form.content', $value)
            ->call('save')
            ->assertHasErrors(['form.content' => $rule]);
    })->with([
        'required' => ['required', ''],
    ]);

    test('published_at', function ($rule, $value) {
        Livewire::test(Articles\Update::class)
            ->call('load', $this->article->id)
            ->set('form.published_at', $value)
            ->call('save')
            ->assertHasErrors(['form.published_at' => $rule]);
    })->with([
        'required' => ['required', ''],
        'date' => ['date', 'not-a-date'],
    ]);

    test('developers cannot be empty', function () {
        Livewire::test(Articles\Update::class)
            ->call('load', $this->article->id)
            ->set('form.title', 'Laravel Livewire Guide')
            ->set('form.content', 'This is the content of my article')
            ->set('form.published_at', '2024-01-01')
            ->set('form.developers', [])
            ->call('save')
            ->assertHasErrors(['form.developers' => 'required']);
    });

    test('developers items should exist in database', function () {
        Livewire::test(Articles\Update::class)
            ->call('load', $this->article->id)
            ->set('form.title', 'Laravel Livewire Guide')
            ->set('form.content', 'This is the content of my article')
            ->set('form.published_at', '2024-01-01')
            ->set('form.developers', [999999])
            ->call('save')
            ->assertHasErrors(['form.developers.0' => 'exists']);
    });
});



