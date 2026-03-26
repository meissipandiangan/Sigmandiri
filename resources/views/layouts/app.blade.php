<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PTUN Tanjung Pinang - @yield('title')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">

    <style>
*, *::before, *::after {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:root {
    --navy:       #0A0E5A;
    --navy-mid:   #111580;
    --navy-light: #1A1FA3;
    --accent:     #F5C518;
    --accent-dim: #D4A900;
    --sky:        #3A7BD5;
    --sky-light:  #5B9BF0;
    --white:      #FFFFFF;
    --off-white:  #F4F6FB;
    --text-dark:  #0D1147;
    --text-muted: #5A6080;
    --border:     rgba(10,14,90,0.10);
    --glass:      rgba(255,255,255,0.07);
    --shadow-sm:  0 2px 12px rgba(10,14,90,0.08);
    --shadow-md:  0 8px 32px rgba(10,14,90,0.13);
    --shadow-lg:  0 20px 60px rgba(10,14,90,0.18);
    --radius-sm:  8px;
    --radius-md:  14px;
    --radius-lg:  22px;
    --radius-xl:  32px;
}

html { scroll-behavior: smooth; }

::selection { background: var(--navy-light); color: #fff; }

body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: var(--off-white);
    color: var(--text-dark);
    line-height: 1.65;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    /* subtle dot-grid background */
    background-image: radial-gradient(circle, #c5cbee 1px, transparent 1px);
    background-size: 28px 28px;
}

/* ============================================
   NAVBAR
   ============================================ */
.navbar {
    background: var(--navy);
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 50;
    box-shadow: 0 4px 24px rgba(10,14,90,0.30);
}

/* gold top stripe */
.navbar::before {
    content: '';
    display: block;
    height: 4px;
    background: linear-gradient(90deg, var(--accent) 0%, #fff 50%, var(--accent) 100%);
}

.navbar-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 80px;
}

.navbar-brand {
    display: flex;
    align-items: center;
    gap: 1rem;
    text-decoration: none;
    transition: opacity 0.2s;
}

.navbar-brand:hover { opacity: 0.88; }

.navbar-logo {
    background: rgba(255,255,255,0.12);
    border-radius: 14px;
    padding: 0.6rem;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1.5px solid rgba(255,255,255,0.18);
}

.navbar-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.navbar-title h1 {
    font-family: 'Playfair Display', serif;
    font-size: 1.45rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: 0.3px;
}

.navbar-title p {
    font-size: 0.75rem;
    color: var(--accent);
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
}

/* ============================================
   CONTENT SPACING
   ============================================ */
.content-spacer { height: 84px; }

.main-content { flex: 1; }

/* ============================================
   CONTAINER
   ============================================ */
.container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2.5rem 2rem;
}

/* ============================================
   CARDS
   ============================================ */
.card {
    background: var(--white);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-md);
    overflow: hidden;
    margin-bottom: 2rem;
    margin-top: 1.5rem;
    border: 1px solid var(--border);
    animation: slideUp 0.45s cubic-bezier(0.22, 1, 0.36, 1) both;
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(28px); }
    to   { opacity: 1; transform: translateY(0); }
}

.card-header {
    background: linear-gradient(130deg, var(--navy) 0%, var(--navy-light) 60%, var(--sky) 100%);
    padding: 2rem 2.5rem;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    overflow: hidden;
}

/* decorative circle in header */
.card-header::after {
    content: '';
    position: absolute;
    right: -40px;
    top: -40px;
    width: 160px;
    height: 160px;
    border-radius: 50%;
    background: rgba(255,255,255,0.06);
    pointer-events: none;
}

.card-header::before {
    content: '';
    position: absolute;
    right: 60px;
    bottom: -60px;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
    pointer-events: none;
}

.card-header h2 {
    font-family: 'Playfair Display', serif;
    font-size: 1.65rem;
    font-weight: 700;
    position: relative;
}

.card-header a {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.15);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    position: relative;
}

.card-header a:hover {
    background: rgba(255,255,255,0.25);
    transform: rotate(90deg);
}

.card-body {
    padding: 2rem 2.5rem;
}

/* ============================================
   BUTTONS
   ============================================ */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.875rem 2rem;
    border-radius: var(--radius-md);
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    font-size: 0.95rem;
    text-decoration: none;
    text-align: center;
    cursor: pointer;
    border: none;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    letter-spacing: 0.2px;
    position: relative;
    overflow: hidden;
}

.btn::after {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(255,255,255,0.12);
    opacity: 0;
    transition: opacity 0.2s;
}

.btn:hover::after { opacity: 1; }

.btn-primary {
    background: linear-gradient(135deg, var(--navy-light) 0%, var(--sky) 100%);
    color: white;
    box-shadow: 0 4px 18px rgba(26,31,163,0.30);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(26,31,163,0.40);
}

.btn-success {
    background: linear-gradient(135deg, #0ea775 0%, #059669 100%);
    color: white;
    box-shadow: 0 4px 18px rgba(5,150,105,0.28);
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(5,150,105,0.38);
}

.btn-secondary {
    background: var(--off-white);
    color: var(--text-dark);
    border: 2px solid var(--border);
}

.btn-secondary:hover {
    background: #e8ebf5;
    border-color: #c0c7e0;
}

.btn-block {
    display: flex;
    width: 100%;
}

.btn:disabled {
    opacity: 0.55;
    cursor: not-allowed;
    transform: none !important;
}

/* ============================================
   GRID SYSTEM
   ============================================ */
.grid {
    display: grid;
    gap: 1.5rem;
}

.grid-2 { grid-template-columns: repeat(2, 1fr); }

@media (max-width: 768px) {
    .grid-2 { grid-template-columns: 1fr; }
}

/* ============================================
   FORM ELEMENTS
   ============================================ */
.form-group { margin-bottom: 1.5rem; }

.form-label {
    display: block;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: var(--text-dark);
    font-size: 0.88rem;
    letter-spacing: 0.2px;
    text-transform: uppercase;
}

.form-label .required {
    color: #ef4444;
    margin-left: 0.25rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #dde1f0;
    border-radius: var(--radius-sm);
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 0.95rem;
    transition: all 0.25s ease;
    background: white;
    color: var(--text-dark);
}

.form-control:focus {
    outline: none;
    border-color: var(--navy-light);
    box-shadow: 0 0 0 3px rgba(26,31,163,0.10);
}

.form-control:hover { border-color: #b0b8d8; }

textarea.form-control {
    resize: vertical;
    min-height: 100px;
    line-height: 1.6;
}

input.form-control { height: 44px; }

/* ============================================
   TABS
   ============================================ */
.tabs {
    display: flex;
    gap: 0.4rem;
    padding: 1.25rem 2.5rem 0;
    background: white;
    overflow-x: auto;
    scrollbar-width: thin;
    border-bottom: 2px solid #dde1f0;
}

.tabs::-webkit-scrollbar { height: 5px; }
.tabs::-webkit-scrollbar-thumb {
    background: #b0b8d8;
    border-radius: 10px;
}

.tab-btn {
    padding: 0.875rem 1.75rem;
    background: var(--off-white);
    border: 2px solid #dde1f0;
    border-bottom: none;
    cursor: pointer;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    font-size: 0.9rem;
    color: var(--text-muted);
    border-radius: 10px 10px 0 0;
    white-space: nowrap;
    transition: all 0.25s ease;
    position: relative;
    margin-bottom: -2px;
    letter-spacing: 0.2px;
}

.tab-btn:hover {
    background: #eaecf8;
    color: var(--navy);
}

.tab-btn.active {
    background: white;
    color: var(--navy);
    border-color: var(--navy-light);
    border-bottom-color: white;
    z-index: 1;
}

.tab-btn.active::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--navy) 0%, var(--sky-light) 100%);
}

.tab-content {
    display: none;
    animation: fadeInUp 0.35s ease-out;
}

.tab-content.active { display: block; }

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ============================================
   INFO BOX & ALERTS
   ============================================ */
.info-box {
    background: linear-gradient(135deg, #e8eaf8 0%, #d5d9f5 100%);
    border-left: 5px solid var(--navy-light);
    padding: 1.5rem;
    border-radius: var(--radius-md);
    margin: 1.5rem 0;
}

.info-box h4 {
    color: var(--navy);
    margin-bottom: 0.6rem;
    font-weight: 800;
}

.info-box p {
    color: var(--navy-mid);
    font-size: 0.95rem;
    line-height: 1.6;
}

.alert {
    padding: 1.25rem 1.5rem;
    border-radius: var(--radius-md);
    margin-bottom: 1.5rem;
    border-left: 5px solid;
    font-weight: 500;
}

.alert-success {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    color: #065f46;
    border-color: #10b981;
}

.alert-error {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: #991b1b;
    border-color: #ef4444;
}

.alert strong { font-weight: 800; }

/* ============================================
   MODAL
   ============================================ */
.modal {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(10,14,90,0.55);
    backdrop-filter: blur(6px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 100;
    animation: fadeIn 0.25s ease;
}

.modal-content {
    background: white;
    padding: 3rem;
    border-radius: var(--radius-xl);
    max-width: 550px;
    width: 90%;
    box-shadow: var(--shadow-lg);
    animation: scaleIn 0.3s cubic-bezier(0.22,1,0.36,1);
    border-top: 4px solid var(--accent);
}

@keyframes scaleIn {
    from { transform: scale(0.88); opacity: 0; }
    to   { transform: scale(1);    opacity: 1; }
}

.modal-header {
    text-align: center;
    margin-bottom: 2rem;
}

.modal-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #e8eaf8, #d0d4f8);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}

.modal-icon svg {
    width: 40px;
    height: 40px;
    stroke: var(--navy-light);
}

.modal-header h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.65rem;
    font-weight: 700;
    color: var(--navy);
}

.modal-content p {
    text-align: center;
    line-height: 1.8;
    color: var(--text-muted);
    font-size: 1rem;
}

/* ============================================
   FOOTER
   ============================================ */
.footer {
    background: linear-gradient(130deg, var(--navy) 0%, #05082e 100%);
    color: #b0b8d8;
    text-align: center;
    padding: 1.75rem 2rem;
    border-top: 3px solid var(--accent);
    position: relative;
    overflow: hidden;
}

.footer::before {
    content: 'PTUN';
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%,-50%);
    font-family: 'Playfair Display', serif;
    font-size: 6rem;
    font-weight: 800;
    color: rgba(255,255,255,0.03);
    white-space: nowrap;
    pointer-events: none;
    letter-spacing: 8px;
}

.footer p {
    margin: 0.2rem 0;
    font-size: 0.875rem;
    position: relative;
}

.footer strong {
    color: var(--accent);
}

.footer .text-sm {
    font-size: 0.75rem;
    color: rgba(255,255,255,0.35);
    margin-top: 0.3rem;
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 768px) {
    .navbar-container {
        padding: 0 1rem;
        height: 74px;
    }

    .navbar-title h1 { font-size: 1.2rem; }
    .navbar-title p  { font-size: 0.7rem; }

    .navbar-logo {
        width: 52px;
        height: 52px;
    }

    .container { padding: 1.5rem 1rem; }

    .card-header {
        padding: 1.5rem 1.25rem;
    }

    .card-header h2 { font-size: 1.3rem; }
    .card-body      { padding: 1.5rem 1.25rem; }

    .tabs { padding: 0 1.25rem; }

    .grid-2 { grid-template-columns: 1fr; }

    .btn { padding: 0.75rem 1.5rem; }

    .form-group { margin-bottom: 1.25rem; }

    .footer p    { font-size: 0.78rem; }
    .footer .text-sm { font-size: 0.68rem; }
}

/* ============================================
   UTILITIES
   ============================================ */
.spinner {
    width: 48px;
    height: 48px;
    border: 4px solid rgba(10,14,90,0.15);
    border-top-color: var(--navy-light);
    border-radius: 50%;
    animation: spin 0.75s linear infinite;
}

@keyframes spin    { to { transform: rotate(360deg); } }
@keyframes fadeIn  { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body>

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('gugatan.index') }}" class="navbar-brand">
                <div class="navbar-logo">
                    <img src="{{ asset('1.png') }}" alt="PTUN Logo" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <div class="navbar-title">
                    <h1>PTUN Tanjung Pinang</h1>
                    <p>SIGMA</p>
                </div>
            </a>
        </div>
    </nav>

    <!-- Content Spacer -->
    <div class="content-spacer"></div>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- ===== FOOTER ===== -->
    <footer class="footer">
        <p>© 2026 <strong>SIGMA</strong> — Pengadilan Tata Usaha Negara Tanjung Pinang</p>
        <p class="text-sm">© Meissi Genovanni Pandiangan</p>
    </footer>

    @stack('scripts')
</body>
</html>