<?php

namespace App\Filament\Resources\Invitations;

use App\Filament\Resources\Invitations\Pages\CreateInvitation;
use App\Filament\Resources\Invitations\Pages\EditInvitation;
use App\Filament\Resources\Invitations\Pages\ListInvitations;
use App\Models\Invitation;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Validation\Rules\Unique;

class InvitationResource extends Resource
{
    protected static ?string $model = Invitation::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-c-user-plus';

    protected static string|\UnitEnum|null $navigationGroup = 'Administration';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('email')->label('Email')
                    ->email()
                    ->unique(modifyRuleUsing: function (Unique $rule) {
                        return $rule->where('team_id', Filament::getTenant()->id);
                    })
                    ->validationMessages([
                        'unique' => 'Il existe déjà une invitation de cette adresse mail.',
                    ])
                    ->disabledOn('edit')
                    ->helperText('Adresse email qui sera invitée à rejoindre votre organisation')
                    ->required(),
                Group::make([
                    Select::make('roles')->label('Rôles')
                        ->relationship('roles', 'name')
                        ->searchable()
                        ->preload()
                        ->multiple(),
                    Toggle::make('is_admin')->label('Administrateur')
                        ->visible(request()->user()->is_admin),
                ])->columnSpan(1),

                TextInput::make('token')->label("Code d'invitation")
                    ->password()
                    ->revealable()
                    ->helperText("Ne partagez jamais ce code d'invitation avec un utilisateur !")
                    ->hiddenOn('create'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('email')->sortable(),
                TextColumn::make('created_at')->label('Créée le')->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInvitations::route('/'),
            'create' => CreateInvitation::route('/create'),
            'edit' => EditInvitation::route('/{record}/edit'),
        ];
    }
}
