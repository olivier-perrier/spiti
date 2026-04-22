<?php

namespace App\Filament\Resources\Beneficiaries\Pages;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Models\Beneficiary;
use App\Models\BeneficiaryOQTF;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
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
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('date_notification_48h')->label('Date décision 48h')->toggleable(),
                TextColumn::make('date_notification_15d')->label('Date décision 15h')->toggleable(),
                TextColumn::make('date_appeal')->label('Date recours')->toggleable(),
                TextColumn::make('date_notification_TA')->label('Date notification TA')->toggleable(),
                TextColumn::make('decision_TA')->label('Décision TA')->toggleable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->mutateDataUsing(function ($data) {
                        $data['team_id'] = Filament::getTenant()->id;

                        return $data;
                    }),
            ])
            ->recordActions([
                Action::make('generatePDF')->label('Exporter')
                    ->action('generatePDF')
                    ->icon('heroicon-c-arrow-down-tray'),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function generatePDF()
    {
        $filename = 'oqtf-'.Carbon::now()->format('Y-m-d-H-i-s').'.pdf';

        $data = [
            'user' => auth()->user(),
            'beneficiary' => Beneficiary::first(),
            'oqtf' => BeneficiaryOQTF::first(),
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
