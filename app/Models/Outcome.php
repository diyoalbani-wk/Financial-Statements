<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Helpers\CategoryHelper;

class Outcome extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'tujuan',
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
            'tujuan' => 'required|string|max:255',
            'kategori' => 'required|string|in:Makanan,Transport,Tagihan,Belanja,Kesehatan,Hiburan,Pendidikan,Lainnya',
            'nominal' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string'
        ];
    }

    public static function getCategories()
    {
        return CategoryHelper::getOutcomeCategories();
    }

    public static function getCategoryOptions()
    {
        $categories = self::getCategories();
        $options = ['' => '-- Pilih Kategori --'];
        return $options + $categories;
    }
}
