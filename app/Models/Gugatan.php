<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gugatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis',
        'nama_penggugat',
        'kewarganegaraan_penggugat',
        'tempat_tinggal_penggugat',
        'pekerjaan_penggugat',
        'email_penggugat',
        'nama_kuasa_hukum',
        'kantor_kuasa_hukum',
        'alamat_kantor_hukum',
        'email_kuasa_hukum',
        'telepon_kuasa_hukum',
        'kuasa_hukum_list',
        'nomor_surat_kuasa',  
        'tanggal_surat_kuasa',
        'nama_tergugat',
        'alamat_tergugat',
        'email_tergugat',
        'judul_keputusan',
        'nomor_keputusan',
        'tanggal_keputusan',
        'perihal_keputusan',
        'nama_yang_dituju',
        'penetapan_tertulis_pejabat_tun',
        'sengketa_quo_individual',
        'sengketa_quo_final',
        'siapa_penggugat',
        'gugatan_dasar',
        'hubungan_hukum_objek_sengketa',
        'kepentingan_nyata_penggugat',
        'tanggal_penerbitan_objek',
        'tanggal_objek_diterima',
        'upaya_administratif_yg_telah_ditempuh',
        'tanggal_pengajuan_gugatan',
        'uraian_substansi_sengketa_dan_alasan_gugatan',
        'uraian_tindakan_tergugat_yang_bertentangan_dengan_uu',
        'uraian_tindakan_tergugat_yang_bertentangan_dengan_aupb',
        
        // Tambahkan kolom petitum
        'petitum_1',
        'petitum_2',
        'petitum_2_keterangan',
        'petitum_3',
        'petitum_3_keterangan',
        'petitum_4',
        'petitum_tambahan',
        
        'file_path'
    ];

    protected $casts = [
        'tanggal_surat_kuasa' => 'date',
        'tanggal_keputusan' => 'date',
        'tanggal_penerbitan_objek' => 'date',
        'tanggal_objek_diterima' => 'date',
        'kuasa_hukum_list' => 'array',
        'tanggal_pengajuan_gugatan' => 'date',
    ];
}