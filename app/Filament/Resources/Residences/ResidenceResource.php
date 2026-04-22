<?php

namespace App\Filament\Resources\Residences;

use App\Filament\Resources\Residences\Pages\CreateResidence;
use App\Filament\Resources\Residences\Pages\EditResidence;
use App\Filament\Resources\Residences\Pages\ListResidences;
use App\Filament\Resources\Residences\Pages\ViewResidence;
use App\Filament\Resources\Residences\RelationManagers\LotsRelationManager;
use App\Models\Residence;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ResidenceResource extends Resource
{
    protected static ?string $model = Residence::class;

    protected static ?string $modelLabel = 'Résidences';

    protected static string|\UnitEnum|null $navigationGroup = 'Structures';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-building-office';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    Select::make('dispositif_id')->label('Dispositif')->required()
                        ->relationship('dispositif', 'name')
                        ->columnSpanFull(),
                    TextInput::make('name')->label('Nom de la résidence')
                        ->required(),
                    Select::make('type_id')->label('Type')->required()
                        ->relationship('type', 'label'),
                    Group::make([
                        Toggle::make('elevator')->label('Ascenseur'),
                        Toggle::make('parking'),
                        TextInput::make('heating')->label('Chauffage'),
                        TextInput::make('public_transport')->label('Accès aux transports en commun'),
                    ]),
                ])->columns(2)->columnSpan(2),
                Section::make('Adresse')
                    ->relationship('address')
                    ->schema([
                        TextInput::make('country')->label('Pays'),
                        TextInput::make('street')->label('Rue'),
                        TextInput::make('postcode')->label('Code postal'),
                        TextInput::make('city')->label('Ville'),
                    ])
                    ->columns(2)
                    ->columnSpan(1),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nom')->sortable()->searchable(),
                TextColumn::make('dispositif.name')->label('Dispositif')->sortable()->searchable()->toggleable(),
                TextColumn::make('address.street')->label('Adresse')->sortable()->searchable()->toggleable(),
                TextColumn::make('type.label')->label('Type')->sortable()->searchable()->toggleable(),
                TextColumn::make('lots_sum_capacity')->sum('lots', 'capacity')->label('Capacité')->sortable()->toggleable(),
                TextColumn::make('tocPourcentage')->label('TOC')->suffix('%')->toggleable()
                    ->badge()
                    ->color(
                        function ($state) {
                            if ($state >= 80) {
                                return 'danger';
                            } elseif ($state >= 60) {
                                return 'warning';
                            } elseif ($state >= 40) {
                                return 'gray';
                            } else {
                                return 'success';
                            }
                        }
                    ),
            ])
            ->filters([
                SelectFilter::make('dispositif')
                    ->relationship('dispositif', 'name'),
                SelectFilter::make('type')
                    ->relationship('type', 'label'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            LotsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListResidences::route('/'),
            'create' => CreateResidence::route('/create'),
            'edit' => EditResidence::route('/{record}/edit'),
            'view' => ViewResidence::route('/{record}'),
        ];
    }
}
