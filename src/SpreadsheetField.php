<?php

namespace Qalainau\UniverSheet;

use Closure;
use Filament\Forms\Components\Field;

class SpreadsheetField extends Field
{
    protected string $view = 'univer-sheet::filament.forms.components.spreadsheet-field';

    protected string|Closure|null $height = null;

    protected string|Closure $minHeight = '400px';

    protected bool|Closure $showToolbar = true;

    protected bool|Closure $showFormulaBar = true;

    protected bool|Closure $showSheetTabs = true;

    protected string|Closure|null $locale = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->default([]);

        $this->afterStateHydrated(function (SpreadsheetField $component, $state): void {
            if (is_string($state)) {
                $component->state(json_decode($state, true));
            }
        });
    }

    public function height(string|Closure|null $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function minHeight(string|Closure $minHeight): static
    {
        $this->minHeight = $minHeight;

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

    public function getHeight(): ?string
    {
        return $this->evaluate($this->height);
    }

    public function getMinHeight(): string
    {
        return $this->evaluate($this->minHeight);
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
