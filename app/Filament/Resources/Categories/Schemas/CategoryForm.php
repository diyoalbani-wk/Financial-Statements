<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select; 
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Kategori')
                    ->placeholder('Contoh: Gaji, Makanan, dll')
                    ->required()
                    ->maxLength(255),
                Select::make('type')
                    ->label('Tipe')
                    ->options([
                        'income' => 'Pemasukan (Income)',
                        'outcome' => 'Pengeluaran (Outcome)',
                    ])
                    ->required()
                    ->native(false),
                Toggle::make('is_active')
                    ->label('Status Aktif')
                    ->default(true)
                    ->columnSpanFull(),
            ]);
    }
}
