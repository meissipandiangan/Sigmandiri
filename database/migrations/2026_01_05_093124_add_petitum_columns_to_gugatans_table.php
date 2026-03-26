<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gugatans', function (Blueprint $table) {
            // Tambahkan kolom nomor_surat_kuasa jika belum ada
            if (!Schema::hasColumn('gugatans', 'nomor_surat_kuasa')) {
                $table->string('nomor_surat_kuasa')->nullable()->after('telepon_kuasa_hukum');
            }
            
            // Tambahkan kolom petitum
            $table->boolean('petitum_1')->default(false)->after('uraian_tindakan_tergugat_yang_bertentangan_dengan_aupb');
            $table->boolean('petitum_2')->default(false);
            $table->text('petitum_2_keterangan')->nullable();
            $table->boolean('petitum_3')->default(false);
            $table->text('petitum_3_keterangan')->nullable();
            $table->boolean('petitum_4')->default(false);
            $table->text('petitum_tambahan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('gugatans', function (Blueprint $table) {
            $table->dropColumn([
                'nomor_surat_kuasa',
                'petitum_1',
                'petitum_2',
                'petitum_2_keterangan',
                'petitum_3',
                'petitum_3_keterangan',
                'petitum_4',
                'petitum_tambahan'
            ]);
        });
    }
};