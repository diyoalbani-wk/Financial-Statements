<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaporanResource\Pages;
use App\Models\LaporanKeuangan;
use BackedEnum;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;

class LaporanResource extends Resource
{
    protected static ?string $model = LaporanKeuangan::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Laporan Keuangan';
    protected static ?string $modelLabel = 'Laporan';
    protected static ?string $pluralModelLabel = 'Laporan';
    
    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageLaporan::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return LaporanKeuangan::query()->latest('tanggal');
    }
}