<?php

use App\Enums\Seniority;
use App\Livewire\Developers;
use App\Models\Developer;
use App\Models\Skill;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    actingAs(User::factory()->create());
    $this->developer = Developer::factory()->create();
    $this->skills = Skill::factory()->count(2)->create();
});

it('should be able to update a developer', function () {
    Livewire::test(Developers\Update::class)
        ->call('load', $this->developer->id)
        ->set('form.name', 'John Doe')
        ->assertSet('form.name', 'John Doe')
        ->set('form.email', 'joe@doe.com')
        ->assertSet('form.email', 'joe@doe.com')
        ->set('form.seniority', Seniority::Senior->value)
        ->assertSet('form.seniority', Seniority::Senior->value)
        ->set('form.skills', $this->skills->pluck('id')->toArray())
        ->assertSet('form.skills', $this->skills->pluck('id')->toArray())
        ->call('save')
        ->assertHasNoErrors();

    assertDatabaseHas('developers', [
        'name' => 'John Doe',
        'email' => 'joe@doe.com',
        'seniority' => Seniority::Senior->value,
    ]);

    $developer = Developer::query()->where('email', 'joe@doe.com')->first();

    expect($developer)->not->toBeNull()
        ->and($developer->skills)->toHaveCount(2);
});

describe('validations', function () {
    test('name', function ($rule, $value) {
        Livewire::test(Developers\Update::class)
            ->set('form.name', $value)
            ->call('save')
            ->assertHasErrors(['form.name' => $rule]);
    })->with([
        'required' => ['required', ''],
        'min' => ['min', 'Jo'],
        'max' => ['max', str_repeat('a', 256)],
    ]);

    test('email', function ($rule, $value) {
        Livewire::test(Developers\Update::class)
            ->set('form.email', $value)
            ->call('save')
            ->assertHasErrors(['form.email' => $rule]);
    })->with([
        'required' => ['required', ''],
        'email' => ['email', 'not-an-email'],
        'max' => ['max', str_repeat('a', 256).'@example.com'],
    ]);

    test('email should be unique', function () {
        Developer::factory()->create(['email' => 'joe@doe.com']);

        Livewire::test(Developers\Update::class)
            ->set('form.email', 'joe@doe.com')
            ->call('save')
            ->assertHasErrors(['form.email' => 'unique']);
    });

    test('seniority', function ($rule, $value) {
        Livewire::test(Developers\Update::class)
            ->set('form.seniority', $value)
            ->call('save')
            ->assertHasErrors(['form.seniority' => $rule]);
    })->with([
        'required' => ['required', ''],
        'in' => ['in', 'invalid-seniority'],
    ]);

    test('skills cannot be empty', function () {
        Livewire::test(Developers\Update::class)
            ->set('form.name', 'John Doe')
            ->set('form.email', 'joe@doe.com')
            ->set('form.seniority', Seniority::Senior->value)
            ->set('form.skills', [])
            ->call('save')
            ->assertHasErrors(['form.skills' => 'required']);
    });

    test('skills items should exist in database', function () {
        Livewire::test(Developers\Update::class)
            ->set('form.name', 'John Doe')
            ->set('form.email', 'joe2@doe.com')
            ->set('form.seniority', Seniority::Senior->value)
            ->set('form.skills', [999999])
            ->call('save')
            ->assertHasErrors(['form.skills.0' => 'exists']);
    });
});
