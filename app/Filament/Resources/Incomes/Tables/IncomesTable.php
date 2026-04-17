<?php

namespace App\Filament\Resources\Incomes\Tables;

use App\Helpers\CategoryHelper;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class IncomesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('sumber')
                    ->label('Sumber')
                    ->searchable(),
                TextColumn::make('kategori')
                    ->label('Kategori')
                    ->searchable(),
                TextColumn::make('nominal')
                    ->label('Nominal')
                    ->money('IDR')
                    ->sortable()
                    ->alignRight(),
                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(50)
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y ')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('kategori')
                    ->label('Kategori')
                    ->options(CategoryHelper::getIncomeCategories()),
                Filter::make('tanggal')
                    ->label('Filter Tanggal')
                    ->form([
                        \Filament\Forms\Components\Select::make('filter_type')
                            ->label('Tipe Filter')
                            ->options([
                                'daily' => 'Harian',
                                'monthly' => 'Bulanan', 
                                'yearly' => 'Tahunan',
                                'range' => 'Rentang Tanggal',
                            ])
                            ->required()
                            ->reactive(),
                        \Filament\Forms\Components\DatePicker::make('tanggal')
                            ->label('Tanggal')
                            ->visible(fn (callable $get) => $get('filter_type') === 'daily')
                            ->required(),
                        \Filament\Forms\Components\Select::make('bulan')
                            ->label('Bulan')
                            ->options([
                                '01' => 'Januari',
                                '02' => 'Februari',
                                '03' => 'Maret',
                                '04' => 'April',
                                '05' => 'Mei',
                                '06' => 'Juni',
                                '07' => 'Juli',
                                '08' => 'Agustus',
                                '09' => 'September',
                                '10' => 'Oktober',
                                '11' => 'November',
                                '12' => 'Desember',
                            ])
                            ->visible(fn (callable $get) => $get('filter_type') === 'monthly')
                            ->required(),
                        \Filament\Forms\Components\TextInput::make('tahun')
                            ->label('Tahun')
                            ->numeric()
                            ->length(4)
                            ->default(date('Y'))
                            ->visible(fn (callable $get) => in_array($get('filter_type'), ['monthly', 'yearly']))
                            ->required(fn (callable $get) => $get('filter_type') === 'yearly'),
                        \Filament\Forms\Components\DatePicker::make('tanggal_mulai')
                            ->label('Tanggal Mulai')
                            ->visible(fn (callable $get) => $get('filter_type') === 'range')
                            ->required(),
                        \Filament\Forms\Components\DatePicker::make('tanggal_selesai')
                            ->label('Tanggal Selesai')
                            ->visible(fn (callable $get) => $get('filter_type') === 'range')
                            ->required()
                            ->after('tanggal_mulai'),
                    ])
                    ->query(function (array $data): callable {
                        return function ($query) use ($data) {
                            if (empty($data['filter_type'])) {
                                return $query;
                            }

                            switch ($data['filter_type']) {
                                case 'daily':
                                    if (!empty($data['tanggal'])) {
                                        $query->whereDate('tanggal', $data['tanggal']);
                                    }
                                    break;
                                case 'monthly':
                                    if (!empty($data['bulan']) && !empty($data['tahun'])) {
                                        $query->whereYear('tanggal', $data['tahun'])
                                              ->whereMonth('tanggal', $data['bulan']);
                                    }
                                    break;
                                case 'yearly':
                                    if (!empty($data['tahun'])) {
                                        $query->whereYear('tanggal', $data['tahun']);
                                    }
                                    break;
                                case 'range':
                                    if (!empty($data['tanggal_mulai']) && !empty($data['tanggal_selesai'])) {
                                        $query->whereBetween('tanggal', [
                                            $data['tanggal_mulai'],
                                            $data['tanggal_selesai']
                                        ]);
                                    }
                                    break;
                            }
                            
                            return $query;
                        };
                    }),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
