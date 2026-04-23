<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Outcome extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'tujuan',
        'category_id',
        'nominal',
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'nominal' => 'decimal:2'
    ];

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }

}
