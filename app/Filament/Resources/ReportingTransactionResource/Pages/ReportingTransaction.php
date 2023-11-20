<?php

namespace App\Filament\Resources\ReportingTransactionResource\Pages;

use App\Exports\TransactionExport;
use App\Filament\Resources\ReportingTransactionResource;
use App\Models\Transaction;
use Filament\Actions\Action;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Resources\Pages\Page;
use Filament\Forms\Form;
use Maatwebsite\Excel\Facades\Excel;

class ReportingTransaction extends Page
{
    use InteractsWithFormActions;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $resource = ReportingTransactionResource::class;

    protected static ?string $navigationLabel = 'Reporting';

    protected static ?string $navigationGroup = 'Reporting';

    protected static string $view = 'filament.resources.transaction-resource.pages.reporting-transaction';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Export Data Transaction By Date')
                    ->schema([
                        DatePicker::make('start_date')
                            ->required(),
                        DatePicker::make('end_date')
                            ->required(),
                    ])

            ])
            ->statePath('data');
    }

    public function submit()
    {
        // SAVE THE SETTINGS HERE
    }

    public function export()
    {
        $this->validate();

        $from = $this->data['start_date'];
        $to = $this->data['end_date'];

        return Excel::download(new TransactionExport($from, $to), "transaction_from_{$from}_to_{$to}.xlsx");
    }
}
