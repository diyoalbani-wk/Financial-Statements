<?php

namespace App\Filament\Resources\Outcomes\Schemas;

use App\Helpers\CategoryHelper;
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
                Select::make('kategori')
                    ->label('Kategori')
                    ->required()
                    ->options(CategoryHelper::getOutcomeCategories())
                    ->native(false),
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
