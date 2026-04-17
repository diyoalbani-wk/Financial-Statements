<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKeuangan extends Model
{
    protected $table = 'laporan_keuangan_view';
    
    public $timestamps = false;
    
    protected $fillable = [
        'id',
        'tanggal',
        'sumber_tujuan',
        'kategori',
        'nominal',
        'keterangan',
        'created_at',
        'updated_at',
        'tipe',
        'tipe_label'
    ];
    
    protected $casts = [
        'tanggal' => 'date',
        'nominal' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    
    protected $guarded = [];
}
