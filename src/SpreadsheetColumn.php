<?php

namespace Because\UniverSheet;

use Closure;
use Filament\Tables\Columns\Column;

class SpreadsheetColumn extends Column
{
    protected string $view = 'univer-sheet::filament.tables.columns.spreadsheet-column';

    protected int|Closure $previewRows = 4;

    protected int|Closure $previewColumns = 4;

    protected string|Closure|null $previewHeight = null;

    public function previewRows(int|Closure $rows): static
    {
        $this->previewRows = $rows;

        return $this;
    }

    public function previewColumns(int|Closure $columns): static
    {
        $this->previewColumns = $columns;

        return $this;
    }

    public function previewHeight(string|Closure|null $height): static
    {
        $this->previewHeight = $height;

        return $this;
    }

    public function getPreviewRows(): int
    {
        return $this->evaluate($this->previewRows);
    }

    public function getPreviewColumns(): int
    {
        return $this->evaluate($this->previewColumns);
    }

    public function getPreviewHeight(): ?string
    {
        return $this->evaluate($this->previewHeight);
    }

    public function getState(): mixed
    {
        $state = parent::getState();

        if (is_string($state)) {
            return json_decode($state, true);
        }

        return $state;
    }
}
