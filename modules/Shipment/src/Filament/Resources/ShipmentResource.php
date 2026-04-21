<?php

namespace Modules\Shipment\Filament\Resources;

use BackedEnum;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Support\Facades\Storage;
use Modules\Shipment\Filament\Resources\Pages\CreateShipment;
use Modules\Shipment\Filament\Resources\Pages\EditShipment;
use Modules\Shipment\Filament\Resources\Pages\ListShipments;
use Modules\Shipment\Filament\Resources\Pages\ViewShipment;
use Modules\Shipment\Models\Shipment;
use UnitEnum;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
class ShipmentResource extends Resource
{
    protected static ?string $model = Shipment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Truck;

    protected static string|UnitEnum|null $navigationGroup = 'Shipments';

    protected static ?int $navigationSort = 2;

    private static function isAdminPanel(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'admin';
    }

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
            Section::make('Packages')
                ->schema([
                    Forms\Components\Repeater::make('packages')
                        ->relationship()
                        ->schema([
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
                            Forms\Components\Textarea::make('condition_notes')
                                ->columnSpanFull(),
                            Forms\Components\FileUpload::make('photos')
                                ->image()
                                ->multiple()
                                ->reorderable()
                                ->disk('public')
                                ->directory('package-photos')
                                ->columnSpanFull(),
                        ])
                        ->columns(2)
                        ->columnSpanFull(),
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
                Tables\Columns\IconColumn::make('bol_filled')
                    ->label('BOL Form')
                    ->state(fn (Shipment $record): bool => filled($record->bill_of_lading_data))
                    ->boolean()
                    ->visible(fn (): bool => static::isAdminPanel()),
                Tables\Columns\IconColumn::make('excise_filled')
                    ->label('Excise Form')
                    ->state(fn (Shipment $record): bool => filled($record->excise_tax_data))
                    ->boolean()
                    ->visible(fn (): bool => static::isAdminPanel()),
                Tables\Columns\TextColumn::make('bill_of_lading_file_path')
                    ->label('BOL')
                    ->formatStateUsing(fn (?string $state): string => filled($state) ? 'Download' : '-')
                    ->url(fn (?string $state): ?string => filled($state) ? Storage::disk('public')->url($state) : null, true)
                    ->visible(fn (): bool => static::isAdminPanel()),
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
            ->actions([
                Action::make('fillDocuments')
                    ->label('Fill Docs')
                    ->icon(Heroicon::PencilSquare)
                    ->visible(fn (Shipment $record): bool => static::isAdminPanel() && static::canEdit($record))
                    ->modalWidth('7xl')
                    ->fillForm(function (Shipment $record): array {
                        return [
                            'awb_bl_number' => $record->awb_bl_number,
                            'bill_of_lading_file_path' => $record->bill_of_lading_file_path,
                            'bill_of_lading_data' => $record->bill_of_lading_data ?? [],
                            'excise_tax_data' => $record->excise_tax_data ?? [],
                        ];
                    })
                    ->form([
                        Tabs::make('Documents')
                            ->tabs([
                                Tab::make('Bill of Lading')
                                    ->icon(Heroicon::DocumentText)
                                    ->schema([
                                        Grid::make(2)->schema([
                                            Forms\Components\TextInput::make('awb_bl_number')
                                                ->label('AWB / BL#')
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('bill_of_lading_data.hbl_number')
                                                ->label('HBL Number')
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('bill_of_lading_data.mbl_number')
                                                ->label('MBL Number')
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('bill_of_lading_data.scac')
                                                ->label('SCAC')
                                                ->maxLength(50),
                                        ]),

                                        Section::make('Parties')->schema([
                                            Grid::make(2)->schema([
                                                Forms\Components\Textarea::make('bill_of_lading_data.shipper')
                                                    ->label('Shipper')
                                                    ->rows(4),
                                                Forms\Components\Textarea::make('bill_of_lading_data.consignee')
                                                    ->label('Consignee')
                                                    ->rows(4),
                                                Forms\Components\Textarea::make('bill_of_lading_data.notify_party')
                                                    ->label('Notify Party')
                                                    ->rows(4),
                                                Forms\Components\Textarea::make('bill_of_lading_data.agent')
                                                    ->label('Agent')
                                                    ->rows(4),
                                            ]),
                                        ]),

                                        Section::make('Routing')->schema([
                                            Grid::make(2)->schema([
                                                Forms\Components\TextInput::make('bill_of_lading_data.place_of_receipt')
                                                    ->label('Place of Receipt')
                                                    ->maxLength(255),
                                                Forms\Components\TextInput::make('bill_of_lading_data.port_of_loading')
                                                    ->label('Port of Loading')
                                                    ->maxLength(255),
                                                Forms\Components\TextInput::make('bill_of_lading_data.port_of_discharge')
                                                    ->label('Port of Discharge')
                                                    ->maxLength(255),
                                                Forms\Components\TextInput::make('bill_of_lading_data.place_of_delivery')
                                                    ->label('Place of Delivery')
                                                    ->maxLength(255),
                                                Forms\Components\TextInput::make('bill_of_lading_data.vessel')
                                                    ->label('Vessel')
                                                    ->maxLength(255),
                                                Forms\Components\TextInput::make('bill_of_lading_data.voyage')
                                                    ->label('Voyage')
                                                    ->maxLength(255),
                                            ]),
                                        ]),

                                        Section::make('Cargo')->schema([
                                            Grid::make(2)->schema([
                                                Forms\Components\TextInput::make('bill_of_lading_data.marks_and_numbers')
                                                    ->label('Marks & Numbers')
                                                    ->maxLength(255),
                                                Forms\Components\TextInput::make('bill_of_lading_data.packages')
                                                    ->label('Packages')
                                                    ->maxLength(255),
                                                Forms\Components\TextInput::make('bill_of_lading_data.gross_weight')
                                                    ->label('Gross Weight')
                                                    ->maxLength(255),
                                                Forms\Components\TextInput::make('bill_of_lading_data.measurement')
                                                    ->label('Measurement')
                                                    ->maxLength(255),
                                                Forms\Components\TextInput::make('bill_of_lading_data.freight')
                                                    ->label('Freight')
                                                    ->maxLength(255),
                                                Forms\Components\TextInput::make('bill_of_lading_data.freight_terms')
                                                    ->label('Freight Terms (Prepaid / Collect)')
                                                    ->maxLength(50),
                                                Forms\Components\Textarea::make('bill_of_lading_data.description_of_goods')
                                                    ->label('Description of Goods')
                                                    ->rows(5)
                                                    ->columnSpanFull(),
                                            ]),
                                        ]),

                                        Section::make('Optional file')->schema([
                                            Forms\Components\FileUpload::make('bill_of_lading_file_path')
                                                ->label('Upload scanned BOL (optional)')
                                                ->disk('public')
                                                ->directory('bill-of-lading')
                                                ->acceptedFileTypes([
                                                    'application/pdf',
                                                    'image/jpeg',
                                                    'image/png',
                                                    'image/tiff',
                                                ]),
                                        ]),
                                    ]),

                                Tab::make('Excise Tax')
                                    ->icon(Heroicon::ReceiptPercent)
                                    ->schema([
                                        Section::make('Header')->schema([
                                            Grid::make(2)->schema([
                                                Forms\Components\TextInput::make('excise_tax_data.form_number')
                                                    ->label('Form')
                                                    ->maxLength(50),
                                                Forms\Components\TextInput::make('excise_tax_data.bureau_no')
                                                    ->label('Bureau No.')
                                                    ->maxLength(100),
                                                Forms\Components\TextInput::make('excise_tax_data.customs_entry_no')
                                                    ->label('Customs Entry No.')
                                                    ->maxLength(100),
                                                Forms\Components\TextInput::make('excise_tax_data.bond_no')
                                                    ->label('Bond No.')
                                                    ->maxLength(100),
                                                Forms\Components\TextInput::make('excise_tax_data.port_of_entry')
                                                    ->label('Port of Entry')
                                                    ->maxLength(255),
                                                Forms\Components\TextInput::make('excise_tax_data.country_of_origin')
                                                    ->label('Country of Origin')
                                                    ->maxLength(255),
                                                Forms\Components\DatePicker::make('excise_tax_data.date_of_importation')
                                                    ->label('Date of Importation'),
                                                Forms\Components\TextInput::make('excise_tax_data.carrier_vessel')
                                                    ->label('Importing Carrier / Vessel')
                                                    ->maxLength(255),
                                                Forms\Components\TextInput::make('excise_tax_data.flight_no_voyage_no')
                                                    ->label('Flight No. / Voyage No.')
                                                    ->maxLength(255),
                                            ]),
                                        ]),

                                        Section::make('Importer')->schema([
                                            Grid::make(2)->schema([
                                                Forms\Components\TextInput::make('excise_tax_data.importer_name')
                                                    ->label('Importer')
                                                    ->maxLength(255),
                                                Forms\Components\TextInput::make('excise_tax_data.ein_ssn')
                                                    ->label('EIN / SSN')
                                                    ->maxLength(100),
                                                Forms\Components\Textarea::make('excise_tax_data.importer_address')
                                                    ->label('Address of Importer (Show Zip Code)')
                                                    ->rows(3)
                                                    ->columnSpanFull(),
                                            ]),
                                        ]),

                                        Section::make('Line items')->schema([
                                            Forms\Components\Repeater::make('excise_tax_data.items')
                                                ->schema([
                                                    Forms\Components\TextInput::make('item_no')
                                                        ->label('Item No.')
                                                        ->maxLength(50),
                                                    Forms\Components\TextInput::make('invoice_no_date')
                                                        ->label('Invoice No. / Date')
                                                        ->maxLength(100),
                                                    Forms\Components\Textarea::make('description')
                                                        ->label('Description of Merchandise')
                                                        ->rows(2)
                                                        ->columnSpanFull(),
                                                    Forms\Components\TextInput::make('value')
                                                        ->label('Value')
                                                        ->maxLength(50),
                                                    Forms\Components\TextInput::make('tax_rate')
                                                        ->label('Tax Rate (%)')
                                                        ->maxLength(50),
                                                    Forms\Components\TextInput::make('tax_due')
                                                        ->label('Tax Due')
                                                        ->maxLength(50),
                                                ])
                                                ->columns(2)
                                                ->defaultItems(1)
                                                ->columnSpanFull(),
                                        ]),

                                        Section::make('Totals & Declaration')->schema([
                                            Grid::make(2)->schema([
                                                Forms\Components\TextInput::make('excise_tax_data.total_tax_due')
                                                    ->label('Total Tax Due')
                                                    ->maxLength(50),
                                                Forms\Components\DatePicker::make('excise_tax_data.declaration_date')
                                                    ->label('Date'),
                                                Forms\Components\TextInput::make('excise_tax_data.prepared_by')
                                                    ->label('Prepared by')
                                                    ->maxLength(255),
                                                Forms\Components\Textarea::make('excise_tax_data.notes')
                                                    ->label('Notes')
                                                    ->rows(3)
                                                    ->columnSpanFull(),
                                            ]),
                                        ]),
                                    ]),
                            ]),
                    ])
                    ->action(function (Shipment $record, array $data): void {
                        $record->update([
                            'awb_bl_number' => $data['awb_bl_number'] ?? $record->awb_bl_number,
                            'bill_of_lading_file_path' => $data['bill_of_lading_file_path'] ?? $record->bill_of_lading_file_path,
                            'bill_of_lading_data' => $data['bill_of_lading_data'] ?? [],
                            'excise_tax_data' => $data['excise_tax_data'] ?? [],
                        ]);
                    }),
                ViewAction::make(),
                EditAction::make(),
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
