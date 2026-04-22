<?php

namespace App\Filament\Resources\Dispositifs;

use App\Filament\Resources\Dispositifs\Pages\CreateDispositif;
use App\Filament\Resources\Dispositifs\Pages\EditDispositif;
use App\Filament\Resources\Dispositifs\Pages\ListDispositifs;
use App\Filament\Resources\Dispositifs\Pages\ViewDispositif;
use App\Filament\Resources\Dispositifs\RelationManagers\ResidencesRelationManager;
use App\Models\Dispositif;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DispositifResource extends Resource
{
    protected static ?string $model = Dispositif::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Structures';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-building-office-2';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    TextInput::make('name')->label('Nom du dispositif')
                        ->required(),
                    Select::make('type_id')->label('Type')->required()
                        ->relationship('type', 'label'),
                    TextInput::make('finess_number')->label('N° finess')
                        ->numeric()->required(),
                    Group::make([
                        DatePicker::make('opening_date')->label("Date d'ouverture")
                            ->required(),
                        DatePicker::make('closing_date')->label('Date de fermeture'),
                    ])->columns(2)->columnSpanFull(),
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
                TextColumn::make('address.street')->label('Adresse')->sortable()->searchable()->toggleable(),
                TextColumn::make('type.label')->sortable()->searchable()->toggleable(),
                TextColumn::make('finess_number')->label('N° finess')->sortable()->searchable()->toggleable(),
                TextColumn::make('opening_date')->label("Date d'ouverture")->sortable()->searchable()->toggleable(),
                TextColumn::make('lots_count')->counts('lots')->label('Nombre de lot')->sortable()->toggleable(),
                TextColumn::make('lots_sum_capacity')->sum('lots', 'capacity')->label('Places')->sortable()->toggleable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->relationship('type', 'label'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
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
            ResidencesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDispositifs::route('/'),
            'create' => CreateDispositif::route('/create'),
            'edit' => EditDispositif::route('/{record}/edit'),
            'view' => ViewDispositif::route('/{record}'),
        ];
    }
}
