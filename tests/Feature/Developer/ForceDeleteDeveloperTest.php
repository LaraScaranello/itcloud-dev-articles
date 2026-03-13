<?php

use App\Livewire\Developers;
use App\Models\Developer;
use function Pest\Laravel\assertDatabaseMissing;

it('should be able to permanently delete an archived developer', function () {
    $developer = Developer::factory()->create();
    $developer->delete();

    Livewire::test(Developers\ForceDelete::class)
        ->set('developer', $developer)
        ->call('delete');

    assertDatabaseMissing('developers', [
        'id' => $developer->id,
    ]);
});

test('when confirming force delete we should load the archived developer and set modal to true', function () {
    $developer = Developer::factory()->create();
    $developer->delete();

    Livewire::test(Developers\ForceDelete::class)
        ->call('confirmAction', $developer->id)
        ->assertSet('developer.id', $developer->id)
        ->assertSet('modal', true);
});

test('after permanently deleting we should dispatch an event to tell the list to reload', function () {
    $developer = Developer::factory()->create();
    $developer->delete();

    Livewire::test(Developers\ForceDelete::class)
        ->set('developer', $developer)
        ->call('delete')
        ->assertDispatched('developer::reload');
});

test('after permanently deleting we should close the modal', function () {
    $developer = Developer::factory()->create();
    $developer->delete();

    Livewire::test(Developers\ForceDelete::class)
        ->set('developer', $developer)
        ->call('delete')
        ->assertSet('modal', false);
});
