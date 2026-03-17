<?php

use App\Livewire\Articles;
use App\Models\Article;
use App\Models\Developer;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $user = User::factory()->create();
    actingAs($user);
});

it('should be able to create an article', function () {
    $developers = Developer::factory()->count(2)->create();

    Livewire::test(Articles\Create::class)
        ->set('form.title', 'Laravel Livewire Guide')
        ->assertSet('form.title', 'Laravel Livewire Guide')
        ->set('form.content', 'This is the content of my article')
        ->assertSet('form.content', 'This is the content of my article')
        ->set('form.published_at', '2024-01-01')
        ->assertSet('form.published_at', '2024-01-01')
        ->set('form.developers', $developers->pluck('id')->toArray())
        ->assertSet('form.developers', $developers->pluck('id')->toArray())
        ->call('save')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('articles', [
        'title' => 'Laravel Livewire Guide',
        'content' => 'This is the content of my article',
        'published_at' => '2024-01-01 00:00:00',
    ]);
});

it('should accept html content when creating an article', function () {
    $developers = Developer::factory()->count(1)->create();

    $html = '<h1>Introduction</h1><p>This is a <strong>formatted</strong>article.</p>';

    Livewire::test(Articles\Create::class)
        ->set('form.title', 'Laravel HTML Article')
        ->assertSet('form.title', 'Laravel HTML Article')
        ->set('form.content', $html)
        ->assertSet('form.content', $html)
        ->set('form.published_at', '2024-01-01')
        ->assertSet('form.published_at', '2024-01-01')
        ->set('form.developers', $developers->pluck('id')->toArray())
        ->assertSet('form.developers', $developers->pluck('id')->toArray())
        ->call('save')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('articles', [
        'title' => 'Laravel HTML Article',
        'content' => $html,
        'published_at' => '2024-01-01 00:00:00',
    ]);
});

it('should allow cover image upload when creating an article', function () {
    Storage::fake('public');

    $developers = Developer::factory()->count(1)->create();
    $file = UploadedFile::fake()->image('cover.jpg');

    Livewire::test(Articles\Create::class)
        ->set('form.title', 'Article with Cover')
        ->assertSet('form.title', 'Article with Cover')
        ->set('form.content', 'Content with cover image')
        ->assertSet('form.content', 'Content with cover image')
        ->set('form.published_at', '2024-01-01')
        ->assertSet('form.published_at', '2024-01-01')
        ->set('form.developers', $developers->pluck('id')->toArray())
        ->assertSet('form.developers', $developers->pluck('id')->toArray())
        ->set('form.cover_image', $file)
        ->assertSet('form.cover_image', function ($value) {
            expect($value)->toBeInstanceOf(TemporaryUploadedFile::class);

            return true;
        })
        ->call('save')
        ->assertHasNoErrors();

    $article = Article::query()->first();

    expect($article->cover_image)->not->toBeNull();

    Storage::disk('public')->assertExists($article->cover_image);
});

it('should generate slug automatically when creating an article', function () {
    $developers = Developer::factory()->count(2)->create();

    Livewire::test(Articles\Create::class)
        ->set('form.title', 'Laravel Livewire Guide')
        ->assertSet('form.title', 'Laravel Livewire Guide')
        ->set('form.content', 'This is the content of my article')
        ->assertSet('form.content', 'This is the content of my article')
        ->set('form.published_at', '2024-01-01')
        ->assertSet('form.published_at', '2024-01-01')
        ->set('form.developers', $developers->pluck('id')->toArray())
        ->assertSet('form.developers', $developers->pluck('id')->toArray())
        ->call('save')
        ->assertHasNoErrors();

    $article = Article::query()->first();

    expect($article->slug)->not->toBeEmpty()
        ->and($article->slug)->toContain('laravel-livewire-guide');
});

it('should dispatch an event to reload the articles list after creating', function () {
    $developers = Developer::factory()->count(1)->create();

    Livewire::test(Articles\Create::class)
        ->set('form.title', 'Laravel Livewire Guide')
        ->assertSet('form.title', 'Laravel Livewire Guide')
        ->set('form.content', 'This is the content of my article')
        ->assertSet('form.content', 'This is the content of my article')
        ->set('form.published_at', '2024-01-01')
        ->assertSet('form.published_at', '2024-01-01')
        ->set('form.developers', $developers->pluck('id')->toArray())
        ->assertSet('form.developers', $developers->pluck('id')->toArray())
        ->call('save')
        ->assertDispatched('article::reload');
});

describe('validations', function () {
    test('title', function ($rule, $value) {
        Livewire::test(Articles\Create::class)
            ->set('form.title', $value)
            ->call('save')
            ->assertHasErrors(['form.title' => $rule]);
    })->with([
        'required' => ['required', ''],
        'min' => ['min', 'La'],
        'max' => ['max', str_repeat('a', 256)],
    ]);

    test('content', function ($rule, $value) {
        Livewire::test(Articles\Create::class)
            ->set('form.content', $value)
            ->call('save')
            ->assertHasErrors(['form.content' => $rule]);
    })->with([
        'required' => ['required', ''],
    ]);

    test('published_at', function ($rule, $value) {
        Livewire::test(Articles\Create::class)
            ->set('form.published_at', $value)
            ->call('save')
            ->assertHasErrors(['form.published_at' => $rule]);
    })->with([
        'required' => ['required', ''],
        'date' => ['date', 'not-a-date'],
    ]);

    test('developers cannot be empty', function () {
        Livewire::test(Articles\Create::class)
            ->set('form.title', 'Laravel Livewire Guide')
            ->assertSet('form.title', 'Laravel Livewire Guide')
            ->set('form.content', 'This is the content of my article')
            ->assertSet('form.content', 'This is the content of my article')
            ->set('form.published_at', '2024-01-01')
            ->assertSet('form.published_at', '2024-01-01')
            ->set('form.developers', [])
            ->assertSet('form.developers', [])
            ->call('save')
            ->assertHasErrors(['form.developers' => 'required']);
    });
});
