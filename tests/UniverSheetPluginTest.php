<?php

use Because\UniverSheet\UniverSheetPlugin;

it('has correct plugin id', function () {
    $plugin = UniverSheetPlugin::make();

    expect($plugin->getId())->toBe('filament-univer-sheet');
});

it('can configure toolbar visibility', function () {
    $plugin = UniverSheetPlugin::make()
        ->showToolbar(false);

    expect($plugin->getShowToolbar())->toBeFalse();
});

it('can configure locale', function () {
    $plugin = UniverSheetPlugin::make()
        ->locale('ja-JP');

    expect($plugin->getLocale())->toBe('ja-JP');
});

it('has sensible defaults', function () {
    $plugin = UniverSheetPlugin::make();

    expect($plugin->getShowToolbar())->toBeTrue()
        ->and($plugin->getShowFormulaBar())->toBeTrue()
        ->and($plugin->getShowSheetTabs())->toBeTrue()
        ->and($plugin->getLocale())->toBe('en-US');
});
