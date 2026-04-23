<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'sumber',      
        'category_id',
        'nominal',
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'nominal' => 'decimal:2'
    ];

    public function category(): BelongsTo 
    {
        return $this->belongsTo(Category::class);
    }
}
