<?php

namespace App\Filament\Resources\Beneficiaries\Pages;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Beneficiaries\Tables\BeneficiaryOQTFTable;
use App\Models\Beneficiary;
use App\Models\BeneficiaryOQTF;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Storage;
use Throwable;

class EditBeneficiaryOQTF extends ManageRelatedRecords
{
    protected static string $resource = BeneficiaryResource::class;

    protected static string $relationship = 'oqtfs';

    protected static ?string $navigationLabel = 'OQTF';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-m-arrow-small-up';

    public function getTitle(): string|Htmlable
    {
        return 'Bénéficiaire OQTFs';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('date_notification_48h')->label('Date décision 48h')->date()->required(),
                DatePicker::make('date_notification_15d')->label('Date décision 15h')->date(),
                DatePicker::make('date_appeal')->label('Date recours')->date(),
                DatePicker::make('date_notification_TA')->label('Date notification TA')->date(),
                TextInput::make('decision_TA')->label('Décision TA'),
            ]);
    }

    public function table(Table $table): Table
    {
        return BeneficiaryOQTFTable::configure($table);
    }

    public function generatePDF()
    {
        $filename = 'oqtf-'.Carbon::now()->format('Y-m-d-H-i-s').'.pdf';

        $data = [
            'user' => request()->user(),
            'beneficiary' => Beneficiary::query()->first(),
            'oqtf' => BeneficiaryOQTF::query()->first(),
            'date' => Carbon::now()->locale('fr')->toFormattedDateString(),
        ];

        try {

            Pdf::loadView('pdf.oqtf', $data)
                ->save('storage/pdfs/'.$filename);

            Notification::make()->title('Téléchargement OQTF en cours...')->success()->send();

            return Storage::download('pdfs/'.$filename);
        } catch (Throwable $th) {

            Notification::make()->title('Le service actuel ne permet pas la génération de pdf')->danger()->send();

            return;
        }
    }
}
