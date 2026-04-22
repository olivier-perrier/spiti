<?php

namespace App\Filament\Resources\CollectiveActions;

use App\Filament\Resources\CollectiveActions\Pages\CreateCollectiveAction;
use App\Filament\Resources\CollectiveActions\Pages\EditCollectiveAction;
use App\Filament\Resources\CollectiveActions\Pages\ListCollectiveActions;
use App\Filament\Resources\CollectiveActions\Pages\ViewCollectiveAction;
use App\Filament\Resources\CollectiveActions\RelationManagers\BeneficiariesRelationManager;
use App\Models\CollectiveAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CollectiveActionResource extends Resource
{
    protected static ?string $model = CollectiveAction::class;

    protected static ?string $modelLabel = 'Action collective';

    protected static string|\UnitEnum|null $navigationGroup = 'Actions collectives';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-c-megaphone';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informations')->schema([
                    TextInput::make('name')->label('Intitulé')
                        ->required(),
                    Select::make('dispositif_id')->label('Dispositif')
                        ->relationship('dispositif', 'name')
                        ->required(),
                    Select::make('partners')->label('Partenaires')
                        ->relationship('partners', 'name')
                        ->multiple()
                        ->preload()
                        ->required(),
                    TextInput::make('theme')->label('Thématique'),
                    TextInput::make('subtheme')->label('Sous thématique'),
                    TextInput::make('objectif')->label('Objectifs'),
                    TextInput::make('target')->label('Publique cible'),
                    Textarea::make('description')->label('Description'),
                ])->columns(2),
                Section::make("Mise en oeuvre de l'action")->schema([
                    DatePicker::make('start_date')->label('Date de début'),
                    DatePicker::make('end_date')->label('Date de fin'),
                    TextInput::make('duration')->label('Durée (jours)')
                        ->numeric()->minValue(0),
                    TextInput::make('location')->label('Lieu'),
                    Checkbox::make('mobilisation')->label('Mobilisation partenaire'),
                ])->columns(2),
                Section::make("Bilan de l'action")->schema([
                    TextInput::make('participation')->label('Nombre de participant')
                        ->numeric()->minValue(0),
                    Textarea::make('summary')->label('Bilan'),
                    Radio::make('status')->label('Statut')
                        ->options([
                            'hiring' => 'Embauche',
                            'other' => 'Mise en oeuvre',
                        ])->inline()->inlineLabel(false),

                ])
                    ->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nom')->sortable()->searchable(),
                TextColumn::make('theme')->label('Thème')->toggleable(),
                TextColumn::make('subtheme')->label('Sous thème')->toggleable(),
                TextColumn::make('dispositif.name'),
                TextColumn::make('status'),
            ])
            ->filters([
                //
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
            BeneficiariesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCollectiveActions::route('/'),
            'create' => CreateCollectiveAction::route('/create'),
            'edit' => EditCollectiveAction::route('/{record}/edit'),
            'view' => ViewCollectiveAction::route('/{record}'),
        ];
    }
}
