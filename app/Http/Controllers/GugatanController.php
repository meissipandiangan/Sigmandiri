<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GugatanController extends Controller
{
    /**
     * Halaman home/beranda
     */
    public function home()
    {
        return view('home');
    }

    /**
     * Halaman pilih jenis gugatan
     */
    public function index()
    {
        return view('gugatan.index');
    }

    public function create($jenis)
    {
        if (!in_array($jenis, ['perorangan', 'kuasa_hukum'])) {
            abort(404);
        }

        return view('gugatan.create', compact('jenis'));
    }

    public function store(Request $request)
    {
        \Log::info('=== GUGATAN STORE START ===');

        $rules = [
            'jenis'                                                      => 'required|in:perorangan,kuasa_hukum',
            'nama_penggugat'                                             => 'required|string',
            'kewarganegaraan_penggugat'                                  => 'required|string',
            'tempat_tinggal_penggugat'                                   => 'required|string',
            'pekerjaan_penggugat'                                        => 'required|string',
            'email_penggugat'                                            => 'required|email',
            'nama_tergugat'                                              => 'required|string',
            'alamat_tergugat'                                            => 'required|string',
            'judul_keputusan'                                            => 'required|string',
            'nomor_keputusan'                                            => 'required|string',
            'tanggal_keputusan'                                          => 'required|date',
            'perihal_keputusan'                                          => 'required|string',
            'sengketa_quo_individual'                                    => 'required|string',
            'sengketa_quo_final'                                         => 'required|string',
            'siapa_penggugat'                                            => 'required|string',
            'gugatan_dasar'                                              => 'required|string',
            'hubungan_hukum_objek_sengketa'                              => 'required|string',
            'kepentingan_nyata_penggugat'                                => 'required|string',
            'tanggal_penerbitan_objek'                                   => 'required|date',
            'tanggal_objek_diterima'                                     => 'required|date',
            'upaya_administratif_yg_telah_ditempuh'                      => 'required|string',
            'tanggal_pengajuan_gugatan'                                  => 'required|date',
            'uraian_substansi_sengketa_dan_alasan_gugatan'               => 'required|string',
            'uraian_tindakan_tergugat_yang_bertentangan_dengan_uu'       => 'required|string',
            'uraian_tindakan_tergugat_yang_bertentangan_dengan_aupb'     => 'required|string',
            'petitum_2_keterangan'                                       => 'required|string',
            'petitum_3_keterangan'                                       => 'required|string',
        ];

        // Validasi array kuasa hukum untuk jenis kuasa_hukum
        if ($request->jenis == 'kuasa_hukum') {
            $rules['kuasa']                       = 'required|array|min:1';
            $rules['kuasa.*.nama']                = 'required|string';
            $rules['kuasa.*.telepon']             = 'required|string';
            $rules['kuasa.*.email']               = 'required|email';
            $rules['kuasa.*.nomor_surat_kuasa']   = 'required|string';
            $rules['kuasa.*.tanggal_surat_kuasa'] = 'required|date';
            $rules['kuasa.*.kantor']              = 'required|string';
            $rules['kuasa.*.alamat_kantor']       = 'required|string';
            $rules['penetapan_tertulis_pejabat_tun'] = 'required|string';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            \Log::warning('Validation failed', ['errors' => $validator->errors()]);

            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            \Log::info('Starting document generation...');

            $fileName = $this->generateDocument($request->all());

            \Log::info('Document generated: ' . $fileName);

            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil dibuat!',
                'data'    => [
                    'download_url' => url('/gugatan/download/' . $fileName),
                    'file_name'    => $fileName,
                ],
            ], 200);

        } catch (\Exception $e) {
            \Log::error('=== ERROR ===');
            \Log::error('Message: ' . $e->getMessage());
            \Log::error('File: ' . $e->getFile() . ':' . $e->getLine());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function generateDocument(array $data)
    {
        $templateName = $data['jenis'] == 'kuasa_hukum'
            ? 'gugatan_kuasa_hukum.docx'
            : 'gugatan_perorangan.docx';

        $templatePath = storage_path('app/templates/' . $templateName);

        if (!file_exists($templatePath)) {
            throw new \Exception("Template tidak ditemukan: {$templateName}. Path: {$templatePath}");
        }

        $templateProcessor = new TemplateProcessor($templatePath);

        // ── Data umum ─────────────────────────────────────────────────────────────
        $templateProcessor->setValue('tanggal',                   now()->locale('id')->isoFormat('D MMMM YYYY'));
        $templateProcessor->setValue('nama_penggugat',            $data['nama_penggugat']);
        $templateProcessor->setValue('kewarganegaraan_penggugat', $data['kewarganegaraan_penggugat']);
        $templateProcessor->setValue('tempat_tinggal_penggugat',  $data['tempat_tinggal_penggugat']);
        $templateProcessor->setValue('pekerjaan_penggugat',       $data['pekerjaan_penggugat'] ?? '-');
        $templateProcessor->setValue('email_penggugat',           $data['email_penggugat']);

        // ── Kuasa Hukum (multiple → disesuaikan ke placeholder template lama) ─────
        if ($data['jenis'] == 'kuasa_hukum') {
            $kuasaList    = $data['kuasa'];  // array: kuasa[0], kuasa[1], dst.
            $kuasaPertama = $kuasaList[0];   // data kantor diambil dari kuasa pertama

            // --- ${nama_kuasa_hukum} ---
            // 1 kuasa  → nama saja tanpa nomor urut
            // >1 kuasa → daftar bernomor urut, pisah baris
            // Contoh hasil jika 3 kuasa:
            //   1. Ahmad, S.H.
            //   2. Budi, S.H.
            //   3. Citra, S.H.
            if (count($kuasaList) === 1) {
                $namaKuasa = $kuasaPertama['nama'];
            } else {
                $namaKuasa = '';
                foreach ($kuasaList as $i => $k) {
                    $namaKuasa .= ($i + 1) . '. ' . $k['nama'];
                    if ($i < count($kuasaList) - 1) {
                        $namaKuasa .= "\n";
                    }
                }
            }

            // --- ${nama_kuasa_hukum_ttd} ---
            // Nama semua kuasa untuk bagian tanda tangan penutup surat,
            // diberi 4 baris kosong antar nama sebagai ruang tanda tangan.
            // Contoh hasil jika 2 kuasa:
            //   Ahmad, S.H.
            //   [4 baris kosong]
            //   Budi, S.H.
            $kuasaTtd = '';
            foreach ($kuasaList as $i => $k) {
                if ($i > 0) {
                    $kuasaTtd .= "\n\n\n\n";
                }
                $kuasaTtd .= $k['nama'];
            }

            // Isi placeholder — template .docx TIDAK PERLU diubah kecuali
            // bagian TTD: ganti ${nama_kuasa_hukum} → ${nama_kuasa_hukum_ttd}
            $templateProcessor->setValue('nama_kuasa_hukum',     $namaKuasa);
            $templateProcessor->setValue('nama_kuasa_hukum_ttd', $kuasaTtd);
            $templateProcessor->setValue('kantor_kuasa_hukum',   $kuasaPertama['kantor']);
            $templateProcessor->setValue('alamat_kantor_hukum',  $kuasaPertama['alamat_kantor']);
            $templateProcessor->setValue('email_kuasa_hukum',    $kuasaPertama['email']);
            $templateProcessor->setValue('telepon_kuasa_hukum',  $kuasaPertama['telepon']);
            $templateProcessor->setValue('nomor_surat_kuasa',    $kuasaPertama['nomor_surat_kuasa'] ?? '-');
            $templateProcessor->setValue('tanggal_surat_kuasa',
                \Carbon\Carbon::parse($kuasaPertama['tanggal_surat_kuasa'])
                    ->locale('id')->isoFormat('D MMMM YYYY'));
            $templateProcessor->setValue('penetapan_tertulis_pejabat_tun', $data['penetapan_tertulis_pejabat_tun']);
        }

        // ── Tergugat ──────────────────────────────────────────────────────────────
        $templateProcessor->setValue('nama_tergugat',   $data['nama_tergugat']);
        $templateProcessor->setValue('alamat_tergugat', $data['alamat_tergugat']);
        $templateProcessor->setValue('email_tergugat',  $data['email_tergugat'] ?? '-');

        // ── Objek Sengketa ────────────────────────────────────────────────────────
        $templateProcessor->setValue('judul_keputusan',       $data['judul_keputusan']);
        $templateProcessor->setValue('nomor_keputusan',       $data['nomor_keputusan']);
        $templateProcessor->setValue('tanggal_keputusan',
            \Carbon\Carbon::parse($data['tanggal_keputusan'])->locale('id')->isoFormat('D MMMM YYYY'));
        $templateProcessor->setValue('perihal_keputusan',      $data['perihal_keputusan']);
        $templateProcessor->setValue('nama_yang_dituju',       $data['nama_yang_dituju'] ?? '-');
        $templateProcessor->setValue('sengketa_quo_individual', $data['sengketa_quo_individual']);
        $templateProcessor->setValue('sengketa_quo_final',      $data['sengketa_quo_final']);

        // ── Legal Standing ────────────────────────────────────────────────────────
        $templateProcessor->setValue('siapa_penggugat',               $data['siapa_penggugat']);
        $templateProcessor->setValue('gugatan_dasar',                  $data['gugatan_dasar']);
        $templateProcessor->setValue('hubungan_hukum_objek_sengketa',  $data['hubungan_hukum_objek_sengketa']);
        $templateProcessor->setValue('kepentingan_nyata_penggugat',    $data['kepentingan_nyata_penggugat']);

        // ── Tenggang Waktu ────────────────────────────────────────────────────────
        $templateProcessor->setValue('tanggal_penerbitan_objek',
            \Carbon\Carbon::parse($data['tanggal_penerbitan_objek'])->locale('id')->isoFormat('D MMMM YYYY'));
        $templateProcessor->setValue('tanggal_objek_diterima',
            \Carbon\Carbon::parse($data['tanggal_objek_diterima'])->locale('id')->isoFormat('D MMMM YYYY'));
        $templateProcessor->setValue('upaya_administratif_yg_telah_ditempuh', $data['upaya_administratif_yg_telah_ditempuh']);
        $templateProcessor->setValue('tanggal_pengajuan_gugatan',
            \Carbon\Carbon::parse($data['tanggal_pengajuan_gugatan'])->locale('id')->isoFormat('D MMMM YYYY'));

        // ── Dasar & Alasan Gugatan ────────────────────────────────────────────────
        $templateProcessor->setValue('uraian_substansi_sengketa_dan_alasan_gugatan',
            $data['uraian_substansi_sengketa_dan_alasan_gugatan']);
        $templateProcessor->setValue('uraian_tindakan_tergugat_yang_bertentangan_dengan_uu',
            $data['uraian_tindakan_tergugat_yang_bertentangan_dengan_uu']);
        $templateProcessor->setValue('uraian_tindakan_tergugat_yang_bertentangan_dengan_aupb',
            $data['uraian_tindakan_tergugat_yang_bertentangan_dengan_aupb']);

        // ── Petitum ───────────────────────────────────────────────────────────────
        $templateProcessor->setValue('petitum_2_keterangan', $data['petitum_2_keterangan']);
        $templateProcessor->setValue('petitum_3_keterangan', $data['petitum_3_keterangan']);
        $templateProcessor->setValue('petitum_tambahan',     $data['petitum_tambahan'] ?? '');

        // ── Simpan file ───────────────────────────────────────────────────────────
        $fileName   = 'Gugatan_' . str_replace(' ', '_', $data['nama_penggugat']) . '_' . time() . '.docx';
        $outputPath = storage_path('app/public/documents/' . $fileName);

        if (!file_exists(dirname($outputPath))) {
            mkdir(dirname($outputPath), 0755, true);
        }

        $templateProcessor->saveAs($outputPath);

        return $fileName;
    }

    public function downloadDirect($file)
    {
        \Log::info('Download request for: ' . $file);

        $filePath = storage_path('app/public/documents/' . $file);

        if (!file_exists($filePath)) {
            \Log::error('File not found: ' . $filePath);
            abort(404, 'File tidak ditemukan');
        }

        return response()->download($filePath, $file, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ])->deleteFileAfterSend(true);
    }
}