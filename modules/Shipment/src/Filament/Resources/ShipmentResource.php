<?php

namespace Modules\Shipment\Filament\Resources;

use BackedEnum;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables;
use Modules\Shipment\Filament\Resources\Pages\CreateShipment;
use Modules\Shipment\Filament\Resources\Pages\EditShipment;
use Modules\Shipment\Filament\Resources\Pages\ListShipments;
use Modules\Shipment\Filament\Resources\Pages\ViewShipment;
use Modules\Shipment\Models\Shipment;
use UnitEnum;

class ShipmentResource extends Resource
{
    protected static ?string $model = Shipment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Truck;

    protected static string|UnitEnum|null $navigationGroup = 'Shipments';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Shipment Details')
                ->schema([
                    Grid::make(2)->schema([
                    Forms\Components\TextInput::make('invoice_number')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\DatePicker::make('invoice_date')
                        ->required(),
                    Forms\Components\TextInput::make('exporter_name')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('consignee_name')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('total_invoice_value')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Select::make('user_id')
                        ->relationship('user', 'name')
                        ->required()
                        ->searchable(),
                ]),
                Forms\Components\Textarea::make('exporter_address')
                    ->columnSpan('full'),
                Forms\Components\Textarea::make('consignee_address')
                    ->columnSpan('full'),
                Forms\Components\Textarea::make('terms_of_sale')
                    ->columnSpan('full'),
                Forms\Components\Textarea::make('other_info')
                    ->columnSpan('full'),
                Forms\Components\Repeater::make('commodities')
                    ->label('Commodities')
                    ->schema([
                        Forms\Components\TextInput::make('description')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('quantity')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('gross_weight')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('value')
                            ->maxLength(255),
                    ])
                    ->columns(2)
                    ->defaultItems(1)
                    ->minItems(1)
                    ->columnSpan('full'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('invoice_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('exporter_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('consignee_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_invoice_value')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Owner')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                // Add filters here if needed
            ])
            ->defaultSort('invoice_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListShipments::route('/'),
            'create' => CreateShipment::route('/create'),
            'view' => ViewShipment::route('/{record}'),
            'edit' => EditShipment::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
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
