<?php

use App\Livewire\Developers;
use App\Models\Developer;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertSoftDeleted;

beforeEach(function () {
    $this->user = User::factory()->create();

    actingAs($this->user);
});

it('should be able to archive a developer', function () {
    $developer = Developer::factory()->create([
        'user_id' => $this->user->id,
    ]);

    Livewire::test(Developers\Archive::class)
        ->set('developer', $developer)
        ->call('archive');

    assertSoftDeleted('developers', [
        'id' => $developer->id,
    ]);
});

test('when confirming we should load the developer and set modal to true', function () {
    $developer = Developer::factory()->create([
        'user_id' => $this->user->id,
    ]);

    Livewire::test(Developers\Archive::class)
        ->call('confirmAction', $developer->id)
        ->assertSet('developer.id', $developer->id)
        ->assertSet('modal', true);
});

test('after archiving we should dispatch an event to tell the list to reload', function () {
    $developer = Developer::factory()->create([
        'user_id' => $this->user->id,
    ]);

    Livewire::test(Developers\Archive::class)
        ->set('developer', $developer)
        ->call('archive')
        ->assertDispatched('developer::reload');
});

test('after archiving we should close the modal', function () {
    $developer = Developer::factory()->create([
        'user_id' => $this->user->id,
    ]);

    Livewire::test(Developers\Archive::class)
        ->set('developer', $developer)
        ->call('archive')
        ->assertSet('modal', false);
});

it('should list archived items', function () {
    Developer::factory()->count(2)->create([
        'user_id' => $this->user->id,
    ]);

    $archived = Developer::factory()->create([
        'user_id' => $this->user->id,
    ]);
    $archived->delete();

    Livewire::test(Developers\Index::class)
        ->set('search_trash', false)
        ->assertViewHas('developers', function (LengthAwarePaginator $items) use ($archived) {
            expect($items->items())->toHaveCount(2)
                ->and(
                    collect($items->items())
                        ->filter(fn (Developer $developer) => $developer->id === $archived->id)
                )->toBeEmpty();

            return true;
        })
        ->set('search_trash', true)
        ->assertViewHas('developers', function (LengthAwarePaginator $items) use ($archived) {
            expect($items->items())->toHaveCount(1)
                ->and(
                    collect($items->items())
                        ->filter(fn (Developer $developer) => $developer->id === $archived->id)
                )->not->toBeEmpty();

            return true;
        });
});
