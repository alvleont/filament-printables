<?php

namespace Alvleont\FilamentPrintables\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Alvleont\FilamentPrintables\Enums\PrintableTypes;
use Alvleont\FilamentPrintables\Enums\PrintableFormats;

class FilamentPrintable extends Model
{
    use SoftDeletes;

    public function __construct()
    {
        $this->setTable(config('filament-printables.table', 'printables'));
    }

    protected $fillable = [
        'slug',
        'name',
        'type',
        'template_view',
        'linked_resources',
        'format',
    ];

    protected $casts = [
        'linked_resources' => 'array',
        'format' => 'array',
        'type' => PrintableTypes::class,
    ];
}
