<?php

namespace Alvleont\FilamentPrintables\Commands;

use Illuminate\Console\Command;

class FilamentPrintablesCommand extends Command
{
    public $signature = 'filament-printables';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
