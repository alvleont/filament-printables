<?php

namespace Alvleont\FilamentPrintables\Actions;

use Alvleont\FilamentPrintables\Models\FilamentPrintable;
use Barryvdh\DomPDF\Facade\Pdf;
use Closure;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Blade;
use Ticketpark\HtmlPhpExcel\HtmlPhpExcel;

class BulkPrintAction extends BulkAction
{
    protected string|Closure $format = '';

    protected int|Closure $printable = 0;

    protected string|array|Closure $recordData = [];

    protected string|Closure|null $icon = 'heroicon-o-printer';

    public static function make(?string $name = 'print'): static
    {
        return parent::make($name);
    }

    protected function setLabel()
    {
        $this->label = __('filament-printables::filament-printables.resource.actions.print');
    }

    protected function setUp(): void
    {
        $this->modalWidth = 'sm';
        $this->action($this->handle(...));
    }

    public function format(string|Closure $format): static
    {
        $this->format = $format;

        return $this;
    }

    public function printable(int|Closure $printable): static
    {
        $this->printable = $printable;

        return $this;
    }

    public function data(string|array|Closure $recordData): static
    {
        $this->recordData = $recordData;

        return $this;
    }

    protected function handle(Collection $records, array $data)
    {

        if ($this->recordData != []) {
            $records = $this->recordData;
        }

        if (isset($data['printable'])) {
            $this->printable = $data['printable'];
        }
        if (isset($data['format'])) {
            $this->format = $data['format'];
        }
        if (! isset($data['printable']) or $this->printable == 0) {
            Notification::make('')->danger()
                ->title(__('filament-printables::filament-printables.resource.notifications.no-template.title'))
                ->body(__('filament-printables::filament-printables.resource.notifications.no-template.description'))
                ->send();
        } else {

            $printable = FilamentPrintable::find($this->printable);
            if ($printable !== null) {
                switch ($this->format) {
                    case 'pdf':

                        return response()->streamDownload(function () use ($printable, $records) {
                            echo Pdf::loadHtml(
                                Blade::render($printable->template_view, ['records' => $records], deleteCachedView: true)
                            )->stream();
                        }, $printable->slug.'-'.date('Y-m-d H:i:s').'.pdf');

                    case 'xlsx':

                        return response()->streamDownload(function () use ($printable, $records) {
                            $htmlPhpExcel = new HtmlPhpExcel(Blade::render($printable->template_view, ['records' => $records], deleteCachedView: true));
                            echo $htmlPhpExcel->process()->output();
                        }, $printable->slug.'-'.date('Y-m-d H:i:s').'.xlsx');
                }
            }
        }
    }

    public function getFormSchema(): array
    {

        if ($this->printable != 0 and $this->format != '') {
            return [];
        }

        $printables = FilamentPrintable::where('type', 'report')->whereJsonContains('linked_resources', $this->getModel())->get();
        if ($printables->count() > 0) {
            return [
                Select::make('printable')
                    ->label(__('filament-printables::filament-printables.resource.fields.template.label'))
                    ->options($printables->pluck('name', 'id')->toArray())
                    ->required()
                    ->reactive()
                    ->autofocus()
                    ->placeholder(__('filament-printables::filament-printables.resource.fields.template.placeholder')),

                Select::make('format')
                    ->label(__('filament-printables::filament-printables.resource.fields.format.label'))
                    ->required()
                    ->options(function ($get) {
                        $options = [];
                        if ($get('printable') != '') {
                            collect(FilamentPrintable::find($get('printable'))?->format)->map(function ($format) use (&$options) {
                                return $options[$format] = __('filament-printables::filament-printables.resource.fields.format.options.'.$format);
                            });
                        }

                        return $options;
                    }),

            ];
        } else {
            return [];
        }
    }
}
