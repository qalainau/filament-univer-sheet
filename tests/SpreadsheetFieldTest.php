<?php

use Qalainau\UniverSheet\SpreadsheetField;

it('can be instantiated', function () {
    $field = SpreadsheetField::make('spreadsheet');

    expect($field)->toBeInstanceOf(SpreadsheetField::class);
});

it('has no fixed height by default', function () {
    $field = SpreadsheetField::make('spreadsheet');

    expect($field->getHeight())->toBeNull();
});

it('has default min height', function () {
    $field = SpreadsheetField::make('spreadsheet');

    expect($field->getMinHeight())->toBe('400px');
});

it('can set custom height', function () {
    $field = SpreadsheetField::make('spreadsheet')
        ->height('600px');

    expect($field->getHeight())->toBe('600px');
});

it('can set custom min height', function () {
    $field = SpreadsheetField::make('spreadsheet')
        ->minHeight('300px');

    expect($field->getMinHeight())->toBe('300px');
});

it('shows toolbar by default', function () {
    $field = SpreadsheetField::make('spreadsheet');

    expect($field->getShowToolbar())->toBeTrue();
});

it('can hide toolbar', function () {
    $field = SpreadsheetField::make('spreadsheet')
        ->showToolbar(false);

    expect($field->getShowToolbar())->toBeFalse();
});

it('can toggle formula bar', function () {
    $field = SpreadsheetField::make('spreadsheet')
        ->showFormulaBar(false);

    expect($field->getShowFormulaBar())->toBeFalse();
});

it('can toggle sheet tabs', function () {
    $field = SpreadsheetField::make('spreadsheet')
        ->showSheetTabs(false);

    expect($field->getShowSheetTabs())->toBeFalse();
});
