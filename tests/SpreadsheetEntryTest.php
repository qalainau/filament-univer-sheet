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
        ->and($entry->getHeight())->toBe('300px');
});

it('can customize settings', function () {
    $entry = SpreadsheetEntry::make('spreadsheet')
        ->showToolbar()
        ->showFormulaBar()
        ->showSheetTabs(false)
        ->height('500px');

    expect($entry->getShowToolbar())->toBeTrue()
        ->and($entry->getShowFormulaBar())->toBeTrue()
        ->and($entry->getShowSheetTabs())->toBeFalse()
        ->and($entry->getHeight())->toBe('500px');
});
