<?php

namespace Alvleont\FilamentPrintables;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Alvleont\FilamentPrintables\Commands\FilamentPrintablesCommand;

class FilamentPrintablesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('filament-printables')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_filament-printables_table')
            ->hasCommand(FilamentPrintablesCommand::class);
    }
}
