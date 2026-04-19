<?php

use Because\UniverSheet\SpreadsheetColumn;

it('can be instantiated', function () {
    $column = SpreadsheetColumn::make('spreadsheet');

    expect($column)->toBeInstanceOf(SpreadsheetColumn::class);
});

it('has default preview settings', function () {
    $column = SpreadsheetColumn::make('spreadsheet');

    expect($column->getPreviewRows())->toBe(4)
        ->and($column->getPreviewColumns())->toBe(4)
        ->and($column->getPreviewHeight())->toBeNull();
});

it('can set custom preview settings', function () {
    $column = SpreadsheetColumn::make('spreadsheet')
        ->previewRows(5)
        ->previewColumns(8)
        ->previewHeight('120px');

    expect($column->getPreviewRows())->toBe(5)
        ->and($column->getPreviewColumns())->toBe(8)
        ->and($column->getPreviewHeight())->toBe('120px');
});
