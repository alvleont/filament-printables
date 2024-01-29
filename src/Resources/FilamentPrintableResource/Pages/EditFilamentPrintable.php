<?php

namespace Alvleont\FilamentPrintables\Resources\FilamentPrintableResource\Pages;

use Alvleont\FilamentPrintables\Resources\FilamentPrintableResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFilamentPrintable extends EditRecord
{
    protected static string $resource = FilamentPrintableResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
