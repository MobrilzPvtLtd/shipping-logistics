<?php

namespace App\Filament\Resources\ShipmentResource\RelationManagers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\User\Models\User as UserModel;

class InvoicesRelationManager extends RelationManager
{
    protected static string $relationship = 'invoices';

    protected static ?string $recordTitleAttribute = 'invoice_number';

    protected static ?string $label = 'Invoice';
    protected static ?string $pluralLabel = 'Invoices';
    protected static ?string $title = 'Invoices';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('invoice_number')
                    ->label('Invoice Number')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('invoice_date')
                    ->label('Invoice Date')
                    ->required(),
                TextInput::make('currency')
                    ->required()
                    ->maxLength(10),
                TextInput::make('total_invoice_value')
                    ->label('Total Value')
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
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Add Invoice')
                    ->visible(fn (): bool => $this->hasInvoiceAccess() || ($this->getCurrentUser()?->can('create-invoices') ?? false)),
            ])
            ->actions([
                ViewAction::make()
                    ->visible(fn (?Model $record): bool => $this->hasInvoiceAccess() || ($this->getCurrentUser()?->can('view-invoices') ?? false)),
                EditAction::make()
                    ->visible(fn (?Model $record): bool => $this->hasInvoiceAccess() || ($this->getCurrentUser()?->can('edit-invoices') ?? false)),
                DeleteAction::make()
                    ->visible(fn (?Model $record): bool => $this->hasInvoiceAccess() || ($this->getCurrentUser()?->can('delete-invoices') ?? false)),
            ]);
    }

    protected function getCurrentUser(): ?UserModel
    {
        /** @var UserModel|null $user */
        $user = Auth::user();

        return $user;
    }

    protected function hasInvoiceAccess(): bool
    {
        return $this->getCurrentUser()?->hasAnyRole(['Super Admin', 'Admin', 'Warehouse Staff']) ?? false;
    }

    protected function canViewAny(): bool
    {
        $user = $this->getCurrentUser();

        return $this->hasInvoiceAccess() || ($user?->can('view-invoices') ?? false);
    }

    protected function canView(Model $record): bool
    {
        $user = $this->getCurrentUser();

        return $this->hasInvoiceAccess() || ($user?->can('view-invoices') ?? false);
    }

    protected function canCreate(): bool
    {
        $user = $this->getCurrentUser();

        return $this->hasInvoiceAccess() || ($user?->can('create-invoices') ?? false);
    }

    protected function canEdit(Model $record): bool
    {
        $user = $this->getCurrentUser();

        return $this->hasInvoiceAccess() || ($user?->can('edit-invoices') ?? false);
    }

    protected function canDelete(Model $record): bool
    {
        $user = $this->getCurrentUser();

        return $this->hasInvoiceAccess() || ($user?->can('delete-invoices') ?? false);
    }
}
