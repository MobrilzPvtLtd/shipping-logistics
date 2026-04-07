<?php

namespace App\Filament\Resources\ShipmentResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class InvoicesRelationManager extends RelationManager
{
    protected static string $relationship = 'invoices';

    protected static ?string $recordTitleAttribute = 'invoice_number';

    protected static ?string $label = 'Invoice';
    protected static ?string $pluralLabel = 'Invoices';
    protected static ?string $title = 'Invoices';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')
                    ->label('Invoice Number')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('invoice_date')
                    ->label('Invoice Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('currency')
                    ->label('Currency')
                    ->sortable(),
                TextColumn::make('total_invoice_value')
                    ->label('Total Value')
                    ->sortable(),
                TextColumn::make('file_path')
                    ->label('File Path')
                    ->limit(30),
            ]);
    }
}
