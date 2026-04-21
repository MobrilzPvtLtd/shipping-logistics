<?php

namespace Modules\Package\Filament\Resources;

use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Package\Filament\Resources\Pages\CreatePackage;
use Modules\Package\Filament\Resources\Pages\EditPackage;
use Modules\Package\Filament\Resources\Pages\ListPackages;
use Modules\Package\Filament\Resources\Pages\ViewPackage;
use Modules\Package\Models\Package;
use UnitEnum;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArchiveBox;

    protected static string|UnitEnum|null $navigationGroup = 'Shipments';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Package Details')
                ->schema([
                    Grid::make(2)->schema([
                        Forms\Components\Select::make('shipment_id')
                            ->relationship('shipment', 'invoice_number')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\TextInput::make('units')
                            ->required()
                            ->numeric()
                            ->minValue(1),

                        Forms\Components\TextInput::make('length_cm')
                            ->required()
                            ->numeric()
                            ->step('0.01'),

                        Forms\Components\TextInput::make('width_cm')
                            ->required()
                            ->numeric()
                            ->step('0.01'),

                        Forms\Components\TextInput::make('height_cm')
                            ->required()
                            ->numeric()
                            ->step('0.01'),

                        Forms\Components\TextInput::make('weight_kg')
                            ->required()
                            ->numeric()
                            ->step('0.01'),
                    ]),

                    Forms\Components\Textarea::make('condition_notes')
                        ->columnSpanFull(),

                    Forms\Components\FileUpload::make('photos')
                        ->image()
                        ->multiple()
                        ->reorderable()
                        ->disk('public')
                        ->directory('package-photos')
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('shipment.invoice_number')
                    ->label('Shipment Invoice')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('units')
                    ->sortable(),
                Tables\Columns\TextColumn::make('length_cm')
                    ->label('L (cm)'),
                Tables\Columns\TextColumn::make('width_cm')
                    ->label('W (cm)'),
                Tables\Columns\TextColumn::make('height_cm')
                    ->label('H (cm)'),
                Tables\Columns\TextColumn::make('weight_kg')
                    ->label('Weight (kg)'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPackages::route('/'),
            'create' => CreatePackage::route('/create'),
            'view' => ViewPackage::route('/{record}'),
            'edit' => EditPackage::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
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
}

