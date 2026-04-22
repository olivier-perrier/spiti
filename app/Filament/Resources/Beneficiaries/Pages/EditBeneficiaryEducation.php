<?php

namespace App\Filament\Resources\Beneficiaries\Pages;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;

class EditBeneficiaryEducation extends EditRecord
{
    protected static string $resource = BeneficiaryResource::class;

    protected static ?string $navigationLabel = 'Niveau de formation';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-c-briefcase';

    public function getTitle(): string|Htmlable
    {
        return $this->getRecordTitle().' - '.static::$navigationLabel;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function form(Schema $schema): Schema
    {
        // dd($this->record->education->beneficiary->name);
        $school_level = [
            'Aucun',
            'Niveau 3 : CAP, BEP',
            'Niveau 4 : Bac',
            'Niveau 5 : Bac+2 (BTS, DUT)',
            'Niveau 6 : Bac+3 (Licence, Master1)',
            'Niveau 7 : Bac+5 (Master, ingenieur)',
            'Niveau 8 : Doctorat',
        ];

        $language_level = [
            'Francophone',
            'Non francophone - Maitrise de la langue',
            'Non francophone - Notions',
            "Non francophone - Besoin d'interprète",
        ];

        $french_level = [
            'DELF/DALF A1',
            'DELF/DALF A2',
            'DELF/DALF B1',
            'DELF/DALF B2',
            'DELF/DALF C1',
            'DELF/DALF C2',
        ];

        return $schema
            ->components([
                Section::make('Informations générales')
                    ->relationship('education')
                    ->schema([
                        Select::make('school_level')->label('Niveau scolaire')
                            ->options($school_level),
                        TextInput::make('diploma')->label('Diplôme(s)'),
                        TextInput::make('languages')->label('Langues parlée(s)'),
                        TextInput::make('equivalence_ENIC')->label('Equivalence (ENIC/NARIC)'),
                    ])->columnSpan(1)->compact(),
                Section::make('Maîtrise du français')
                    ->relationship('education')
                    ->schema([
                        Select::make('french_oral_level')->label('Oral')
                            ->options($language_level),
                        Select::make('french_written_level')->label('Ecrit')
                            ->options($language_level),
                        Select::make('french_diploma_level')->label('Niveau')
                            ->options($french_level),
                        DatePicker::make('date_french_diploma')->label("Date d'obtention"),
                    ])->columnSpan(1)->compact(),
                Section::make('Informations concernant les mineurs')
                    ->relationship('education')
                    ->schema([
                        TextInput::make('school_situation')->label('Situation scolaire'),
                        TextInput::make('school_name')->label("Nom de l'établissement"),
                        TextInput::make('reason_no_school')->label('Motif de non scolarisation'),
                        Checkbox::make('special_class')->label('Classe spécialisée'),
                        Grid::make(1)
                            ->relationship('address')
                            ->schema([
                                TextInput::make('street')->label("Adresse de l'établissement"),
                                TextInput::make('city')->label('Ville'),
                            ]),
                    ])->columnSpan(1)->compact(),
            ])->columns(2)->inlineLabel();
    }
}
