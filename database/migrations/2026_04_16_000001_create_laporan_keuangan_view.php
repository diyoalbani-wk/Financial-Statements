<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            CREATE VIEW laporan_keuangan_view AS
            SELECT 
                id, 
                tanggal, 
                sumber as sumber_tujuan, 
                kategori, 
                nominal, 
                keterangan, 
                created_at, 
                updated_at, 
                'income' as tipe,
                'Pemasukan' as tipe_label
            FROM incomes
            UNION ALL
            SELECT 
                id, 
                tanggal, 
                tujuan as sumber_tujuan, 
                kategori, 
                nominal, 
                keterangan, 
                created_at, 
                updated_at, 
                'outcome' as tipe,
                'Pengeluaran' as tipe_label
            FROM outcomes
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS laporan_keuangan_view");
    }
};
