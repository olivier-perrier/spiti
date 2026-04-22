<?php

namespace App\Filament\Resources\Teams;

use App\Filament\Resources\Teams\Pages\CreateTeam;
use App\Filament\Resources\Teams\Pages\EditTeam;
use App\Filament\Resources\Teams\Pages\ListTeams;
use App\Models\Team;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;

    protected static ?string $modelLabel = 'Equipes';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static string|\UnitEnum|null $navigationGroup = 'Administration';

    protected static bool $isScopedToTenant = false;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Nom')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nom')->sortable(),
                TextColumn::make('users_count')->label('Utilisateurs')
                    ->counts('users')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('join')->label('Rejoindre')
                    ->action(function ($record) {

                        request()->user()->teams()->attach($record);
                        request()->user()->save();
                        Notification::make()->title('Equipe rejoins')->success()->send();
                    })
                    ->visible(function ($record) {
                        return ! request()->user()->teams()->where('teams.id', $record->id)->exists();
                    }),
                Action::make('leave')->label('Quitter')
                    ->action(function ($record) {

                        request()->user()->teams()->detach($record);
                        request()->user()->save();

                        Notification::make()->title("Vous avez quitter l'équipe")->success()->send();
                    })
                    ->visible(function ($record) {
                        return request()->user()->teams()->where('teams.id', $record->id)->exists() &&
                            request()->user()->teams()->count() > 0 &&
                            $record->id != Filament::getTenant()->id;
                    }),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTeams::route('/'),
            'create' => CreateTeam::route('/create'),
            'edit' => EditTeam::route('/{record}/edit'),
        ];
    }
}
