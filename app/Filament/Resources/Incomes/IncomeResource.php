<?php

namespace App\Filament\Resources\Incomes;

use App\Filament\Resources\Incomes\Pages\CreateIncome;
use App\Filament\Resources\Incomes\Pages\EditIncome;
use App\Filament\Resources\Incomes\Pages\ListIncomes;
use App\Filament\Resources\Incomes\Schemas\IncomeForm;
use App\Filament\Resources\Incomes\Tables\IncomesTable;
use App\Models\Income;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;

class IncomeResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Income::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Pemasukan';

    protected static string|UnitEnum|null $navigationGroup = 'Keuangan';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return IncomeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IncomesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListIncomes::route('/'),
            'create' => CreateIncome::route('/create'),
            'edit' => EditIncome::route('/{record}/edit'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'restore',
            'restore_any',
            'replicate',
            'reorder',
            'delete',
            'delete_any',
            'force_delete',
            'force_delete_any',
        ];
    }

}