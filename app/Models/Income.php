<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Helpers\CategoryHelper;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'sumber',
        'kategori',
        'nominal',
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'nominal' => 'decimal:2'
    ];

    public static function rules()
    {
        return [
            'tanggal' => 'required|date',
            'sumber' => 'required|string|max:255',
            'kategori' => 'required|string|in:Gaji,Bonus,Investasi,Usaha,Hadiah,Lainnya',
            'nominal' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string'
        ];
    }

    public static function getCategories()
    {
        return CategoryHelper::getIncomeCategories();
    }

    public static function getCategoryOptions()
    {
        $categories = self::getCategories();
        $options = ['' => '-- Pilih Kategori --'];
        return $options + $categories;
    }
}
