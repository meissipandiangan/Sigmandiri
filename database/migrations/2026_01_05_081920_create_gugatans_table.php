<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gugatans', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis', ['perorangan', 'kuasa_hukum']);
            
            // Data Penggugat
            $table->string('nama_penggugat');
            $table->string('kewarganegaraan_penggugat');
            $table->text('tempat_tinggal_penggugat');
            $table->string('pekerjaan_penggugat')->nullable();
            $table->string('email_penggugat');
            
            // Data Kuasa Hukum (optional)
            $table->string('nama_kuasa_hukum')->nullable();
            $table->string('kantor_kuasa_hukum')->nullable();
            $table->text('alamat_kantor_hukum')->nullable();
            $table->string('email_kuasa_hukum')->nullable();
            $table->string('telepon_kuasa_hukum')->nullable();
            $table->date('tanggal_surat_kuasa')->nullable();
            
            // Data Tergugat
            $table->string('nama_tergugat');
            $table->text('alamat_tergugat');
            $table->string('email_tergugat');
            
            // Data Objek Sengketa
            $table->string('judul_keputusan');
            $table->string('nomor_keputusan');
            $table->date('tanggal_keputusan');
            $table->text('perihal_keputusan');
            $table->string('nama_yang_dituju');
            
            // Kewenangan Pengadilan
            $table->text('penetapan_tertulis_pejabat_tun')->nullable();
            $table->text('sengketa_quo_individual');
            $table->text('sengketa_quo_final');
            
            // Legal Standing
            $table->text('siapa_penggugat');
            $table->text('gugatan_dasar');
            $table->text('hubungan_hukum_objek_sengketa');
            $table->text('kepentingan_nyata_penggugat');
            
            // Tenggang Waktu
            $table->date('tanggal_penerbitan_objek');
            $table->date('tanggal_objek_diterima');
            $table->text('upaya_administratif_yg_telah_ditempuh');
            $table->date('tanggal_pengajuan_gugatan');
            
            // Dasar Gugatan
            $table->text('uraian_substansi_sengketa_dan_alasan_gugatan');
            $table->text('uraian_tindakan_tergugat_yang_bertentangan_dengan_uu');
            $table->text('uraian_tindakan_tergugat_yang_bertentangan_dengan_aupb');
            
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gugatans');
    }
};