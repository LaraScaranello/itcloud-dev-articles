<?php

namespace Tests\Feature\Developer;

use App\Enums\Seniority;
use App\Livewire\Developers;
use App\Models\Developer;
use App\Models\Skill;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
    $user = User::factory()->create();
    actingAs($user);
});

it('should be able to access the route developers', function () {
    get(route('index'))
        ->assertOk();
});

test("let's create a livewire component to list all developers in the page", function () {
    Developer::factory()->count(10)->create();

    $lw = Livewire::test(Developers\Index::class);

    $developers = $lw->viewData('developers');

    expect($developers)->toHaveCount(10);

    foreach ($developers as $developer) {
        $lw->assertSee($developer->name);
    }
});

it('should be able to filter by name and email', function () {
    $joe = Developer::factory()->create(['name' => 'Joe Doe', 'email' => 'joe@email.com']);
    $mario = Developer::factory()->create(['name' => 'Mario', 'email' => 'little@mario.com']);

    Livewire::test(Developers\Index::class)
        ->assertViewHas('developers', function ($developers) {
            return $developers->total() === 2;
        })
        ->set('search', 'mar')
        ->assertSet('search', 'mar')
        ->assertViewHas('developers', function ($developers) {
            return $developers->total() === 1
                && $developers->first()->name === 'Mario';
        })
        ->set('search', 'little')
        ->assertSet('search', 'little')
        ->assertViewHas('developers', function ($developers) {
            return $developers->total() === 1
                && $developers->first()->name === 'Mario';
        });
});

it('should be able to filter by seniority', function () {
    $junior = Developer::factory()->create(['name' => 'Junior', 'email' => 'junior@email.com', 'seniority' => Seniority::Junior->value]);
    $senior = Developer::factory()->create(['name' => 'Senior', 'email' => 'senior@email.com', 'seniority' => Seniority::Senior->value]);

    Livewire::test(Developers\Index::class)
        ->assertViewHas('developers', fn ($developers) => $developers->total() === 2)
        ->set('seniority', Seniority::Junior->value)
        ->assertSet('seniority', Seniority::Junior->value)
        ->assertViewHas('developers', function ($developers) use ($junior) {
            return $developers->total() === 1
                && $developers->first()->id === $junior->id;
        })
        ->assertSee($junior->name)
        ->assertSee($junior->email)
        ->assertDontSee($senior->email);
});

it('should be able to filter developers by selected skills', function () {
    $php = Skill::factory()->create(['name' => 'PHP']);
    $laravel = Skill::factory()->create(['name' => 'Laravel']);
    $vue = Skill::factory()->create(['name' => 'Vue']);

    $developerOne = Developer::factory()->create(['name' => 'Dev PHP', 'email' => 'php@email.com']);
    $developerTwo = Developer::factory()->create(['name' => 'Dev Laravel', 'email' => 'laravel@email.com']);
    $developerThree = Developer::factory()->create(['name' => 'Dev Vue', 'email' => 'vue@email.com']);

    $developerOne->skills()->attach($php->id);
    $developerTwo->skills()->attach($laravel->id);
    $developerThree->skills()->attach($vue->id);

    Livewire::test(Developers\Index::class)
        ->set('skills', [$php->id, $laravel->id])
        ->assertSet('skills', [$php->id, $laravel->id])
        ->assertViewHas('developers', fn ($developers) => $developers->total() === 2)
        ->assertSee($developerOne->email)
        ->assertSee($developerTwo->email)
        ->assertDontSee($developerThree->email);
});

it('should be able to sort by name', function () {
    $joe = Developer::factory()->create(['name' => 'Joe Doe', 'email' => 'joe@email.com']);
    $mario = Developer::factory()->create(['name' => 'Mario', 'email' => 'little@mario.com']);

    Livewire::test(Developers\Index::class)
        ->set('sortField', 'name')
        ->set('sortDirection', 'asc')
        ->assertViewHas('developers', function ($developers) {
            return $developers->first()->name === 'Joe Doe'
                && $developers->last()->name === 'Mario';
        })
        ->set('sortDirection', 'desc')
        ->assertViewHas('developers', function ($developers) {
            return $developers->first()->name === 'Mario'
                && $developers->last()->name === 'Joe Doe';
        });
});

it('should be able to sort by email', function () {
    Developer::factory()->create(['name' => 'Joe Doe', 'email' => 'aaa@email.com']);
    Developer::factory()->create(['name' => 'Mario', 'email' => 'zzz@email.com']);

    Livewire::test(Developers\Index::class)
        ->set('sortField', 'email')
        ->set('sortDirection', 'asc')
        ->assertViewHas('developers', function ($developers) {
            return $developers->first()->email === 'aaa@email.com'
                && $developers->last()->email === 'zzz@email.com';
        })
        ->set('sortDirection', 'desc')
        ->assertViewHas('developers', function ($developers) {
            return $developers->first()->email === 'zzz@email.com'
                && $developers->last()->email === 'aaa@email.com';
        });
});

it('should be able to sort by seniority', function () {
    Developer::factory()->create(['name' => 'Junior Dev', 'email' => 'junior@email.com', 'seniority' => Seniority::Junior->value]);
    Developer::factory()->create(['name' => 'Senior Dev', 'email' => 'senior@email.com', 'seniority' => Seniority::Senior->value]);

    Livewire::test(Developers\Index::class)
        ->set('sortField', 'seniority')
        ->set('sortDirection', 'asc')
        ->assertViewHas('developers', function ($developers) {
            return $developers->first()->seniority === Seniority::Junior->value
                && $developers->last()->seniority === Seniority::Senior->value;
        })
        ->set('sortDirection', 'desc')
        ->assertViewHas('developers', function ($developers) {
            return $developers->first()->seniority === Seniority::Senior->value
                && $developers->last()->seniority === Seniority::Junior->value;
        });
});

it('should be able to paginate developers', function () {
    Developer::factory()->count(16)->create();

    Livewire::test(Developers\Index::class)
        ->set('perPage', 5)
        ->assertSet('perPage', 5)
        ->assertViewHas('developers', function ($developers) {
            return $developers->count() === 5
                && $developers->total() === 16;
        });
});

it('should show empty state when no developers are found', function () {
    Livewire::test(Developers\Index::class)
        ->set('search', 'nao-existe-123')
        ->assertViewHas('developers', fn ($developers) => $developers->total() === 0)
        ->assertSee('Nenhum desenvolvedor encontrado');
});
