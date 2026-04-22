<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $modelLabel = 'Utilisateurs';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static string|\UnitEnum|null $navigationGroup = 'Administration';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)->schema([
                    Section::make()->schema([
                        TextInput::make('name')->label('Nom')->required(),
                        TextInput::make('email')->label('Email')->email()->required()
                            ->disabledOn('edit'),
                        Grid::make(2)->schema([
                            TextInput::make('password')->label('Mot de passe')->password()->required()
                                ->confirmed()
                                ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                            TextInput::make('password_confirmation')->label('Confirmation')
                                ->password()
                                ->required(),
                        ])->visibleOn('create'),
                    ])->columnSpan(2),
                    Section::make('Autorisations')->schema([
                        Select::make('roles')->label('Rôles')
                            ->relationship('roles', 'name')
                            ->searchable()
                            ->preload()
                            ->multiple()
                            ->pivotData(['team_id' => Filament::getTenant()->id]),
                        Toggle::make('is_admin')->label('Administrateur')
                            ->visible(request()->user()->is_admin),
                    ])->columnSpan(1),
                ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nom')->searchable()->sortable(),
                TextColumn::make('email')->label('Email')->searchable()->sortable(),
                TextColumn::make('roles.name')->label('Rôle(s)')->wrap()->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
