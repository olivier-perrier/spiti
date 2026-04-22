<?php

namespace App\Filament\Resources\Conventions;

use App\Filament\Resources\Conventions\Pages\CreateConvention;
use App\Filament\Resources\Conventions\Pages\EditConvention;
use App\Filament\Resources\Conventions\Pages\ListConventions;
use App\Models\Convention;
use App\Models\Type;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ConventionResource extends Resource
{
    protected static ?string $model = Convention::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-m-globe-alt';

    protected static string|\UnitEnum|null $navigationGroup = 'Actions collectives';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Intitulé')
                    ->required(),
                Select::make('dispositif_id')->label('Dispositif')
                    ->relationship('dispositif', 'name')
                    ->required(),
                Select::make('partner_id')->label('Partenaire')
                    ->relationship('partner', 'name')
                    ->required(),
                DatePicker::make('signature_date')->label('Date signature'),
                DatePicker::make('start_date')->label('Date de début')
                    ->required(),
                DatePicker::make('end_date')->label('Date de fin')
                    ->required(),
                Select::make('theme')->label('Thématique')
                    ->options([
                        'acces_right' => 'Accès au droits',
                        'houssing' => 'Hébergement',
                        'professionnal_insersion' => 'Insertion professionnelle',
                    ]),
                Select::make('subtheme')->label('Sous thématique')
                    ->options([
                        'houssing_appropriation' => 'Appropriation du logement',
                        'information' => 'Information, Sensibilisation',
                        'other' => 'Autre (Parcours logement)',
                    ]),
                Radio::make('status_id')->label('Statut')
                    ->options(Type::ofConventionStatus()->pluck('label', 'id'))
                    ->inline()->inlineLabel(false),
                Radio::make('funding')->label('Financement sollicité')
                    ->boolean()->inline()->inlineLabel(false),
                TextInput::make('goals')->label('Objectifs'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Intitulé')->sortable()->searchable(),
                TextColumn::make('start_date')->label('Date de début')->sortable()->toggleable(),
                TextColumn::make('end_date')->label('Date de fin')->sortable()->toggleable(),
                TextColumn::make('dispositif.name')->label('Dispositif')->sortable(),
                TextColumn::make('status.label')->label('Status')->sortable(),
            ])
            ->filters([
                SelectFilter::make('dispositif_id')->label('Dispositif')
                    ->relationship('dispositif', 'name'),
                SelectFilter::make('status_id')->label('Statut')
                    ->relationship('status', 'label'),
            ])
            ->recordActions([
                ViewAction::make()
                    ->modalHeading(fn (Convention $record) => 'Convention '.$record->name),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListConventions::route('/'),
            'create' => CreateConvention::route('/create'),
            'edit' => EditConvention::route('/{record}/edit'),
        ];
    }
}
