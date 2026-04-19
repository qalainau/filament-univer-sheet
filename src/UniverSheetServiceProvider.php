<?php

namespace Qalainau\UniverSheet;

use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class UniverSheetServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-univer-sheet';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasConfigFile('univer-sheet')
            ->hasTranslations()
            ->hasViews('univer-sheet');
    }

    public function packageBooted(): void
    {
        FilamentAsset::register([
            Js::make(
                'univer-sheet',
                __DIR__.'/../resources/js/dist/univer-sheet.js',
            ),
            Css::make(
                'univer-sheet-styles',
                __DIR__.'/../resources/css/univer-sheet.css',
            ),
        ], package: 'qalainau/filament-univer-sheet');
    }
}
