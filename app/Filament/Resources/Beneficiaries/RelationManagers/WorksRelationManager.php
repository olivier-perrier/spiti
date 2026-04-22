<?php

namespace App\Filament\Resources\Beneficiaries\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WorksRelationManager extends RelationManager
{
    protected static string $relationship = 'works';

    protected static ?string $title = 'Emplois';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Libellé')
                    ->required(),
                Select::make('type')
                    ->required()
                    ->options([
                        'cdd' => 'CDD',
                        'cdi' => 'CDI',
                        'interim' => 'Interim',
                        'freelance' => 'Auto-entrepreneur',
                        'emploi' => 'Emploi',
                        'stage' => 'Stage',
                        'volontariat' => 'Volontariat',
                    ]),
                DatePicker::make('start_date')->label('Date de début')
                    ->default(now())
                    ->required(),
                DatePicker::make('end_date')->label('Date de fin'),
                Toggle::make('is_active')->label('En cours'),
                TextInput::make('location')->label('Lieu de travail')
                    ->maxLength(255),
                Toggle::make('contribution')->label('Cotisation employeur Action logement'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')->label('Libellé')
                    ->searchable()->sortable(),
                TextColumn::make('type')->label('Type')
                    ->searchable()->sortable(),
                TextColumn::make('start_date')->label('Date de début')
                    ->date()
                    ->sortable(),
                TextColumn::make('end_date')->label('Date de fin')
                    ->date()
                    ->sortable(),
                IconColumn::make('is_active')->label('En cours')
                    ->boolean(),
                TextColumn::make('location')->label('Lieu de travail')
                    ->searchable(),
                IconColumn::make('contribution')->label('Cotisation emplyeur AL')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->modalHeading('Ajouter un emploi'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
