<?php

namespace App\Filament\Resources\Beneficiaries\Pages;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Models\BeneficiarySanitary;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EditBeneficiarySanitary extends EditRecord
{
    protected static string $resource = BeneficiaryResource::class;
    // protected static string $resource = BeneficiarySanitary::class;

    protected static ?string $navigationLabel = 'Suivi sanitaire';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-heart';

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
                Section::make('Informations générales')
                    ->relationship('sanitary')
                    ->schema([
                        Group::make([
                            TextInput::make('health_monotoring')->label('Suivi de santé'),
                            DatePicker::make('date_health_check')->label('Date de bilan de santé')->date(),
                            DatePicker::make('date_medical_visit')->label('Date de visite médicale')->date(),
                            DatePicker::make('date_expeted_delivery')->label('Date prévisionnelle accouchement')->date(),
                            TextInput::make('attending_doctor')->label('Médecin traitant'),
                            TextInput::make('comments')->label('Commentaires'),
                        ]),
                        Group::make([
                            Toggle::make('vitale_card')->label('Carte vitale'),
                            Toggle::make('medical_support')->label('Support mdédicale'),
                            Toggle::make('health_issue')->label('Problématique santé à accompagner'),
                            Toggle::make('curatorship')->label('Curatelle'),
                            Toggle::make('guardianship')->label('Tutelle'),
                            Toggle::make('complementary')->label('Complémentaire santé solidaire'),
                            Toggle::make('general_system')->label('Régime général'),
                        ]),
                    ])
                    ->columnSpanFull()
                    ->inlineLabel()
                    ->columns(2)
                    ->compact(true),
            ]);
    }
}
