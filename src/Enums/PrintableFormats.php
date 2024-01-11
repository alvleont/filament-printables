<?php

namespace Alvleont\FilamentPrintables\Enums;

use Filament\Support\Contracts\HasLabel;

enum PrintableFormats: string implements HasLabel
{

    case xlsx = 'xlsx';
    case pdf = 'pdf';

    public function getLabel(): ?string
    {
        return (__('filament-printables::filament-printables.resource.fields.format.options.' . $this->value));
    }
}
