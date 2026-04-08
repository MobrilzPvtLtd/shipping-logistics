<?php

namespace App\Filament\Resources;

use BackedEnum;
use App\Filament\Resources\PackageResource\Pages;
use App\Models\Package;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Actions\CreateAction;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-cube';

    protected static string|\UnitEnum|null $navigationGroup = 'Logistics';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('shipment_id')
                    ->label('Shipment')
                    ->relationship('shipment', 'tracking_number')
                    ->searchable()
                    ->required(),
                TextInput::make('units')
                    ->label('Units')
                    ->numeric()
                    ->required()
                    ->minValue(1),
                TextInput::make('length_cm')
                    ->label('Length (cm)')
                    ->numeric()
                    ->required()
                    ->minValue(0.1),
                TextInput::make('width_cm')
                    ->label('Width (cm)')
                    ->numeric()
                    ->required()
                    ->minValue(0.1),
                TextInput::make('height_cm')
                    ->label('Height (cm)')
                    ->numeric()
                    ->required()
                    ->minValue(0.1),
                TextInput::make('weight_kg')
                    ->label('Weight (kg)')
                    ->numeric()
                    ->required()
                    ->minValue(0.1),
                Textarea::make('condition_notes')
                    ->label('Condition Notes')
                    ->rows(3),
                FileUpload::make('photos')
                    ->label('Package Photos')
                    ->image()
                    ->multiple()
                    ->maxFiles(10)
                    ->directory('package-photos')
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
                TextColumn::make('units')
                    ->label('Units')
                    ->sortable(),
                TextColumn::make('length_cm')
                    ->label('Length (cm)')
                    ->sortable(),
                TextColumn::make('width_cm')
                    ->label('Width (cm)')
                    ->sortable(),
                TextColumn::make('height_cm')
                    ->label('Height (cm)')
                    ->sortable(),
                TextColumn::make('weight_kg')
                    ->label('Weight (kg)')
                    ->sortable(),
                TextColumn::make('condition_notes')
                    ->label('Condition Notes')
                    ->limit(40),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                CreateAction::make(),
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'view' => Pages\ViewPackage::route('/{record}'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('view-packages') ?? false;
    }

    public static function canView($record): bool
    {
        return auth()->user()?->can('view-packages') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create-packages') ?? false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('edit-packages') ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete-packages') ?? false;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->can('view-packages') ?? false;
    }
}
