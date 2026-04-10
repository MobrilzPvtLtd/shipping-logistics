<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShipmentResource\Pages;
use App\Filament\Resources\ShipmentResource\RelationManagers\InvoicesRelationManager;
use App\Filament\Resources\ShipmentResource\RelationManagers\PackagesRelationManager;
use App\Models\Shipment;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\View;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Actions\CreateAction;

class ShipmentResource extends Resource
{
    protected static ?string $model = Shipment::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-truck';

    protected static string|\UnitEnum|null $navigationGroup = 'Logistics';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('tracking_number')
                    ->required()
                    ->maxLength(255),
                TextInput::make('sender_name')
                    ->label('Sender')
                    ->maxLength(255),
                TextInput::make('receiver_name')
                    ->label('Receiver')
                    ->maxLength(255),
                Textarea::make('origin_address')
                    ->label('Origin Address')
                    ->rows(3),
                Textarea::make('destination_address')
                    ->label('Destination Address')
                    ->rows(3),
                View::make('filament.shipments.compliance-documents')
                    ->visible(fn (?string $operation): bool => $operation === 'view')
                    ->columnSpan('full'),
                Select::make('status')
                    ->options([
                        'pending' => '  ',
                        'warehouse_received' => 'Warehouse Received',
                        'in_transit' => 'In Transit',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tracking_number')->sortable()->searchable(),
                TextColumn::make('importer_name')->label('Customer')->sortable()->searchable(),
                TextColumn::make('invoices_count')->counts('invoices')->label('Invoices')->sortable(),
                TextColumn::make('packages_count')->counts('packages')->label('Packages')->sortable(),
                TextColumn::make('status')
                    ->sortable()
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'pending' => 'Submitted',
                        'warehouse_received' => 'Warehouse Received',
                        'in_transit' => 'In Transit',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                        default => $state,
                    }),
                TextColumn::make('created_at')->label('Submitted At')->dateTime()->sortable(),
            ])
            ->headerActions([
                CreateAction::make(),
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
            'index' => Pages\ListShipments::route('/'),
            'create' => Pages\CreateShipment::route('/create'),
            'view' => Pages\ViewShipment::route('/{record}'),
            'edit' => Pages\EditShipment::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            InvoicesRelationManager::class,
            PackagesRelationManager::class,
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('view-shipments') ?? false;
    }

    public static function canView($record): bool
    {
        return auth()->user()?->can('view-shipments') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create-shipments') ?? false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('edit-shipments') ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete-shipments') ?? false;
    }
}



