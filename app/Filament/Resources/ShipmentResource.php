<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShipmentResource\Pages;
use App\Filament\Resources\ShipmentResource\RelationManagers\InvoicesRelationManager;
use App\Filament\Resources\ShipmentResource\RelationManagers\PackagesRelationManager;
use App\Models\Shipment;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
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
use Illuminate\Support\Facades\Auth;
use Modules\User\Models\User as UserModel;

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
                Section::make('Bill of Lading')
                    ->description('Admin-only bill of lading entry: structured form or direct PDF upload.')
                    ->schema([
                        Select::make('bill_of_lading_method')
                            ->label('Bill of Lading Entry')
                            ->options([
                                'structured' => 'Structured BL form',
                                'upload' => 'Upload completed BL PDF',
                            ])
                            ->default('structured')
                            ->reactive()
                            ->required()
                            ->visible(fn (): bool => self::getCurrentUser()?->hasAnyRole(['Admin', 'Super Admin']) ?? false),
                        TextInput::make('bill_of_lading_data.bl_number')
                            ->label('B/L Number')
                            ->maxLength(255)
                            ->visible(fn (Get $get): bool => $get('bill_of_lading_method') === 'structured'),
                        DatePicker::make('bill_of_lading_data.bl_date')
                            ->label('B/L Date')
                            ->visible(fn (Get $get): bool => $get('bill_of_lading_method') === 'structured'),
                        TextInput::make('bill_of_lading_data.carrier_name')
                            ->label('Carrier')
                            ->maxLength(255)
                            ->visible(fn (Get $get): bool => $get('bill_of_lading_method') === 'structured'),
                        TextInput::make('bill_of_lading_data.port_of_loading')
                            ->label('Port of Loading')
                            ->maxLength(255)
                            ->visible(fn (Get $get): bool => $get('bill_of_lading_method') === 'structured'),
                        TextInput::make('bill_of_lading_data.port_of_discharge')
                            ->label('Port of Discharge')
                            ->maxLength(255)
                            ->visible(fn (Get $get): bool => $get('bill_of_lading_method') === 'structured'),
                        Textarea::make('bill_of_lading_data.goods_description')
                            ->label('Goods Description')
                            ->rows(4)
                            ->visible(fn (Get $get): bool => $get('bill_of_lading_method') === 'structured'),
                        FileUpload::make('bill_of_lading_pdf')
                            ->label('Bill of Lading PDF')
                            ->directory('bill-of-lading')
                            ->disk('public')
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(10240)
                            ->visible(fn (Get $get): bool => $get('bill_of_lading_method') === 'upload')
                            ->columnSpan('full'),
                    ])
                    ->visible(fn (): bool => self::getCurrentUser()?->hasAnyRole(['Admin', 'Super Admin']) ?? false)
                    ->columnSpan('full'),
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

    protected static function getCurrentUser(): ?UserModel
    {
        /** @var UserModel|null $user */
        $user = Auth::user();

        return $user;
    }

    protected static function hasPrivilegedAccess(): bool
    {
        return self::getCurrentUser()?->hasAnyRole(['Super Admin', 'Admin', 'Warehouse Staff']) ?? false;
    }

    public static function canViewAny(): bool
    {
        $user = self::getCurrentUser();

        return self::hasPrivilegedAccess() || ($user?->can('view-shipments') ?? false);
    }

    public static function canView($record): bool
    {
        $user = self::getCurrentUser();

        return self::hasPrivilegedAccess() || ($user?->can('view-shipments') ?? false);
    }

    public static function canCreate(): bool
    {
        $user = self::getCurrentUser();

        return self::hasPrivilegedAccess() || ($user?->can('create-shipments') ?? false);
    }

    public static function canEdit($record): bool
    {
        $user = self::getCurrentUser();

        return self::hasPrivilegedAccess() || ($user?->can('edit-shipments') ?? false);
    }

    public static function canDelete($record): bool
    {
        $user = self::getCurrentUser();

        return self::hasPrivilegedAccess() || ($user?->can('delete-shipments') ?? false);
    }
}



