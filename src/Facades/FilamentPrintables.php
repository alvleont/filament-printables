<?php

namespace Alvleont\FilamentPrintables\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Alvleont\FilamentPrintables\FilamentPrintables
 */
class FilamentPrintables extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Alvleont\FilamentPrintables\FilamentPrintables::class;
    }
}
