<?php

use App\Livewire\Developers;
use App\Models\Developer;
use function Pest\Laravel\assertNotSoftDeleted;

it('should be able to restore a developer', function () {
    $developer = Developer::factory()->create();
    $developer->delete();

    Livewire::test(Developers\Restore::class)
        ->set('developer', $developer)
        ->call('restore');

    assertNotSoftDeleted('developers', [
        'id' => $developer->id,
    ]);
});

test('when confirming we should load the developer and set modal to true', function () {
    $developer = Developer::factory()->create();
    $developer->delete();

    Livewire::test(Developers\Restore::class)
        ->call('confirmAction', $developer->id)
        ->assertSet('developer.id', $developer->id)
        ->assertSet('modal', true);
});

test('after restoring we should dispatch an event to tell the list to reload', function () {
    $developer = Developer::factory()->create();
    $developer->delete();

    Livewire::test(Developers\Restore::class)
        ->set('developer', $developer)
        ->call('restore')
        ->assertDispatched('developer::reload');
});

test('after restoring we should close the modal', function () {
    $developer = Developer::factory()->create();
    $developer->delete();

    Livewire::test(Developers\Restore::class)
        ->set('developer', $developer)
        ->call('restore')
        ->assertSet('modal', false);
});
