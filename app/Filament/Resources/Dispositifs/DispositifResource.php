<?php

namespace App\Filament\Resources\Dispositifs;

use App\Filament\Resources\Dispositifs\Pages\CreateDispositif;
use App\Filament\Resources\Dispositifs\Pages\EditDispositif;
use App\Filament\Resources\Dispositifs\Pages\ListDispositifs;
use App\Filament\Resources\Dispositifs\Pages\ViewDispositif;
use App\Filament\Resources\Dispositifs\RelationManagers\ResidencesRelationManager;
use App\Filament\Resources\Dispositifs\Schemas\DispositifForm;
use App\Filament\Resources\Dispositifs\Tables\DispositifsTable;
use App\Models\Dispositif;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class DispositifResource extends Resource
{
    protected static ?string $model = Dispositif::class;

    protected static string|UnitEnum|null $navigationGroup = 'Structures';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-office-2';

    public static function form(Schema $schema): Schema
    {
        return DispositifForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DispositifsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ResidencesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDispositifs::route('/'),
            'create' => CreateDispositif::route('/create'),
            'edit' => EditDispositif::route('/{record}/edit'),
            'view' => ViewDispositif::route('/{record}'),
        ];
    }
}
