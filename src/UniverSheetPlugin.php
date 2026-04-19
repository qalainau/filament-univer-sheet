<?php

namespace Because\UniverSheet;

use Filament\Contracts\Plugin;
use Filament\Panel;

class UniverSheetPlugin implements Plugin
{
    protected bool $showToolbar = true;

    protected bool $showFormulaBar = true;

    protected bool $showSheetTabs = true;

    protected string $locale = 'en-US';

    public function getId(): string
    {
        return 'filament-univer-sheet';
    }

    public function register(Panel $panel): void
    {
        //
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }

    public function showToolbar(bool $show = true): static
    {
        $this->showToolbar = $show;

        return $this;
    }

    public function showFormulaBar(bool $show = true): static
    {
        $this->showFormulaBar = $show;

        return $this;
    }

    public function showSheetTabs(bool $show = true): static
    {
        $this->showSheetTabs = $show;

        return $this;
    }

    public function locale(string $locale): static
    {
        $this->locale = $locale;

        return $this;
    }

    public function getShowToolbar(): bool
    {
        return $this->showToolbar;
    }

    public function getShowFormulaBar(): bool
    {
        return $this->showFormulaBar;
    }

    public function getShowSheetTabs(): bool
    {
        return $this->showSheetTabs;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }
}
