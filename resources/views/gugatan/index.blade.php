@extends('layouts.app')

@section('title', 'Pilih Jenis Draft Gugatan')

@section('content')
<style>
    .hero-section {
        min-height: calc(100vh - 80px - 100px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem;
        background-image: url('{{ asset('2.jpg') }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        position: relative;
    }

    /* Navy overlay sesuai warna instansi */
    .hero-section::before {
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

    /* Pola diagonal dekoratif */
    .hero-section::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image: repeating-linear-gradient(
            45deg,
            rgba(255,255,255,0.02) 0px,
            rgba(255,255,255,0.02) 1px,
            transparent 1px,
            transparent 28px
        );
        pointer-events: none;
    }

    .hero-container {
        max-width: 1100px;
        width: 100%;
        position: relative;
        z-index: 1;
    }

    /* ---- HEADER ---- */
    .hero-header {
        text-align: center;
        margin-bottom: 3rem;
        animation: heroFadeDown 0.6s cubic-bezier(0.22,1,0.36,1) both;
    }

    @keyframes heroFadeDown {
        from { opacity: 0; transform: translateY(-24px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(245, 197, 24, 0.18);
        border: 1px solid rgba(245, 197, 24, 0.45);
        color: #F5C518;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        padding: 0.45rem 1.1rem;
        border-radius: 999px;
        margin-bottom: 1.25rem;
    }

    .hero-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 88px;
        height: 88px;
        background: linear-gradient(135deg, #F5C518 0%, #D4A900 100%);
        border-radius: 50%;
        margin-bottom: 1.5rem;
        box-shadow: 0 12px 36px rgba(245, 197, 24, 0.38);
        border: 3px solid rgba(255,255,255,0.2);
    }

    .hero-icon svg {
        width: 42px;
        height: 42px;
        stroke: #0A0E5A;
        fill: none;
        stroke-width: 2;
    }

    .hero-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.4rem;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 1rem;
        line-height: 1.2;
        text-shadow: 0 2px 16px rgba(0,0,0,0.3);
    }

    .hero-subtitle {
        font-size: 1.05rem;
        color: rgba(255,255,255,0.72);
        max-width: 520px;
        margin: 0 auto;
        line-height: 1.7;
    }

    /* ---- DIVIDER ---- */
    .hero-divider {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin: 2rem auto;
        max-width: 280px;
    }

    .hero-divider span {
        flex: 1;
        height: 1px;
        background: rgba(245,197,24,0.35);
    }

    .hero-divider i {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #F5C518;
        display: inline-block;
    }

    /* ---- CARDS ---- */
    .card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.75rem;
        margin-bottom: 2rem;
    }

    .choice-card {
        background: rgba(255,255,255,0.06);
        backdrop-filter: blur(14px);
        border-radius: 22px;
        padding: 2.5rem 2rem;
        border: 1.5px solid rgba(255,255,255,0.14);
        text-decoration: none;
        display: block;
        transition: all 0.35s cubic-bezier(0.22,1,0.36,1);
        animation: cardFadeUp 0.55s cubic-bezier(0.22,1,0.36,1) both;
        position: relative;
        overflow: hidden;
    }

    .choice-card:nth-child(2) { animation-delay: 0.1s; }

    @keyframes cardFadeUp {
        from { opacity: 0; transform: translateY(32px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* shine sweep on hover */
    .choice-card::before {
        content: '';
        position: absolute;
        top: 0; left: -80%;
        width: 60%;
        height: 100%;
        background: linear-gradient(120deg, transparent, rgba(255,255,255,0.08), transparent);
        transform: skewX(-20deg);
        transition: left 0.5s ease;
    }

    .choice-card:hover::before { left: 140%; }

    .choice-card:hover {
        transform: translateY(-10px);
        border-color: rgba(245,197,24,0.55);
        box-shadow: 0 28px 60px rgba(0,0,0,0.35), 0 0 0 1px rgba(245,197,24,0.2);
        background: rgba(255,255,255,0.10);
    }

    /* coloured top stripe per card */
    .blue-card  { border-top: 3px solid #5B9BF0; }
    .amber-card { border-top: 3px solid #F5C518; }

    .card-icon-wrapper {
        display: flex;
        justify-content: center;
        margin-bottom: 1.75rem;
    }

    .card-icon {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.35s ease, box-shadow 0.35s ease;
    }

    .choice-card:hover .card-icon {
        transform: scale(1.08) rotate(4deg);
    }

    .blue-card .card-icon {
        background: linear-gradient(135deg, #1A1FA3 0%, #3A7BD5 100%);
        box-shadow: 0 8px 24px rgba(26,31,163,0.45);
    }

    .amber-card .card-icon {
        background: linear-gradient(135deg, #F5C518 0%, #D4A900 100%);
        box-shadow: 0 8px 24px rgba(245,197,24,0.40);
    }

    .card-icon svg {
        width: 40px;
        height: 40px;
        stroke: white;
        fill: none;
    }

    .amber-card .card-icon svg {
        stroke: #0A0E5A;
    }

    .card-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 700;
        color: #ffffff;
        text-align: center;
        margin-bottom: 0.875rem;
        transition: color 0.25s;
    }

    .blue-card:hover  .card-title { color: #a5c8ff; }
    .amber-card:hover .card-title { color: #F5C518; }

    .card-description {
        color: rgba(255,255,255,0.60);
        text-align: center;
        line-height: 1.7;
        font-size: 0.93rem;
        margin-bottom: 1.5rem;
    }

    .card-arrow {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-weight: 700;
        font-size: 0.875rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        opacity: 0;
        transform: translateY(6px);
        transition: all 0.3s ease;
        padding: 0.6rem 1.25rem;
        border-radius: 999px;
        width: fit-content;
        margin: 0 auto;
    }

    .blue-card  .card-arrow { background: rgba(91,155,240,0.18); color: #a5c8ff; border: 1px solid rgba(91,155,240,0.3); }
    .amber-card .card-arrow { background: rgba(245,197,24,0.15); color: #F5C518; border: 1px solid rgba(245,197,24,0.35); }

    .choice-card:hover .card-arrow {
        opacity: 1;
        transform: translateY(0);
    }

    .card-arrow svg {
        width: 16px;
        height: 16px;
        stroke: currentColor;
        transition: transform 0.25s;
    }

    .choice-card:hover .card-arrow svg {
        transform: translateX(4px);
    }

    @media (max-width: 768px) {
        .hero-title   { font-size: 1.7rem; }
        .hero-subtitle { font-size: 0.95rem; }
        .choice-card  { padding: 2rem 1.5rem; }
        .card-title   { font-size: 1.2rem; }
    }
</style>

<div class="hero-section">
    <div class="hero-container">

        <!-- Header -->
        <div class="hero-header">
            <h2 class="hero-title">SIGMA</h2>
            <p class="hero-subtitle">Pilih jenis gugatan yang sesuai dengan kebutuhan Anda untuk memulai penyusunan dokumen</p>
            <div class="hero-divider"><span></span><i></i><span></span></div>
        </div>

        <!-- Cards -->
        <div class="card-grid">

            <!-- Draft dengan Kuasa Hukum -->
            <a href="{{ route('gugatan.create', 'kuasa_hukum') }}" class="choice-card blue-card">
                <div class="card-icon-wrapper">
                    <div class="card-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="card-title">Draft Gugatan dengan Kuasa Hukum</h3>
                <p class="card-description">Untuk gugatan yang diwakili oleh advokat atau kuasa hukum resmi</p>
                <div class="card-arrow">
                    <span>Pilih</span>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <!-- Draft Perorangan -->
            <a href="{{ route('gugatan.create', 'perorangan') }}" class="choice-card amber-card">
                <div class="card-icon-wrapper">
                    <div class="card-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="card-title">Draft Gugatan Perorangan</h3>
                <p class="card-description">Untuk gugatan yang diajukan langsung oleh penggugat tanpa kuasa hukum</p>
                <div class="card-arrow">
                    <span>Pilih</span>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

        </div>
    </div>
</div>
@endsection