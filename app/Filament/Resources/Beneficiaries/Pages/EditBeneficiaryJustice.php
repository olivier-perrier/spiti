<?php

namespace App\Filament\Resources\Beneficiaries\Pages;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EditBeneficiaryJustice extends EditRecord
{
    protected static string $resource = BeneficiaryResource::class;

    protected static ?string $navigationLabel = 'Suivi justice';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-s-building-library';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Détention')
                    ->relationship('justice')
                    ->schema([
                        TextInput::make('orienteer')->label('Orienteur'),
                        TextInput::make('cpip')->label('CPIP'),
                        TextInput::make('dentention_place')->label('Lieu de détention'),
                        DatePicker::make('detention_start')->label("Date d'entré en détention")->date(),
                        DatePicker::make('date_cap')->label('Date CAP')->date(),
                        DatePicker::make('detention_end')->label('Date de sortie de détention')->date(),
                        TextInput::make('court_procedure')->label('Mesure justice'),
                        TextInput::make('procedure_duration')->label('Durée de la mesure'),
                    ])
                    ->columnSpan(1)
                    ->inlineLabel()
                    ->compact(true),
                Section::make('Obligations')
                    ->relationship('justice')
                    ->schema([
                        CheckboxList::make('obligations')
                            ->options([
                                'health' => 'De soin',
                                'work' => 'De travail',
                                'commissariat' => 'De pointer au commissariat',
                                'bar' => 'BAR',
                            ]),
                        CheckboxList::make('prohibitions')->label('Interdictions')
                            ->options([
                                'weapon' => "Port d'arme",
                                'victim' => 'Contact victime',
                                'territory' => 'Territoire',
                            ]),
                        DatePicker::make('date_adjustment_request')->label('Date demande aménagement peine')->date(),
                        Toggle::make('adjustment_refused')->label('Aménagement refusé'),
                        TextInput::make('adjustment_description')->label('Aménagement de peine'),
                        TextInput::make('adjustment_durantion')->label('Durée aménagement'),
                        Toggle::make('tig_compelled')->label("Travaux d'intérêt généraux"),
                        TextInput::make('internship')->label('Stage'),
                    ])
                    ->compact()
                    ->inlineLabel()
                    ->columnSpan(1),
            ])->columns(2);
    }
}
