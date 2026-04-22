<?php

namespace App\Filament\Resources\Beneficiaries;

use App\Filament\Resources\Beneficiaries\Pages\CreateBeneficiary;
use App\Filament\Resources\Beneficiaries\Pages\EditBeneficiary;
use App\Filament\Resources\Beneficiaries\Pages\EditBeneficiaryEducation;
use App\Filament\Resources\Beneficiaries\Pages\EditBeneficiaryJustice;
use App\Filament\Resources\Beneficiaries\Pages\EditBeneficiaryOQTF;
use App\Filament\Resources\Beneficiaries\Pages\EditBeneficiarySanitary;
use App\Filament\Resources\Beneficiaries\Pages\ListBeneficiaries;
use App\Filament\Resources\Beneficiaries\Pages\ViewBeneficiary;
use App\Filament\Resources\Menages\MenageResource;
use App\Filament\Resources\Residences\ResidenceResource;
use App\Models\Beneficiary;
use App\Models\Dispositif;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class BeneficiaryResource extends Resource
{
    protected static ?string $model = Beneficiary::class;

    protected static ?string $modelLabel = 'Bénéficiaire';

    protected static string|\UnitEnum|null $navigationGroup = 'Hébergés';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-c-user';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)->schema([
                    Section::make('Identité du bénéficiaire')->schema([
                        // Select::make('menage_id')->label('Ménage')->required()
                        //     ->helperText("Un bénéfiaiciare doit faire parti d\'un ménage"),
                        // ->options(Menage::where('team_id', Auth::user()->team_id)->pluck('name', 'id')),
                        TextInput::make('name')->label('Nom')->required(),
                        TextInput::make('birth_name')->label('Nom de naissance'),
                        TextInput::make('AGDREF')->label('N° AGDREF'),
                        Select::make('sex')->label('Sexe')
                            ->options(['man' => 'Homme', 'woman' => 'Femme']),
                        DatePicker::make('birthday')->label('Date de naissance'),
                        TextInput::make('nationality')->label('Nationalité'),
                        TextInput::make('birth_country')->label('Pays de naissance'),
                        TextInput::make('birth_city')->label('Ville de naissance'),
                        DatePicker::make('date_entry_dispositif')->label("Date d'entrée dans le dispositif"),
                        Select::make('family_situation_id')->label('Situation familiale')
                            ->relationship('typeFamily', 'label'),
                        DatePicker::make('date_entry_france')->label("Date d'arrivée en france"),
                        Select::make('administrative_situation_id')->label('Situation administrative')
                            ->relationship('typeAdministratif', 'label'),
                    ])->columns(2)->columnSpan(2)->compact(),
                    Group::make([
                        Section::make('Contact du bénéficiaire')->schema([
                            TextInput::make('phone')->label('Tel fix')->tel(),
                            TextInput::make('mobile_phone')->label('Portable')->tel(),
                            TextInput::make('email')->label('Adresse Email')->email(),
                        ])->compact(),
                        Section::make('Associations')->schema([
                            Select::make('lot')->label('N° Lot')
                                ->relationship('lot', 'number')
                                ->searchable()
                                ->preload()
                                ->getOptionLabelFromRecordUsing(fn ($record) => ('Lot n° '.$record->number)),
                            Select::make('menage')->label('Ménage')
                                ->relationship('menage', 'name')
                                ->searchable()
                                ->preload(),
                        ])->compact(),
                    ]),
                ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nom')->sortable()->searchable(),
                TextColumn::make('lot.residence.name')->label('Résidence')->searchable()->sortable()
                    ->url(fn (Beneficiary $record): ?string => $record->lot ? ResidenceResource::getUrl('view', [$record->lot->residence]) : null)
                    ->extraAttributes(['class' => 'text-blue-500 hover:underline']),
                TextColumn::make('lot.number')->label('N° lot')->searchable()->sortable(),
                TextColumn::make('birthday')->label('Date de naissance')->searchable()->sortable()->toggleable(),
                TextColumn::make('menage.name')->label('Ménage')->searchable()->sortable(),
                TextColumn::make('phone')->label('Téléphone')->searchable()->sortable()->toggleable(),
                TextColumn::make('email')->label('Email')->searchable()->sortable()->toggleable(),
                TextColumn::make('AGDREF')->label('AGDREF')->searchable()->sortable()->toggleable(),
                TextColumn::make('menage.referent.name')->label('Référent')->searchable()->sortable(),
            ])
            ->filters([
                Filter::make('dispositf')->label('Dispositif')
                    ->schema([
                        Select::make('dispositif')
                            // ->relationship("dispositif", "name")
                            ->options(Dispositif::pluck('name', 'id')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['dispositif'], function (Builder $query, $data) {
                            return $query->whereHas('lot.residence.dispositif', function (Builder $query) use ($data) {
                                return $query->where('id', $data);
                            });
                        });
                    }),
                // Filter::make('no_menage')->label('Bénéficiaires sans ménage')
                //     ->query(function (Builder $query, array $data): Builder {
                //         return $query->whereDoesntHave('menage');
                //     })
                //     ->toggle(),
                SelectFilter::make('menage')
                    ->label('Ménage')
                    ->relationship('menage', 'name'),
                SelectFilter::make('administrative_situation_id')
                    ->label('Situation administrative')
                    ->relationship('typeAdministratif', 'label'),
                SelectFilter::make('family_situation_id')
                    ->label('Composition familiale')
                    ->relationship('typeFamily', 'label'),
                Filter::make('no_lot')->label('Bénéficiaires sans lot')
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->whereDoesntHave('lot');
                    })
                    ->toggle(),
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                ViewAction::make(),
                ViewAction::make('menage')->label('Menage')->icon('heroicon-s-user-group')
                    ->disabled(fn ($record) => ! $record->menage)
                    ->url(fn ($record) => $record->menage ? MenageResource::getUrl('view', [$record->menage]) : null),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->recordUrl(function (Beneficiary $record): string {
                if (request()->user()->can('update', $record)) {
                    return EditBeneficiary::getUrl([$record]);
                } else {
                    return ViewBeneficiary::getUrl([$record]);
                }
            });
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
            'index' => ListBeneficiaries::route('/'),
            'create' => CreateBeneficiary::route('/create'),
            'edit' => EditBeneficiary::route('/{record}/edit'),
            'view' => ViewBeneficiary::route('/{record}'),

            'education' => EditBeneficiaryEducation::route('/{record}/edit/training'),
            'sanitary' => EditBeneficiarySanitary::route('/{record}/edit/sanitary'),
            'oqtf' => EditBeneficiaryOQTF::route('/{record}/edit/oqtf'),
            'justice' => EditBeneficiaryJustice::route('/{record}/edit/justice'),
        ];
    }

    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function getRecordSubNavigation(Page $page): array
    {
        $pages = [];

        if (request()->user()->can('update', new Beneficiary)) {
            $pages[] = EditBeneficiary::class;
            $pages[] = EditBeneficiaryEducation::class;
            $pages[] = EditBeneficiarySanitary::class;
            $pages[] = EditBeneficiaryJustice::class;
            $pages[] = EditBeneficiaryOQTF::class;
        } else {
            $pages[] = ViewBeneficiary::class;
        }

        return $page->generateNavigationItems($pages);
    }
}
