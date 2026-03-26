@extends('layouts.app')

@section('title', 'Buat Draft Gugatan')

@section('content')
<div class="container">
    <div class="card">
        <!-- Header -->
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2>
                Draft Gugatan {{ $jenis == 'kuasa_hukum' ? 'dengan Kuasa Hukum' : 'Perorangan' }}
            </h2>
            <a href="{{ route('gugatan.index') }}" style="color: white; text-decoration: none;">
                <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </a>
        </div>

        <!-- Disclaimer Modal for Perorangan -->
        @if($jenis == 'perorangan')
        <div id="disclaimerModal" class="modal" style="display: none;">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">Disclaimer</h3>
                </div>
                <p style="text-align: center; margin-bottom: 1.5rem; line-height: 1.6; color: #6b7280;">
                    Draft Gugatan ini bersifat <strong>panduan</strong>, dan dapat dilakukan perbaikan oleh <strong>Majelis Hakim</strong> sesuai dengan karakteristik perkara masing-masing.
                </p>
                <div style="display: flex; gap: 1rem;">
                    <button onclick="hideDisclaimer()" class="btn btn-primary btn-block">
                        Saya Mengerti & Lanjutkan
                    </button>
                    <button onclick="window.location.href='{{ route('gugatan.index') }}'" class="btn btn-secondary btn-block">
                        Batal
                    </button>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('gugatan.store') }}" method="POST" id="gugatanForm" novalidate>
            @csrf
            <input type="hidden" name="jenis" value="{{ $jenis }}">

            <!-- Tabs Navigation -->
            <div class="tabs">
                <button type="button" class="tab-btn active" data-tab="1">1. Identitas</button>
                
                @if($jenis == 'kuasa_hukum')
                    <button type="button" class="tab-btn" data-tab="2">2. Kuasa</button>
                    <button type="button" class="tab-btn" data-tab="3">3. Tergugat</button>
                    <button type="button" class="tab-btn" data-tab="4">4. Objek</button>
                    <button type="button" class="tab-btn" data-tab="5">5. Kepentingan</button>
                    <button type="button" class="tab-btn" data-tab="6">6. Penerbitan</button>
                    <button type="button" class="tab-btn" data-tab="7">7. Dasar & Alasan</button>
                    <button type="button" class="tab-btn" data-tab="8">8. Petitum</button>
                @else
                    <button type="button" class="tab-btn" data-tab="2">2. Tergugat</button>
                    <button type="button" class="tab-btn" data-tab="3">3. Objek</button>
                    <button type="button" class="tab-btn" data-tab="4">4. Kepentingan</button>
                    <button type="button" class="tab-btn" data-tab="5">5. Penerbitan</button>
                    <button type="button" class="tab-btn" data-tab="6">6. Dasar & Alasan</button>
                    <button type="button" class="tab-btn" data-tab="7">7. Petitum</button>
                @endif
            </div>

            <!-- Tab Contents -->
            <div class="card-body">
                <!-- Tab 1: Identitas Penggugat -->
                <div class="tab-content active" data-content="1">
                    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem;">Data Identitas Penggugat</h3>
                    
                    <div class="grid grid-2">
                        <div class="form-group">
                            <label class="form-label">Nama Penggugat <span class="required">*</span></label>
                            <input type="text" name="nama_penggugat" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Kewarganegaraan <span class="required">*</span></label>
                            <input type="text" name="kewarganegaraan_penggugat" class="form-control" value="Indonesia" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tempat Tinggal <span class="required">*</span></label>
                            <textarea name="tempat_tinggal_penggugat" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Pekerjaan<span class="required">*</span></label>
                            <input type="text" name="pekerjaan_penggugat" class="form-control" required>
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">Email <span class="required">*</span></label>
                            <input type="email" name="email_penggugat" class="form-control" required>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Kuasa Hukum (only for kuasa_hukum) -->
                @if($jenis == 'kuasa_hukum')
                <div class="tab-content" data-content="2">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <h3 style="font-size: 1.25rem; font-weight: 600;">Data Kuasa Hukum</h3>
                        <button type="button" onclick="tambahKuasa()" class="btn btn-success" style="display: flex; align-items: center; gap: 0.5rem;">
                            <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Kuasa Hukum
                        </button>
                    </div>

                    <div id="kuasa-list">
                        <!-- Kuasa hukum pertama (tidak bisa dihapus) -->
                        <div class="kuasa-item" data-index="0" style="border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 1.5rem; margin-bottom: 1.5rem; background: #f9fafb; position: relative;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                <h4 style="font-weight: 600; color: #374151;">Kuasa Hukum ke-1</h4>
                                {{-- Kuasa pertama tidak ada tombol hapus --}}
                            </div>
                            <div class="grid grid-2">
                                <div class="form-group">
                                    <label class="form-label">Nama Kuasa Hukum <span class="required">*</span></label>
                                    <input type="text" name="kuasa[0][nama]" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">No. Telepon <span class="required">*</span></label>
                                    <input type="text" name="kuasa[0][telepon]" class="form-control" placeholder="0812xxxxxx" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email <span class="required">*</span></label>
                                    <input type="email" name="kuasa[0][email]" class="form-control" placeholder="email@email.com" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Nomor Surat Kuasa <span class="required">*</span></label>
                                    <input type="text" name="kuasa[0][nomor_surat_kuasa]" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Tanggal Surat Kuasa <span class="required">*</span></label>
                                    <input type="date" name="kuasa[0][tanggal_surat_kuasa]" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Nama Kantor <span class="required">*</span></label>
                                    <input type="text" name="kuasa[0][kantor]" class="form-control" required>
                                </div>
                                <div class="form-group" style="grid-column: span 2;">
                                    <label class="form-label">Alamat Kantor Hukum <span class="required">*</span></label>
                                    <textarea name="kuasa[0][alamat_kantor]" class="form-control" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Info jumlah kuasa --}}
                    <div class="alert alert-success" style="margin-top: 0;">
                        <strong>Info:</strong> Tambahkan kuasa hukum sesuai jumlah yang mewakili penggugat. Kuasa hukum pertama wajib diisi.
                    </div>
                </div>
                @endif

                <!-- Tab Tergugat -->
                <div class="tab-content" data-content="{{ $jenis == 'kuasa_hukum' ? '3' : '2' }}">
                    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem;">Data Tergugat</h3>
                    
                    <div class="form-group">
                        <label class="form-label">Nama Jabatan Tergugat <span class="required">*</span></label>
                        <input type="text" name="nama_tergugat" class="form-control" placeholder="Contoh: Kepala Dinas Pendidikan Kota..." required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Alamat Kantor Tergugat <span class="required">*</span></label>
                        <textarea name="alamat_tergugat" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email Tergugat</label>
                        <input type="email" name="email_tergugat" class="form-control">
                    </div>
                </div>

                <!-- Tab Objek Sengketa -->
                <div class="tab-content" data-content="{{ $jenis == 'kuasa_hukum' ? '4' : '3' }}">
                    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem;">Objek Sengketa</h3>
                    
                    <div class="grid grid-2">
                        <div class="form-group">
                            <label class="form-label">Judul Keputusan <span class="required">*</span></label>
                            <input type="text" name="judul_keputusan" class="form-control" placeholder="Contoh: Surat Keputusan..." required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nomor Keputusan <span class="required">*</span></label>
                            <input type="text" name="nomor_keputusan" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tanggal Keputusan <span class="required">*</span></label>
                            <input type="date" name="tanggal_keputusan" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Perihal Keputusan <span class="required">*</span></label>
                            <input type="text" name="perihal_keputusan" class="form-control" required>
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">Nama yang Dituju oleh Keputusan (Opsional)</label>
                            <input type="text" name="nama_yang_dituju" class="form-control" placeholder="Jika disebutkan dalam keputusan">
                        </div>
                    </div>

                    @if($jenis == 'kuasa_hukum')
                    <div class="form-group">
                        <label class="form-label">Bahwa objek sengketa a quo dikeluarkan dalam bentuk penetapan tertulis oleh Pejabat Tata Usaha Negara <span class="required">*</span></label>
                        <textarea name="penetapan_tertulis_pejabat_tun" class="form-control" rows="3" placeholder="Contoh: Bahwa objek sengketa a quo dikeluarkan dalam bentuk penetapan tertulis oleh Kepala Dinas..." required></textarea>
                    </div>
                    @endif

                    <div class="form-group">
                        <label class="form-label">Uraikan pula bahwa objek sengketa a quo bersifat individual <span class="required">*</span></label>
                        <textarea name="sengketa_quo_individual" class="form-control" rows="3" placeholder="sebab keputusan tersebut tidak ditujukan untuk masyarakat luas, melainkan kepada orang atau pihak tertentu yang secara jelas disebut dalam keputusan tersebut" required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Uraikan bahwa objek sengketa a quo bersifat final <span class="required">*</span></label>
                        <textarea name="sengketa_quo_final" class="form-control" rows="3" placeholder="karena keputusan yang menjadi objek sengketa telah bersifat tuntas dan tidak memerlukan persetujuan atau tindakan lanjutan dari instansi lain" required></textarea>
                    </div>
                </div>

                <!-- Tab Kepentingan / Legal Standing -->
                <div class="tab-content" data-content="{{ $jenis == 'kuasa_hukum' ? '5' : '4' }}">
                    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem;">Kepentingan / Legal Standing</h3>
                    
                    <div class="form-group">
                        <label class="form-label">Jelaskan siapa Penggugat <span class="required">*</span></label>
                        <textarea name="siapa_penggugat" class="form-control" rows="3" placeholder="Bahwa Penggugat adalah ..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Dasar mengajukan gugatan <span class="required">*</span></label>
                        <textarea name="gugatan_dasar" class="form-control" rows="3" placeholder="Bahwa Penggugat mengajukan gugatan dengan dasar ..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Hubungan hukum antara objek sengketa <span class="required">*</span></label>
                        <textarea name="hubungan_hukum_objek_sengketa" class="form-control" rows="3" placeholder="Bahwa hubungan hukum Penggugat dengan objek sengketa adalah ..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kepentingan nyata Penggugat <span class="required">*</span></label>
                        <textarea name="kepentingan_nyata_penggugat" class="form-control" rows="3" placeholder="Jelaskan kepentingan nyata dari Penggugat sehingga merasa dirugikan atas terbitnya objek sengketa ..." required></textarea>
                    </div>
                </div>

                <!-- Tab Tenggang Waktu -->
                <div class="tab-content" data-content="{{ $jenis == 'kuasa_hukum' ? '6' : '5' }}">
                    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem;">Tenggang Waktu dan Upaya Administratif</h3>
                    
                    <div class="grid grid-2">
                        <div class="form-group">
                            <label class="form-label">Tanggal Penerbitan Objek Sengketa <span class="required">*</span></label>
                            <input type="date" name="tanggal_penerbitan_objek" class="form-control" required>
                            <p style="font-size: 0.875rem; color: #6b7280; margin-top: 0.5rem;">Bahwa Objek Sengketa diterbitkan Tergugat pada tanggal ini.</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tanggal Diterima/Diketahui Penggugat <span class="required">*</span></label>
                            <input type="date" name="tanggal_objek_diterima" class="form-control" required>
                            <p style="font-size: 0.875rem; color: #6b7280; margin-top: 0.5rem;">Bahwa Objek Sengketa diterima/diketahui Penggugat pada tanggal ini.</p>
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">Upaya Administratif yang Telah Ditempuh <span class="required">*</span></label>
                            <textarea name="upaya_administratif_yg_telah_ditempuh" class="form-control" rows="4" placeholder="Bahwa Penggugat telah melakukan Upaya Administratif berupa keberatan/banding administratif sebelum mengajukan Gugatan..." required></textarea>
                            <p style="font-size: 0.875rem; color: #6b7280; margin-top: 0.5rem;">Sesuai Pasal 75-78 UU No. 30 Tahun 2014 tentang Administrasi Pemerintahan.</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tanggal Pengajuan Gugatan <span class="required">*</span></label>
                            <input type="date" name="tanggal_pengajuan_gugatan" class="form-control" required>
                            <p style="font-size: 0.875rem; color: #6b7280; margin-top: 0.5rem;">Bahwa gugatan a quo diajukan pada tanggal ini.</p>
                        </div>

                        <div class="form-group">
                            <div class="info-box">
                                <h4>Keterangan Tenggang Waktu</h4>
                                <p>Bahwa oleh karenanya Gugatan a quo diajukan masih dalam tenggang waktu sesuai dengan ketentuan Pasal 55 UU No. 5 Tahun 1986 dan PERMA No. 6 Tahun 2018...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab Dasar & Alasan Gugatan -->
                <div class="tab-content" data-content="{{ $jenis == 'kuasa_hukum' ? '7' : '6' }}">
                    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem;">Dasar dan Alasan Gugatan</h3>
                    
                    <div class="form-group">
                        <label class="form-label">1. Uraikan Substansi Sengketa dan Alasan Gugatan <span class="required">*</span></label>
                        <textarea name="uraian_substansi_sengketa_dan_alasan_gugatan" class="form-control" rows="5" placeholder="Jelaskan kronologis sengketa TUN, alasan gugatan, dan pelanggaran kewenangan/prosedur/substansi..." required></textarea>
                        <p style="font-size: 0.875rem; color: #6b7280; margin-top: 0.5rem;">Sesuai Pasal 53 ayat (2) UU No.9 Tahun 2004 (Perubahan Atas UU No.5 Tahun 1986).</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label">2. Uraikan Tindakan Tergugat yang Bertentangan dengan Peraturan Perundang-undangan <span class="required">*</span></label>
                        <textarea name="uraian_tindakan_tergugat_yang_bertentangan_dengan_uu" class="form-control" rows="5" placeholder="Uraikan bentuk pelanggaran terhadap peraturan perundang-undangan oleh Tergugat..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">3. Uraikan Tindakan Tergugat yang Bertentangan dengan AUPB <span class="required">*</span></label>
                        <textarea name="uraian_tindakan_tergugat_yang_bertentangan_dengan_aupb" class="form-control" rows="5" placeholder="Uraikan tindakan Tergugat yang bertentangan dengan asas-asas umum pemerintahan yang baik (AUPB)..." required></textarea>
                    </div>

                    <div class="alert alert-success">
                        <strong>Catatan:</strong> Bahwa oleh karena Keputusan Tergugat menerbitkan objek sengketa a quo tidak sesuai atau bertentangan dengan peraturan perundang-undangan dan/atau asas-asas umum pemerintahan yang baik, sehingga memenuhi unsur dari ketentuan Pasal 53 ayat (2) Undang-Undang No.9 Tahun 2004 tentang Perubahan Atas Undang-Undang No.5 Tahun 1986 tentang Peradilan Tata Usaha Negara.
                    </div>
                </div>

                <!-- Tab Petitum -->
                <div class="tab-content" data-content="{{ $jenis == 'kuasa_hukum' ? '8' : '7' }}">
                    <div style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); padding: 2rem; border-radius: 1rem; border: 2px solid #3b82f6;">
                        <h3 style="font-size: 1.5rem; font-weight: bold; text-align: center; margin-bottom: 1.5rem;">VI. PETITUM</h3>
                        
                        <div style="background: white; padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                            <p style="margin-bottom: 1.5rem; font-weight: 500;">Bahwa berdasarkan seluruh uraian tersebut, Penggugat mohon kepada Ketua Pengadilan Tata Usaha Negara Kendari Cq. Hakim Pemeriksa Perkara a quo untuk memberikan putusan dengan amar sebagai berikut:</p>
                            
                            <div style="display: flex; flex-direction: column; gap: 1rem;">
                                <!-- Petitum 1 -->
                                <div style="display: flex; padding: 1rem; background: #f9fafb; border-radius: 0.5rem;">
                                    <input type="checkbox" id="petitum_1" name="petitum_1" value="1" required style="margin-top: 0.25rem; width: 20px; height: 20px;">
                                    <label for="petitum_1" style="margin-left: 1rem; cursor: pointer;">
                                        <strong style="color: #059669;">1.</strong> Mengabulkan gugatan Penggugat untuk seluruhnya;
                                    </label>
                                </div>

                                <!-- Petitum 2 -->
                                <div style="padding: 1rem; background: #f9fafb; border-radius: 0.5rem;">
                                    <div style="display: flex; margin-bottom: 1rem;">
                                        <input type="checkbox" id="petitum_2" name="petitum_2" value="1" required style="margin-top: 0.25rem; width: 20px; height: 20px;">
                                        <label for="petitum_2" style="margin-left: 1rem; cursor: pointer;">
                                            <strong style="color: #059669;">2.</strong> Menyatakan batal atau tidak sah Keputusan <span class="required">*</span>
                                        </label>
                                    </div>
                                    <textarea name="petitum_2_keterangan" class="form-control" rows="2" placeholder="Sebutkan keputusan yang dimaksud (contoh: Keputusan Tergugat Nomor ... tanggal ...)" required style="margin-left: 2rem;"></textarea>
                                </div>

                                <!-- Petitum 3 -->
                                <div style="padding: 1rem; background: #f9fafb; border-radius: 0.5rem;">
                                    <div style="display: flex; margin-bottom: 1rem;">
                                        <input type="checkbox" id="petitum_3" name="petitum_3" value="1" required style="margin-top: 0.25rem; width: 20px; height: 20px;">
                                        <label for="petitum_3" style="margin-left: 1rem; cursor: pointer;">
                                            <strong style="color: #059669;">3.</strong> Mewajibkan kepada Tergugat untuk mencabut Keputusan <span class="required">*</span>
                                        </label>
                                    </div>
                                    <textarea name="petitum_3_keterangan" class="form-control" rows="2" placeholder="Sebutkan keputusan yang harus dicabut" required style="margin-left: 2rem;"></textarea>
                                </div>

                                <!-- Petitum 4 -->
                                <div style="display: flex; padding: 1rem; background: #f9fafb; border-radius: 0.5rem;">
                                    <input type="checkbox" id="petitum_4" name="petitum_4" value="1" required style="margin-top: 0.25rem; width: 20px; height: 20px;">
                                    <label for="petitum_4" style="margin-left: 1rem; cursor: pointer;">
                                        <strong style="color: #059669;">4.</strong> Menghukum Tergugat untuk membayar seluruh biaya perkara yang timbul dalam sengketa ini;
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-error">
                            <strong>Penting:</strong> Centang semua checkbox dan isi keterangan yang diminta pada poin 2 dan 3 sebelum melanjutkan.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div style="padding: 1.5rem 2rem; background: #f9fafb; display: flex; justify-content: space-between; border-top: 1px solid #e5e7eb;">
                <button type="button" id="prevBtn" onclick="changeTab(-1)" class="btn btn-secondary" style="display: none;">
                    ← Sebelumnya
                </button>
                
                <button type="button" id="nextBtn" onclick="changeTab(1)" class="btn btn-success">
                    Lanjut →
                </button>

                <button type="submit" id="submitBtn" class="btn btn-primary" style="display: none;">
                    Generate Dokumen
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Inject URLs from Laravel
const APP_URLS = {
    home: '{{ route("gugatan.index") }}'
};

let currentTab = 1;
const totalTabs = {{ $jenis == 'kuasa_hukum' ? 8 : 7 }};

// Show disclaimer modal for perorangan
@if($jenis == 'perorangan')
window.addEventListener('load', function() {
    document.getElementById('disclaimerModal').style.display = 'flex';
});

function hideDisclaimer() {
    document.getElementById('disclaimerModal').style.display = 'none';
}
@endif

// Validate current tab
function validateCurrentTab() {
    const currentContent = document.querySelector(`[data-content="${currentTab}"]`);
    if (!currentContent) return true;
    
    const requiredFields = currentContent.querySelectorAll('[required]');
    let isValid = true;
    let firstInvalidField = null;
    
    requiredFields.forEach(field => {
        if (field.offsetParent === null) return;
        
        if (!field.value || (field.type === 'checkbox' && !field.checked)) {
            isValid = false;
            field.style.borderColor = '#ef4444';
            
            if (!firstInvalidField) firstInvalidField = field;
            
            let errorMsg = field.parentElement.querySelector('.validation-error');
            if (!errorMsg) {
                errorMsg = document.createElement('div');
                errorMsg.className = 'validation-error';
                errorMsg.style.color = '#ef4444';
                errorMsg.style.fontSize = '0.875rem';
                errorMsg.style.marginTop = '0.5rem';
                errorMsg.textContent = 'Field ini wajib diisi';
                field.parentElement.appendChild(errorMsg);
            }
        } else {
            field.style.borderColor = '#d1d5db';
            const errorMsg = field.parentElement.querySelector('.validation-error');
            if (errorMsg) errorMsg.remove();
        }
    });
    
    if (!isValid && firstInvalidField) {
        firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
        showToast('Mohon lengkapi semua field yang wajib diisi', 'error');
    }
    
    return isValid;
}

// Show specific tab
function showTab(n) {
    const tabs = document.querySelectorAll('.tab-content');
    const tabBtns = document.querySelectorAll('.tab-btn');
    
    tabs.forEach(tab => tab.classList.remove('active'));
    tabBtns.forEach(btn => btn.classList.remove('active'));
    
    const targetTab = document.querySelector(`[data-content="${n}"]`);
    const targetBtn = document.querySelector(`[data-tab="${n}"]`);
    
    if (targetTab) targetTab.classList.add('active');
    if (targetBtn) targetBtn.classList.add('active');
    
    document.getElementById('prevBtn').style.display = n === 1 ? 'none' : 'inline-block';
    document.getElementById('nextBtn').style.display = n === totalTabs ? 'none' : 'inline-block';
    document.getElementById('submitBtn').style.display = n === totalTabs ? 'inline-block' : 'none';
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Change tab with validation
function changeTab(direction) {
    // Hanya validasi jika maju (direction = 1)
    if (direction === 1 && !validateCurrentTab()) {
        return false;
    }
    
    currentTab += direction;
    
    if (currentTab < 1) currentTab = 1;
    if (currentTab > totalTabs) currentTab = totalTabs;
    
    showTab(currentTab);
}

// Tab button click handler
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const targetTab = parseInt(this.dataset.tab);
        
        // Langsung pindah tab tanpa validasi
        currentTab = targetTab;
        showTab(currentTab);
    });
});

// Toast notification with type support
function showToast(message, type = 'error') {
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.textContent = message;
    
    const bgColor = type === 'success' ? '#10b981' : '#ef4444';
    
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${bgColor};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 9999;
        animation: slideIn 0.3s ease;
        font-weight: 500;
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Form submission with validation
document.getElementById('gugatanForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validate all tabs
    let allValid = true;
    for (let i = 1; i <= totalTabs; i++) {
        const tempCurrent = currentTab;
        currentTab = i;
        if (!validateCurrentTab()) {
            allValid = false;
            showTab(i);
            break;
        }
        currentTab = tempCurrent;
    }
    
    if (!allValid) {
        showToast('Masih ada field yang belum diisi. Mohon periksa kembali.', 'error');
        return;
    }
    
    // Show loading
    const submitBtn = document.getElementById('submitBtn');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.textContent = 'Memproses...';
    
    // Submit form
    const formData = new FormData(this);
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            return response.text().then(text => {
                console.error('Server response:', text.substring(0, 500));
                throw new Error('Server error. Check console.');
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showToast('Dokumen berhasil dibuat! Mengunduh...', 'success');
            
            // Auto download file
            setTimeout(() => {
                window.location.href = data.data.download_url;
                
                // Redirect ke halaman utama
                setTimeout(() => {
                    window.location.href = APP_URLS.home;
                }, 2000);
            }, 1000);
        } else {
            throw new Error(data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast(error.message || 'Terjadi kesalahan', 'error');
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    });
});

// ===== MULTIPLE KUASA HUKUM =====
let kuasaCount = 1;

function tambahKuasa() {
    const idx = kuasaCount;
    const html = `
    <div class="kuasa-item" data-index="${idx}" style="border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 1.5rem; margin-bottom: 1.5rem; background: #f9fafb; position: relative;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h4 style="font-weight: 600; color: #374151;">Kuasa Hukum ke-${idx + 1}</h4>
            <button type="button" onclick="hapusKuasa(${idx})" style="background: #fee2e2; color: #dc2626; border: none; border-radius: 0.5rem; padding: 0.4rem 0.9rem; cursor: pointer; font-size: 0.85rem; display: flex; align-items: center; gap: 0.4rem;">
                <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Hapus
            </button>
        </div>
        <div class="grid grid-2">
            <div class="form-group">
                <label class="form-label">Nama Kuasa Hukum <span class="required">*</span></label>
                <input type="text" name="kuasa[${idx}][nama]" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">No. Telepon <span class="required">*</span></label>
                <input type="text" name="kuasa[${idx}][telepon]" class="form-control" placeholder="0812xxxxxx" required>
            </div>
            <div class="form-group">
                <label class="form-label">Email <span class="required">*</span></label>
                <input type="email" name="kuasa[${idx}][email]" class="form-control" placeholder="email@email.com" required>
            </div>
            <div class="form-group">
                <label class="form-label">Nomor Surat Kuasa <span class="required">*</span></label>
                <input type="text" name="kuasa[${idx}][nomor_surat_kuasa]" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Surat Kuasa <span class="required">*</span></label>
                <input type="date" name="kuasa[${idx}][tanggal_surat_kuasa]" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Nama Kantor <span class="required">*</span></label>
                <input type="text" name="kuasa[${idx}][kantor]" class="form-control" required>
            </div>
            <div class="form-group" style="grid-column: span 2;">
                <label class="form-label">Alamat Kantor Hukum <span class="required">*</span></label>
                <textarea name="kuasa[${idx}][alamat_kantor]" class="form-control" rows="3" required></textarea>
            </div>
        </div>
    </div>`;

    document.getElementById('kuasa-list').insertAdjacentHTML('beforeend', html);
    kuasaCount++;
    updateKuasaNumbers();
}

function hapusKuasa(idx) {
    const item = document.querySelector(`.kuasa-item[data-index="${idx}"]`);
    if (item) {
        item.remove();
        updateKuasaNumbers();
    }
}

function updateKuasaNumbers() {
    // Update label nomor urut setelah hapus
    document.querySelectorAll('.kuasa-item').forEach((el, i) => {
        const title = el.querySelector('h4');
        if (title) title.textContent = `Kuasa Hukum ke-${i + 1}`;
    });
}

// Input change listener
document.querySelectorAll('input, textarea, select').forEach(field => {
    field.addEventListener('input', function() {
        if (this.value) {
            this.style.borderColor = '#d1d5db';
            const errorMsg = this.parentElement.querySelector('.validation-error');
            if (errorMsg) errorMsg.remove();
        }
    });
    
    if (field.type === 'checkbox') {
        field.addEventListener('change', function() {
            if (this.checked) {
                this.style.borderColor = '#d1d5db';
                const errorMsg = this.parentElement.querySelector('.validation-error');
                if (errorMsg) errorMsg.remove();
            }
        });
    }
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
    .tab-content { display: none; }
    .tab-content.active { display: block; animation: fadeIn 0.3s ease; }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
`;
document.head.appendChild(style);

// Initialize
showTab(1);
</script>
@endpush