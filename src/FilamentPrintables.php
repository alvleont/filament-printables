<?php

namespace Alvleont\FilamentPrintables;

use Alvleont\FilamentPrintables\Resources\FilamentPrintableResource;
use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentPrintables implements Plugin
{

    public function getId(): string
    {
        return 'blog';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                FilamentPrintableResource::class,
            ])
            ->pages([]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }
}
