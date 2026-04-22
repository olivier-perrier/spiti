<?php

namespace App\Filament\Resources\Partners;

use App\Filament\Resources\Partners\Pages\CreatePartner;
use App\Filament\Resources\Partners\Pages\EditPartner;
use App\Filament\Resources\Partners\Pages\ListPartners;
use App\Filament\Resources\Partners\RelationManagers\CollectiveActionsRelationManager;
use App\Filament\Resources\Partners\RelationManagers\ConventionsRelationManager;
use App\Models\Partner;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static ?string $modelLabel = 'Partenaires';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-c-puzzle-piece';

    protected static string|\UnitEnum|null $navigationGroup = 'Actions collectives';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    TextInput::make('name')->label('Nom')
                        ->required(),
                    Radio::make('type')->label('Type de partenariat')
                        ->options([
                            'right' => 'Droit commun',
                            'association' => 'Association',
                            'other' => 'Autre',
                        ])->inline()->inlineLabel(false)
                        ->required(),
                    TextInput::make('phone')->label('Téléphone'),
                    TextInput::make('website')->label('Site web'),
                    Select::make('range')->label("Champ d'action géographique")
                        ->options([
                            'local' => 'Local',
                            'department' => 'Départemental',
                            'region' => 'Régional',
                            'national' => 'National',
                        ]),
                ])->columns(2)->columnSpan(2),
                Section::make('Adresse')
                    ->relationship('address')
                    ->schema([
                        TextInput::make('country')->label('Pays'),
                        TextInput::make('street')->label('Rue'),
                        TextInput::make('postcode')->label('Code postal'),
                        TextInput::make('city')->label('Ville'),
                    ])->columns(2)->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nom')->sortable()->searchable(),
                TextColumn::make('phone')->label('Téléphone'),
                TextColumn::make('address.full_address')->label('Adresse'),
                // TextColumn::make("theme")->label("Thématique"),
                // TextColumn::make("subtheme")->label("Sous thématique"),
                TextColumn::make('type')->label('Type de partenariat'),
            ])
            ->filters([
                //
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
            ConventionsRelationManager::class,
            CollectiveActionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPartners::route('/'),
            'create' => CreatePartner::route('/create'),
            'edit' => EditPartner::route('/{record}/edit'),
        ];
    }
}
