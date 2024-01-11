<?php

namespace Alvleont\FilamentPrintables\Enums;

use Filament\Support\Contracts\HasLabel;

enum PrintableTypes: string implements HasLabel
{
    case Report = 'report';
    case Form = 'form';
    case Label = 'label';

    public function getLabel(): ?string
    {
        return (__('filament-printables::filament-printables.resource.fields.type.options.' . $this->value));
    }
}
