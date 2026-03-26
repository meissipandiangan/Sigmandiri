@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<style>
    .home-hero {
        min-height: calc(100vh - 80px - 100px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 4rem 2rem;
        background-image: url('{{ asset('2.jpg') }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        position: relative;
        overflow: hidden;
    }

    /* Soft blue gradient overlay */
    .home-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(
            160deg,
            rgba(91, 155, 240, 0.88) 0%,
            rgba(58, 123, 213, 0.82) 40%,
            rgba(26, 31, 163, 0.78) 100%
        );
    }

    /* Decorative pattern overlay */
    .home-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image: repeating-linear-gradient(
            45deg,
            rgba(255,255,255,0.03) 0px,
            rgba(255,255,255,0.03) 1px,
            transparent 1px,
            transparent 32px
        );
        pointer-events: none;
    }

    /* Floating elements animation */
    .floating-shape {
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
        animation: float 20s infinite ease-in-out;
    }

    .shape-1 {
        width: 300px;
        height: 300px;
        top: 10%;
        left: 5%;
        animation-delay: 0s;
    }

    .shape-2 {
        width: 200px;
        height: 200px;
        bottom: 15%;
        right: 8%;
        animation-delay: 3s;
    }

    .shape-3 {
        width: 150px;
        height: 150px;
        top: 60%;
        left: 15%;
        animation-delay: 6s;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        25% { transform: translateY(-30px) rotate(5deg); }
        50% { transform: translateY(-60px) rotate(10deg); }
        75% { transform: translateY(-30px) rotate(5deg); }
    }

    .home-content {
        max-width: 900px;
        width: 100%;
        position: relative;
        z-index: 1;
        text-align: center;
        animation: contentFadeIn 0.8s cubic-bezier(0.22,1,0.36,1) both;
    }

    @keyframes contentFadeIn {
        from { opacity: 0; transform: translateY(40px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Logo container */
    .home-logo {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 120px;
        height: 120px;
        background: rgba(255,255,255,0.15);
        border-radius: 30px;
        margin-bottom: 2rem;
        box-shadow: 0 16px 48px rgba(10, 14, 90, 0.35);
        border: 4px solid rgba(255,255,255,0.3);
        animation: logoFloat 3s ease-in-out infinite;
    }

    @keyframes logoFloat {
        0%, 100% { transform: translateY(0) scale(1); }
        50% { transform: translateY(-10px) scale(1.02); }
    }

    .home-logo img {
        width: 80px;
        height: 80px;
        object-fit: contain;
    }

    /* Badge */
    .home-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(245, 197, 24, 0.20);
        border: 1.5px solid rgba(245, 197, 24, 0.50);
        color: #F5C518;
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        padding: 0.5rem 1.25rem;
        border-radius: 999px;
        margin-bottom: 1.5rem;
        backdrop-filter: blur(8px);
    }

    .home-badge svg {
        width: 14px;
        height: 14px;
    }

    /* Title */
    .home-title {
        font-family: 'Playfair Display', serif;
        font-size: 3.5rem;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 1rem;
        line-height: 1.15;
        text-shadow: 0 4px 24px rgba(0,0,0,0.3);
        letter-spacing: -1px;
    }

    .home-title span {
        display: block;
        font-size: 2.2rem;
        color: #F5C518;
        margin-top: 0.5rem;
        font-weight: 700;
    }

    /* Description */
    .home-description {
        font-size: 1.15rem;
        color: rgba(255,255,255,0.85);
        max-width: 680px;
        margin: 0 auto 3rem;
        line-height: 1.8;
        font-weight: 500;
    }

    /* Divider */
    .home-divider {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        margin: 2.5rem auto;
        max-width: 320px;
    }

    .home-divider span {
        flex: 1;
        height: 2px;
        background: linear-gradient(90deg, transparent, rgba(245,197,24,0.5), transparent);
    }

    .home-divider i {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #F5C518;
        box-shadow: 0 0 12px rgba(245,197,24,0.6);
    }

    /* CTA Button */
    .home-cta {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        background: linear-gradient(135deg, #F5C518 0%, #D4A900 100%);
        color: #0A0E5A;
        font-size: 1.1rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        padding: 1.25rem 3rem;
        border-radius: 16px;
        text-decoration: none;
        transition: all 0.35s cubic-bezier(0.22,1,0.36,1);
        box-shadow: 0 12px 36px rgba(245, 197, 24, 0.45);
        border: 2px solid rgba(255,255,255,0.2);
        position: relative;
        overflow: hidden;
    }

    .home-cta::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.2), transparent);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .home-cta:hover::before {
        opacity: 1;
    }

    .home-cta:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 20px 56px rgba(245, 197, 24, 0.55);
    }

    .home-cta svg {
        width: 24px;
        height: 24px;
        stroke: currentColor;
        transition: transform 0.3s;
    }

    .home-cta:hover svg {
        transform: translateX(6px);
    }

    /* Features */
    .home-features {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
        margin-top: 4rem;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }

    .feature-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
        padding: 1.5rem;
        background: rgba(255,255,255,0.08);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        border: 1px solid rgba(255,255,255,0.15);
        transition: all 0.3s ease;
    }

    .feature-item:hover {
        background: rgba(255,255,255,0.12);
        transform: translateY(-6px);
        border-color: rgba(245,197,24,0.4);
    }

    /* Override hover untuk button panduan (putih transparan) */
    .home-cta.btn-panduan:hover {
    background: rgba(255,255,255,0.25) !important;
    box-shadow: 0 20px 56px rgba(0,0,0,0.3) !important;
    }

    .feature-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(245,197,24,0.25), rgba(245,197,24,0.15));
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(245,197,24,0.3);
    }

    .feature-icon svg {
        width: 26px;
        height: 26px;
        stroke: #F5C518;
    }

    .feature-text {
        color: rgba(255,255,255,0.90);
        font-size: 0.9rem;
        font-weight: 600;
        text-align: center;
        line-height: 1.5;
    }

    /* Institution info */
    .institution-info {
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(255,255,255,0.15);
    }

    .institution-name {
        color: rgba(255,255,255,0.75);
        font-size: 0.95rem;
        font-weight: 600;
        letter-spacing: 1px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .home-hero {
            padding: 3rem 1.5rem;
        }

        .home-title {
            font-size: 2.2rem;
        }

        .home-title span {
            font-size: 1.5rem;
        }

        .home-description {
            font-size: 1rem;
        }

        .home-logo {
            width: 100px;
            height: 100px;
        }

        .home-logo img {
            width: 65px;
            height: 65px;
        }

        .home-cta {
            font-size: 1rem;
            padding: 1rem 2rem;
        }

        .home-features {
            grid-template-columns: 1fr;
            gap: 1.25rem;
        }

        .shape-1, .shape-2, .shape-3 {
            display: none;
        }
    @media (max-width: 480px) {
    .home-cta {
        width: 100%;
        justify-content: center;
    }
    }
</style>

<div class="home-hero">
    <!-- Floating decorative shapes -->
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>
    <div class="floating-shape shape-3"></div>

    <div class="home-content">
        <!-- Logo -->
        <div class="home-logo">
            <img src="{{ asset('1.png') }}" alt="PTUN Logo">
        </div>

        <!-- Title -->
        <h1 class="home-title">
            Selamat Datang di
            <span>SIGMA</span>
        </h1>

        <!-- Description -->
        <p class="home-description">
            Sistem Informasi Gugatan Mandiri — 
            SIGMA merupakan inovasi teknologi informasi dari PTUN Tanjung Pinang Untuk mempermudah masyarakat dalam penyusunan gugatan secara Mandiri.
        </p>

        <!-- Divider -->
        <div class="home-divider">
            <span></span>
            <i></i>
            <span></span>
        </div>

        <!-- CTA Buttons -->
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('gugatan.index') }}" class="home-cta">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Mulai Buat Gugatan
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>

            <a href="https://drive.google.com/drive/folders/1e7xgIkSM22s2EFbgRT2Q9i5PAMEO-Cip?usp=sharing"
            target="_blank"
            class="home-cta"
            style="background: rgba(255,255,255,0.15); color: #ffffff; border: 2px solid rgba(255,255,255,0.35); box-shadow: 0 12px 36px rgba(0,0,0,0.2); backdrop-filter: blur(10px);">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Buku Panduan
            </a>
        </div>

        <!-- Features -->
        <div class="home-features">
            <div class="feature-item">
                <div class="feature-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <span class="feature-text">Proses Cepat & Mudah</span>
            </div>

            <div class="feature-item">
                <div class="feature-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <span class="feature-text">Aman & Terpercaya</span>
            </div>

            <div class="feature-item">
                <div class="feature-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                    </svg>
                </div>
                <span class="feature-text">Ramah Pengguna</span>
            </div>
        </div>

        <!-- Institution Info -->
        <div class="institution-info">
            <p class="institution-name">Pengadilan Tata Usaha Negara Tanjung Pinang</p>
        </div>
    </div>
</div>
@endsection