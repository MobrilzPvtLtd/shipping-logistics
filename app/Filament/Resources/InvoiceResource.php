<?php

namespace App\Filament\Resources;

use BackedEnum;
use App\Filament\Resources\InvoiceResource\Pages;
use App\Models\Invoice;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-document-text';

    protected static string|\UnitEnum|null $navigationGroup = 'Logistics';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('shipment_id')
                    ->label('Shipment')
                    ->relationship('shipment', 'tracking_number')
                    ->searchable()
                    ->required(),
                TextInput::make('invoice_number')
                    ->label('Invoice Number')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('invoice_date')
                    ->label('Invoice Date')
                    ->required(),
                TextInput::make('currency')
                    ->label('Currency')
                    ->required()
                    ->maxLength(10),
                TextInput::make('total_invoice_value')
                    ->label('Total Invoice Value')
                    ->numeric()
                    ->required(),
                Textarea::make('commodity_description')
                    ->label('Commodity Description')
                    ->rows(3),
                TextInput::make('hs_code')
                    ->label('HS Code')
                    ->maxLength(255),
                TextInput::make('country_of_manufacture')
                    ->label('Country of Manufacture')
                    ->maxLength(255),
                TextInput::make('quantity')
                    ->label('Quantity')
                    ->maxLength(255),
                TextInput::make('uom')
                    ->label('Unit of Measure')
                    ->maxLength(100),
                TextInput::make('unit_price')
                    ->label('Unit Price')
                    ->numeric(),
                TextInput::make('line_total')
                    ->label('Line Total')
                    ->numeric(),
                FileUpload::make('file_path')
                    ->label('Invoice File')
                    ->directory('invoice-files')
                    ->disk('public'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('shipment.tracking_number')
                    ->label('Shipment')
                    ->sortable()
                    ->searchable(),
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
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'view' => Pages\ViewInvoice::route('/{record}'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('view-invoices') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create-invoices') ?? false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('edit-invoices') ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete-invoices') ?? false;
    }
}
