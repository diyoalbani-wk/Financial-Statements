<?php

namespace App\Filament\Resources\Outcomes\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OutcomeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('tanggal')
                    ->label('Tanggal')
                    ->required()
                    ->native(false),
                TextInput::make('tujuan')
                    ->label('Tujuan')
                    ->required()
                    ->maxLength(255),
                Select::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name', function ($query) {
                        return $query->where('type', 'outcome')
                        ->where('is_active', true)
                        ->orderByRaw("CASE WHEN name LIKE '%Lainlain%' THEN 1 ELSE 0 END ASC")
                        ->orderBy('name', 'asc');;
                    })
                    ->native(false)
                    ->required(),
                TextInput::make('nominal')
                    ->label('Nominal')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->prefix('Rp'),
                Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->columnSpanFull(),
            ]);
    }
}
