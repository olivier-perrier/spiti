<?php

namespace App\Filament\Resources\Lots;

use App\Filament\Resources\Lots\Pages\CreateLot;
use App\Filament\Resources\Lots\Pages\EditLot;
use App\Filament\Resources\Lots\Pages\ListLots;
use App\Filament\Resources\Lots\Pages\ViewLot;
use App\Filament\Resources\Lots\RelationManagers\BenficiariesRelationManager;
use App\Models\Lot;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LotResource extends Resource
{
    protected static ?string $model = Lot::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Structures';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cube';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)->schema([
                    Section::make([
                        TextInput::make('number')->label('N° lot')
                            ->required()
                            ->numeric()->minValue(0),
                        Select::make('type_id')->label('Type')->required()
                            ->relationship('type', 'label'),
                        TextInput::make('surface')->label('Surface')
                            ->numeric()->minValue(0),
                        TextInput::make('capacity')->label('Capacité')
                            ->numeric()->minValue(0),
                        TextInput::make('agreed_capacity')->label('Capacité conventionnée')
                            ->numeric()->minValue(0),
                        TextInput::make('building')->label('Batiment'),
                        TextInput::make('floor')->label('Etage')
                            ->numeric()->minValue(0),
                        Toggle::make('PMR')->label('Logement adapté PMR'),
                    ])->columns(2)->columnSpan(2),
                    Section::make('Adresse')
                        ->relationship('address')
                        ->schema([
                            TextInput::make('country')->label('Pays'),
                            TextInput::make('street')->label('Rue'),
                            TextInput::make('postcode')->label('Code postal'),
                            TextInput::make('city')->label('Ville'),
                        ])->columns(2)->columnSpan(1),
                    // Select::make("beneficiaries")->label("Bénéficiaires")
                    //     ->relationship("beneficiaries", "name")
                    //     ->saveRelationshipsUsing(fn ($record) => dd($record))
                    //     ->multiple()
                    //     ->searchable()
                    //     ->preload()
                    //     ->columnSpanFull(),
                ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->withCount('beneficiaries'))
            ->columns([
                TextColumn::make('number')->label('N° lot')->sortable()->searchable(),
                TextColumn::make('residence.dispositif.name')->label('Dispositif')->sortable()->searchable()->toggleable(),
                TextColumn::make('type.label')->label('Typologie')->sortable()->toggleable(),
                TextColumn::make('surface')->label('Surface')->sortable()->toggleable(),
                TextColumn::make('capacity')->label('Capacité')->sortable()->toggleable(),
                TextColumn::make('building')->label('Batiment')->sortable()->toggleable(),
                TextColumn::make('floor')->label('Etage')->sortable()->toggleable(),
                IconColumn::make('PMR')->label('PMR')->boolean(true)->sortable()->toggleable(),
                TextColumn::make('beneficiaries_count')->label('Bénéficiaires')->counts('beneficiaries')->sortable(),
                TextColumn::make('tocPourcentage')->label('TOC')->suffix('%'),
            ])
            ->filters([
                SelectFilter::make('dispositif')
                    ->relationship('dispositifs', 'name'),
                SelectFilter::make('residence')->label('Résidence')
                    ->relationship('residence', 'name'),
                SelectFilter::make('type')->label('Typologie')
                    ->relationship('type', 'label'),
                Filter::make('availability')->label('Place(s) disponible(s)')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->availability()),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                ReplicateAction::make()
                    ->modalHeading(fn ($record) => 'Dupliquer le lot n°'.$record->number)
                    ->excludeAttributes(['beneficiaries_count']),
                DeleteAction::make()
                    ->disabled(fn (Lot $record) => $record->beneficiaries_count > 0),
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
            BenficiariesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLots::route('/'),
            'create' => CreateLot::route('/create'),
            'edit' => EditLot::route('/{record}/edit'),
            'view' => ViewLot::route('/{record}'),
        ];
    }
}
