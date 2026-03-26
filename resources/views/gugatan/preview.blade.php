@extends('layouts.app')

@section('title', 'Download Gugatan')

@section('content')
<div class="min-h-screen py-12 px-4">
    <div class="max-w-3xl mx-auto">
        <!-- Success Card with entrance animation -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden mb-8 animate-scale-in">
            <!-- Header with animated success icon -->
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-12 text-center relative overflow-hidden">
                <!-- Animated background particles -->
                <div class="absolute inset-0">
                    <div class="absolute top-10 left-10 w-20 h-20 bg-white rounded-full opacity-10 animate-ping"></div>
                    <div class="absolute bottom-10 right-10 w-16 h-16 bg-white rounded-full opacity-10 animate-ping" style="animation-delay: 0.5s;"></div>
                    <div class="absolute top-1/2 left-1/2 w-24 h-24 bg-white rounded-full opacity-5 animate-pulse"></div>
                </div>
                
                <div class="relative z-10">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full mb-4 animate-bounce">
                        <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-white mb-2 animate-fade-in">Dokumen Berhasil Dibuat!</h2>
                    <p class="text-green-100 animate-fade-in" style="animation-delay: 0.2s;">Gugatan Anda telah berhasil di-generate</p>
                </div>
            </div>

            <!-- Content with stagger animation -->
            <div class="p-8">
                <div class="space-y-4 mb-8 stagger-animation">
                    <div class="flex items-start p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all hover-lift">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm text-gray-500 font-medium">Nama Penggugat</p>
                            <p class="font-semibold text-gray-800 text-lg">{{ $gugatan->nama_penggugat }}</p>
                        </div>
                    </div>

                    <div class="flex items-start p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all hover-lift">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm text-gray-500 font-medium">Objek Sengketa</p>
                            <p class="font-semibold text-gray-800">{{ $gugatan->judul_keputusan }}</p>
                            <p class="text-sm text-gray-600 mt-1">Nomor: {{ $gugatan->nomor_keputusan }}</p>
                        </div>
                    </div>

                    <div class="flex items-start p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all hover-lift">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm text-gray-500 font-medium">Tergugat</p>
                            <p class="font-semibold text-gray-800">{{ $gugatan->nama_tergugat }}</p>
                        </div>
                    </div>

                    <div class="flex items-start p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all hover-lift">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-cyan-400 to-cyan-600 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm text-gray-500 font-medium">Tanggal Dibuat</p>
                            <p class="font-semibold text-gray-800">{{ $gugatan->created_at->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Download Button with hover effect -->
                <a href="{{ route('gugatan.download', $gugatan->id) }}" class="block w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg text-center hover-lift ripple relative overflow-hidden group">
                    <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                    <span class="relative z-10 flex items-center justify-center">
                        <svg class="w-6 h-6 mr-2 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Download Dokumen (.docx)
                    </span>
                </a>

                <!-- Info Box with modern design -->
                <div class="mt-6 bg-gradient-to-r from-blue-50 to-cyan-50 border border-blue-200 rounded-xl p-6 hover:shadow-lg transition-all hover-lift">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="font-semibold text-blue-800 mb-2 text-lg">Catatan Penting:</p>
                            <ul class="space-y-2 text-sm text-blue-700">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Dokumen ini merupakan draft panduan yang dapat disesuaikan
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Pastikan untuk memeriksa kembali seluruh isi dokumen
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Konsultasikan dengan advokat jika diperlukan
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    File akan tersimpan dalam format Microsoft Word (.docx)
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons with hover effects -->
        <div class="grid md:grid-cols-2 gap-4 stagger-animation">
            <a href="{{ route('gugatan.index') }}" class="block text-center bg-white hover:bg-gray-50 text-gray-700 font-semibold py-4 px-6 rounded-xl border-2 border-gray-300 transition-all duration-300 hover-lift ripple group">
                <span class="flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Buat Gugatan Baru
                </span>
            </a>

            <button onclick="window.print()" class="bg-white hover:bg-gray-50 text-gray-700 font-semibold py-4 px-6 rounded-xl border-2 border-gray-300 transition-all duration-300 hover-lift ripple group">
                <span class="flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Cetak Halaman Ini
                </span>
            </button>
        </div>
    </div>
</div>

@if(session('success'))
<div id="successToast" class="fixed top-4 right-4 bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-4 rounded-xl shadow-2xl z-50 transform transition-all duration-300 animate-slide-in-right">
    <div class="flex items-center">
        <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center mr-3">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
</div>

<script>
    setTimeout(() => {
        const toast = document.getElementById('successToast');
        if (toast) {
            toast.style.transform = 'translateX(400px)';
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        }
    }, 3000);
</script>
@endif

@push('scripts')
<script>
    // Enhanced page animations
    document.addEventListener('DOMContentLoaded', () => {
        // Animate cards on scroll
        const cards = document.querySelectorAll('.hover-lift');
        
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, index * 100);
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);
        
        cards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            observer.observe(card);
        });
    });
</script>
@endpush
@endsection