<?php

namespace App\Filament\Resources\ShipmentResource\RelationManagers;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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

class PackagesRelationManager extends RelationManager
{
    protected static string $relationship = 'packages';

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $label = 'Package';
    protected static ?string $pluralLabel = 'Packages';
    protected static ?string $title = 'Packages';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
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

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
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
                TextColumn::make('photos')
                    ->label('Photos')
                    ->formatStateUsing(fn ($state) => collect($state ?? [])->count() . ' photo(s)')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Received At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Add Package')
                    ->visible(fn (): bool => $this->hasPackageAccess() || ($this->getCurrentUser()?->can('create-packages') ?? false)),
            ])
            ->actions([
                ViewAction::make()
                    ->visible(fn (?Model $record): bool => $this->hasPackageAccess() || ($this->getCurrentUser()?->can('view-packages') ?? false)),
                EditAction::make()
                    ->visible(fn (?Model $record): bool => $this->hasPackageAccess() || ($this->getCurrentUser()?->can('edit-packages') ?? false)),
                DeleteAction::make()
                    ->visible(fn (?Model $record): bool => $this->hasPackageAccess() || ($this->getCurrentUser()?->can('delete-packages') ?? false)),
            ]);
    }

    protected function getCurrentUser(): ?UserModel
    {
        /** @var UserModel|null $user */
        $user = Auth::user();

        return $user;
    }

    protected function hasPackageAccess(): bool
    {
        return $this->getCurrentUser()?->hasAnyRole(['Super Admin', 'Admin', 'Warehouse Staff']) ?? false;
    }

    protected function canViewAny(): bool
    {
        $user = $this->getCurrentUser();

        return $this->hasPackageAccess() || ($user?->can('view-packages') ?? false);
    }

    protected function canView(Model $record): bool
    {
        $user = $this->getCurrentUser();

        return $this->hasPackageAccess() || ($user?->can('view-packages') ?? false);
    }

    protected function canCreate(): bool
    {
        $user = $this->getCurrentUser();

        return $this->hasPackageAccess() || ($user?->can('create-packages') ?? false);
    }

    protected function canEdit(Model $record): bool
    {
        $user = $this->getCurrentUser();

        return $this->hasPackageAccess() || ($user?->can('edit-packages') ?? false);
    }

    protected function canDelete(Model $record): bool
    {
        $user = $this->getCurrentUser();

        return $this->hasPackageAccess() || ($user?->can('delete-packages') ?? false);
    }
}
