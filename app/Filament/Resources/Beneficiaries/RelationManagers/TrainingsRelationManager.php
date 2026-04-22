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

class TrainingsRelationManager extends RelationManager
{
    protected static string $relationship = 'trainings';

    protected static ?string $title = 'Formations';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Libellé')
                    ->required(),
                Select::make('type')
                    ->required()
                    ->options([
                        'new_education' => 'Reprise d\'études',
                        'fle_ofii' => 'FLE OFII',
                        'fle_metier' => 'FLE métier',
                        'skill_evaluation' => 'Evaluation des compétences',
                        'first_aid' => 'Formation premiers secours',
                        'CEJ' => 'CEJ',
                        'other' => 'Autre',
                    ]),
                DatePicker::make('start_date')->label('Date de début')
                    ->default(now())
                    ->required(),
                DatePicker::make('end_date')->label('Date de fin'),
                TextInput::make('hours')->label('Nombre d\'heures')
                    ->numeric(),
                Toggle::make('is_active')->label('En cours'),
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
                TextColumn::make('hours')->label('Nombre d\'heures')
                    ->sortable(),
                IconColumn::make('is_active')->label('En cours')
                    ->sortable()
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
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
