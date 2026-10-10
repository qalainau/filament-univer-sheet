<?php

use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;

it('registers the univer sheet script to be loaded on request', function () {
    $script = collect(FilamentAsset::getScripts(['qalainau/filament-univer-sheet']))
        ->first(fn (Js $script): bool => $script->getId() === 'univer-sheet');

    expect($script)->not->toBeNull()
        ->and($script->isLoadedOnRequest())->toBeTrue();
});

it('resolves the univer sheet script url', function () {
    expect(FilamentAsset::getScriptSrc('univer-sheet', 'qalainau/filament-univer-sheet'))
        ->toContain('qalainau/filament-univer-sheet/univer-sheet.js');
});
