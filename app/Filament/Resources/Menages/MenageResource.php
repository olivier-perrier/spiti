<?php

namespace App\Filament\Resources\Menages;

use App\Filament\Resources\Menages\Pages\CreateMenage;
use App\Filament\Resources\Menages\Pages\EditMenage;
use App\Filament\Resources\Menages\Pages\ListMenages;
use App\Filament\Resources\Menages\Pages\ViewMenage;
use App\Filament\Resources\Menages\RelationManagers\BeneficiariesRelationManager;
use App\Models\Menage;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MenageResource extends Resource
{
    protected static ?string $model = Menage::class;

    protected static ?string $modelLabel = 'Ménages';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-s-user-group';

    protected static string|\UnitEnum|null $navigationGroup = 'Hébergés';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)->schema([

                    Section::make()->schema([
                        TextInput::make('name')->label('Nom')->required(),

                        DatePicker::make('date_entry')->label("Date d'entrée dans dispositif"),
                        Checkbox::make('has_social_right')->label('Eligible aux droits sociaux'),
                        TextInput::make('badge_key')->label('Badge / Clef'),
                        Grid::make()->schema([
                            Checkbox::make('animal')->label('Animal de compagnie'),
                            TextInput::make('animal_type')->label('Espèce'),
                        ])->columns(2)->columnSpan(1),
                    ])->columns(2)->columnSpan(2),
                    Group::make([
                        Section::make('Adresse')
                            ->relationship('address')
                            ->schema([
                                TextInput::make('country')->label('Pays'),
                                TextInput::make('street')->label('Rue'),
                                TextInput::make('postcode')->label('Code postal'),
                                TextInput::make('city')->label('Ville'),
                            ])->columns(2)->columnSpan(1),
                        Section::make('Associations')->schema([
                            Select::make('dispositif_id')->label('Dispositif')
                                ->relationship('dispositif', 'name'),
                            Select::make('referent_id')
                                ->relationship('referent', 'name'),
                        ])->columnSpan(1),
                    ]),
                ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nom')->searchable(isIndividual: true)->sortable(),
                TextColumn::make('referent.name')->label('Référent')->searchable(isIndividual: true)->sortable(),
                TextColumn::make('dispositif.name')->label('Dispositif')->searchable(isIndividual: true)->sortable(),
                TextColumn::make('address.street')->label('Adresse')->searchable(isIndividual: true)->sortable(),
                TextColumn::make('beneficiaries_count')->label('Bénéficiaires')->sortable()
                    ->counts('beneficiaries'),
            ])
            ->filters([
                Filter::make('no_beneficiairy')->label('Ménage sans bénéficiaire')
                    ->query(fn (Builder $query): Builder => $query->whereDoesntHave('beneficiaries')),
                SelectFilter::make('dispositf')->label('Dispositif')
                    ->relationship('dispositif', 'name'),
            ])
            ->recordActions([
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
            BeneficiariesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMenages::route('/'),
            'create' => CreateMenage::route('/create'),
            'edit' => EditMenage::route('/{record}/edit'),

            'view' => ViewMenage::route('/{record}'),
        ];
    }
}
