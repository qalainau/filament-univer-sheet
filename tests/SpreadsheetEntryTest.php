<?php

use Qalainau\UniverSheet\SpreadsheetEntry;

it('can be instantiated', function () {
    $entry = SpreadsheetEntry::make('spreadsheet');

    expect($entry)->toBeInstanceOf(SpreadsheetEntry::class);
});

it('has read-only defaults', function () {
    $entry = SpreadsheetEntry::make('spreadsheet');

    expect($entry->getShowToolbar())->toBeFalse()
        ->and($entry->getShowFormulaBar())->toBeFalse()
        ->and($entry->getShowSheetTabs())->toBeTrue()
        ->and($entry->getShowHeaderBar())->toBeFalse()
        ->and($entry->getShowContextMenu())->toBeFalse()
        ->and($entry->getRibbonType())->toBeNull()
        ->and($entry->getHeight())->toBe('300px');
});

it('can customize settings', function () {
    $entry = SpreadsheetEntry::make('spreadsheet')
        ->showToolbar()
        ->showFormulaBar()
        ->showSheetTabs(false)
        ->showHeaderBar()
        ->showContextMenu()
        ->ribbonType('simple')
        ->height('500px');

    expect($entry->getShowToolbar())->toBeTrue()
        ->and($entry->getShowFormulaBar())->toBeTrue()
        ->and($entry->getShowSheetTabs())->toBeFalse()
        ->and($entry->getShowHeaderBar())->toBeTrue()
        ->and($entry->getShowContextMenu())->toBeTrue()
        ->and($entry->getRibbonType())->toBe('simple')
        ->and($entry->getHeight())->toBe('500px');
});
