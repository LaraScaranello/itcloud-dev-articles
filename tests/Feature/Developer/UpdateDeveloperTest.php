<?php

use App\Enums\Seniority;
use App\Livewire\Developers;
use App\Models\Developer;
use App\Models\Skill;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    $this->user = User::factory()->create();

    actingAs($this->user);

    $this->developer = Developer::factory()->create([
        'user_id' => $this->user->id,
    ]);

    $this->skills = Skill::factory()->count(2)->create();

    $this->developer->skills()->sync($this->skills->pluck('id')->toArray());
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
        'id' => $this->developer->id,
        'name' => 'John Doe',
        'email' => 'joe@doe.com',
        'seniority' => Seniority::Senior->value,
    ]);

    $developer = Developer::query()->find($this->developer->id);

    expect($developer)->not->toBeNull()
        ->and($developer->skills)->toHaveCount(2);
});

it('should allow the owner to load and update the developer', function () {
    Livewire::test(Developers\Update::class)
        ->call('load', $this->developer->id)
        ->assertSet('modal', true)
        ->set('form.name', 'Owner Updated Name')
        ->set('form.email', 'owner@doe.com')
        ->set('form.seniority', Seniority::Senior->value)
        ->set('form.skills', $this->skills->pluck('id')->toArray())
        ->call('save')
        ->assertHasNoErrors();

    assertDatabaseHas('developers', [
        'id' => $this->developer->id,
        'name' => 'Owner Updated Name',
        'email' => 'owner@doe.com',
    ]);
});

it('should not allow a non-owner to load the developer for editing', function () {
    $owner = User::factory()->create();

    $developer = Developer::factory()->create([
        'user_id' => $owner->id,
    ]);

    $otherUser = User::factory()->create();
    actingAs($otherUser);

    Livewire::test(Developers\Update::class)
        ->call('load', $developer->id)
        ->assertForbidden();
});

describe('validations', function () {
    test('name', function ($rule, $value) {
        Livewire::test(Developers\Update::class)
            ->call('load', $this->developer->id)
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
            ->call('load', $this->developer->id)
            ->set('form.email', $value)
            ->call('save')
            ->assertHasErrors(['form.email' => $rule]);
    })->with([
        'required' => ['required', ''],
        'email' => ['email', 'not-an-email'],
        'max' => ['max', str_repeat('a', 256).'@example.com'],
    ]);

    test('email should be unique', function () {
        Developer::factory()->create([
            'email' => 'joe@doe.com',
            'user_id' => $this->user->id,
        ]);

        Livewire::test(Developers\Update::class)
            ->call('load', $this->developer->id)
            ->set('form.email', 'joe@doe.com')
            ->call('save')
            ->assertHasErrors(['form.email' => 'unique']);
    });

    test('seniority', function ($rule, $value) {
        Livewire::test(Developers\Update::class)
            ->call('load', $this->developer->id)
            ->set('form.seniority', $value)
            ->call('save')
            ->assertHasErrors(['form.seniority' => $rule]);
    })->with([
        'required' => ['required', ''],
        'in' => ['in', 'invalid-seniority'],
    ]);

    test('skills cannot be empty', function () {
        Livewire::test(Developers\Update::class)
            ->call('load', $this->developer->id)
            ->set('form.name', 'John Doe')
            ->set('form.email', 'joe@doe.com')
            ->set('form.seniority', Seniority::Senior->value)
            ->set('form.skills', [])
            ->call('save')
            ->assertHasErrors(['form.skills' => 'required']);
    });

    test('skills items should exist in database', function () {
        Livewire::test(Developers\Update::class)
            ->call('load', $this->developer->id)
            ->set('form.name', 'John Doe')
            ->set('form.email', 'joe2@doe.com')
            ->set('form.seniority', Seniority::Senior->value)
            ->set('form.skills', [999999])
            ->call('save')
            ->assertHasErrors(['form.skills.0' => 'exists']);
    });
});
