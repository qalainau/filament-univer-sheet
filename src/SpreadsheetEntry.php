<?php

namespace Because\UniverSheet;

use Closure;
use Filament\Infolists\Components\Entry;

class SpreadsheetEntry extends Entry
{
    protected string $view = 'univer-sheet::filament.infolists.entries.spreadsheet-entry';

    protected string|Closure $height = '300px';

    protected bool|Closure $showToolbar = false;

    protected bool|Closure $showFormulaBar = false;

    protected bool|Closure $showSheetTabs = true;

    protected string|Closure|null $locale = null;

    public function height(string|Closure $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function showToolbar(bool|Closure $show = true): static
    {
        $this->showToolbar = $show;

        return $this;
    }

    public function showFormulaBar(bool|Closure $show = true): static
    {
        $this->showFormulaBar = $show;

        return $this;
    }

    public function showSheetTabs(bool|Closure $show = true): static
    {
        $this->showSheetTabs = $show;

        return $this;
    }

    public function getHeight(): string
    {
        return $this->evaluate($this->height);
    }

    public function getShowToolbar(): bool
    {
        return $this->evaluate($this->showToolbar);
    }

    public function getShowFormulaBar(): bool
    {
        return $this->evaluate($this->showFormulaBar);
    }

    public function getShowSheetTabs(): bool
    {
        return $this->evaluate($this->showSheetTabs);
    }

    public function locale(string|Closure $locale): static
    {
        $this->locale = $locale;

        return $this;
    }

    public function getLocale(): string
    {
        return $this->evaluate($this->locale) ?? config('univer-sheet.locale', 'en-US');
    }
}
