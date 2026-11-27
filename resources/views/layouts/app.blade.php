{{-- Hallmark · macrostructure: Playful Civic Dashboard · theme: WargaNet Pastel Blue · genre: playful --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WargaNet — Portal Lingkungan Warga</title>

  <!-- Typography: Plus Jakarta Sans (Rounded, Friendly Display) & Inter (Legible UI) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

  <style>
    /* WargaNet Pastel Blue & Soft Tactile Token Palette (Matching Reference Design) */
    :root {
      --font-display: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
      --font-body: 'Inter', system-ui, -apple-system, sans-serif;

      /* Canvas & Surface */
      --color-canvas: #edf4fd;
      --color-surface: #ffffff;
      --color-surface-subtle: #f5f9ff;
      --color-surface-muted: #e8f1fc;

      /* Borders */
      --color-border-subtle: #e2edfb;
      --color-border-card: #e5effd;
      --color-border-focus: #3b82f6;

      /* Primary Brand & Accents */
      --color-accent: #2563eb;
      --color-accent-hover: #1d4ed8;
      --color-accent-light: #eff6ff;
      --color-accent-subtle: #dbeafe;
      --color-accent-contrast: #ffffff;

      /* Text Colors */
      --color-text-main: #1e293b;
      --color-text-muted: #64748b;
      --color-text-faint: #94a3b8;
      --color-text-inverse: #ffffff;

      /* Status Signals */
      --color-urgent: #ef4444;
      --color-urgent-bg: #fee2e2;
      --color-urgent-text: #991b1b;

      --color-verified: #10b981;
      --color-verified-bg: #d1fae5;
      --color-verified-text: #065f46;

      --color-warning: #f59e0b;
      --color-warning-bg: #fef3c7;
      --color-warning-text: #92400e;

      /* Geometry & Shadows from Reference */
      --radius-sm: 0.6rem;
      --radius-md: 0.85rem;
      --radius-lg: 1.25rem;
      --radius-card: 1.15rem;
      --radius-pill: 9999px;

      --shadow-app: 0 10px 30px rgba(37, 99, 235, 0.08), 0 1px 3px rgba(0, 0, 0, 0.03);
      --shadow-card: 0 4px 18px rgba(37, 99, 235, 0.04);
      --shadow-hover: 0 6px 22px rgba(37, 99, 235, 0.09);
    }

    /* Mobile Hard Floor Reset */
    html, body {
      overflow-x: clip !important;
      background-color: var(--color-canvas);
      color: var(--color-text-main);
      font-family: var(--font-body);
      font-size: 14.5px;
      line-height: 1.5;
      margin: 0;
      padding: 0;
      -webkit-font-smoothing: antialiased;
    }

    h1, h2, h3, h4, h5, h6 {
      font-family: var(--font-display);
      color: var(--color-text-main);
      font-weight: 700;
      overflow-wrap: anywhere;
      min-width: 0;
    }

    /* Desktop Window Container Frame */
    .app-window-shell {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      padding: 1rem;
    }

    @media (min-width: 992px) {
      .app-window-shell {
        padding: 1.25rem 2rem 2rem;
        max-width: 1480px;
        margin: 0 auto;
      }
    }

    .app-frame-card {
      background: var(--color-surface);
      border-radius: var(--radius-lg);
      border: 1px solid var(--color-border-card);
      box-shadow: var(--shadow-app);
      display: flex;
      flex-direction: column;
      overflow: hidden;
      flex-grow: 1;
    }

    /* Window Header Titlebar (Desktop App Style from Reference) */
    .app-titlebar {
      background: var(--color-surface-subtle);
      border-bottom: 1px solid var(--color-border-subtle);
      padding: 0.6rem 1.25rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
    }

    .window-controls-dots {
      display: flex;
      align-items: center;
      gap: 0.45rem;
    }

    .window-dot {
      width: 11px;
      height: 11px;
      border-radius: 50%;
      background: #cbd5e1;
    }
    .window-dot-red { background: #f87171; }
    .window-dot-yellow { background: #fbbf24; }
    .window-dot-green { background: #34d399; }

    /* Main App Layout: Sidebar + Canvas */
    .app-body-layout {
      display: flex;
      flex-direction: column;
      flex-grow: 1;
    }

    @media (min-width: 992px) {
      .app-body-layout {
        flex-direction: row;
      }
    }

    /* Left Sidebar */
    .app-sidebar {
      width: 100%;
      background: var(--color-surface);
      border-right: 1px solid var(--color-border-subtle);
      padding: 1.25rem 1rem;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      gap: 1.5rem;
    }

    @media (min-width: 992px) {
      .app-sidebar {
        width: 260px;
        flex-shrink: 0;
        min-height: calc(100vh - 120px);
      }
    }

    /* Brand Logo */
    .sidebar-brand {
      display: flex;
      align-items: center;
      gap: 0.65rem;
      text-decoration: none;
      color: var(--color-accent);
      font-family: var(--font-display);
      font-weight: 800;
      font-size: 1.25rem;
      padding: 0 0.5rem 0.5rem;
    }

    .sidebar-brand-icon {
      width: 2.2rem;
      height: 2.2rem;
      border-radius: var(--radius-md);
      background: var(--color-accent);
      color: #ffffff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.15rem;
    }

    /* Sidebar Navigation Links (Active Pill State) */
    .sidebar-nav-group {
      display: flex;
      flex-direction: column;
      gap: 0.35rem;
    }

    .sidebar-nav-link {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.65rem 0.95rem;
      border-radius: var(--radius-pill);
      font-family: var(--font-display);
      font-weight: 600;
      font-size: 0.885rem;
      color: var(--color-text-muted);
      text-decoration: none;
      transition: all 0.15s ease;
      white-space: nowrap;
    }

    .sidebar-nav-link:hover {
      color: var(--color-accent);
      background-color: var(--color-surface-subtle);
    }

    .sidebar-nav-link.active {
      background-color: var(--color-accent);
      color: #ffffff !important;
      box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    .sidebar-nav-link.active .nav-icon {
      color: #ffffff;
    }

    .nav-icon {
      font-size: 1.05rem;
      width: 1.25rem;
      text-align: center;
    }

    /* Sidebar Mascot Bottom Box */
    .sidebar-mascot-card {
      background: linear-gradient(145deg, #f0f7ff, #e4effd);
      border: 1px solid var(--color-border-card);
      border-radius: var(--radius-md);
      padding: 1rem 0.85rem;
      text-align: center;
      position: relative;
    }

    .sidebar-mascot-img {
      width: 76px;
      height: auto;
      margin-bottom: 0.4rem;
      filter: drop-shadow(0 3px 6px rgba(37, 99, 235, 0.12));
    }

    .sidebar-mascot-text {
      font-size: 0.78rem;
      font-weight: 700;
      color: var(--color-accent);
      line-height: 1.35;
      font-family: var(--font-display);
    }

    /* Main Viewport Content Area */
    .app-main-content {
      flex-grow: 1;
      background: var(--color-surface-subtle);
      padding: 1.25rem 1.25rem 2rem;
      min-width: 0;
    }

    @media (min-width: 992px) {
      .app-main-content {
        padding: 1.75rem 2rem 2.5rem;
      }
    }

    /* Top Live Header Card (Matching Reference Hero Banner) */
    .hero-banner-card {
      background: linear-gradient(135deg, #ffffff 0%, #edf5fe 100%);
      border: 1px solid var(--color-border-card);
      border-radius: var(--radius-card);
      padding: 1.25rem 1.75rem;
      position: relative;
      overflow: hidden;
      box-shadow: var(--shadow-card);
      margin-bottom: 1.5rem;
    }

    .hero-banner-title {
      font-size: 1.65rem;
      font-weight: 800;
      color: var(--color-text-main);
      margin-bottom: 0.25rem;
    }

    .hero-banner-desc {
      color: var(--color-text-muted);
      font-size: 0.925rem;
      margin-bottom: 0;
    }

    .hero-mascot-img {
      max-height: 110px;
      width: auto;
      filter: drop-shadow(0 4px 10px rgba(37, 99, 235, 0.15));
    }

    /* Digital Clock Pill from Reference */
    .live-clock-card {
      background: #ffffff;
      border: 1px solid var(--color-border-card);
      border-radius: var(--radius-md);
      padding: 0.65rem 1.15rem;
      box-shadow: var(--shadow-card);
      text-align: center;
      min-width: 120px;
    }

    .clock-date {
      font-size: 0.75rem;
      font-weight: 600;
      color: var(--color-text-muted);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.35rem;
    }

    .clock-time {
      font-family: var(--font-display);
      font-size: 1.45rem;
      font-weight: 800;
      color: var(--color-accent);
      line-height: 1.15;
    }

    .clock-wib {
      font-size: 0.7rem;
      color: var(--color-text-muted);
      font-weight: 600;
    }

    /* Stat Cards (Ringkasan Hari Ini) */
    .stat-pill-card {
      background: var(--color-surface);
      border: 1px solid var(--color-border-card);
      border-radius: var(--radius-card);
      padding: 1.15rem 1rem;
      box-shadow: var(--shadow-card);
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      transition: transform 0.15s ease, box-shadow 0.15s ease;
      height: 100%;
    }

    .stat-pill-card:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow-hover);
    }

    .stat-icon-circle {
      width: 2.75rem;
      height: 2.75rem;
      border-radius: 50%;
      background: var(--color-accent-light);
      color: var(--color-accent);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.25rem;
      margin-bottom: 0.6rem;
    }

    .stat-value {
      font-family: var(--font-display);
      font-size: 1.65rem;
      font-weight: 800;
      color: var(--color-text-main);
      line-height: 1.1;
      margin-bottom: 0.2rem;
    }

    .stat-label {
      font-size: 0.8rem;
      font-weight: 600;
      color: var(--color-text-muted);
    }

    /* Soft Rounded Section Cards */
    .app-card {
      background: var(--color-surface);
      border: 1px solid var(--color-border-card);
      border-radius: var(--radius-card);
      box-shadow: var(--shadow-card);
      padding: 1.25rem 1.5rem;
      height: 100%;
    }

    .app-card-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
      margin-bottom: 1.15rem;
      flex-wrap: wrap;
    }

    .app-card-title {
      font-size: 1.05rem;
      font-weight: 700;
      color: var(--color-text-main);
      margin: 0;
    }

    .app-card-action {
      font-size: 0.825rem;
      font-weight: 700;
      color: var(--color-accent);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.25rem;
    }

    .app-card-action:hover {
      text-decoration: underline;
    }

    /* Interactive Buttons */
    .btn-pill {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.45rem;
      font-family: var(--font-display);
      font-weight: 700;
      font-size: 0.85rem;
      padding: 0.5rem 1.15rem;
      border-radius: var(--radius-pill);
      border: 1px solid transparent;
      text-decoration: none;
      white-space: nowrap;
      cursor: pointer;
      transition: all 0.15s ease;
    }

    .btn-pill-primary {
      background: var(--color-accent);
      color: #ffffff;
      box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    .btn-pill-primary:hover {
      background: var(--color-accent-hover);
      color: #ffffff;
      transform: translateY(-1px);
    }

    .btn-pill-outline {
      background: #ffffff;
      color: var(--color-accent);
      border-color: var(--color-accent);
    }

    .btn-pill-outline:hover {
      background: var(--color-accent-light);
      color: var(--color-accent-hover);
    }

    .btn-pill-danger {
      background: var(--color-urgent);
      color: #ffffff;
      box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
    }

    .btn-pill-subtle {
      background: var(--color-surface-muted);
      color: var(--color-text-main);
    }

    .btn-pill-subtle:hover {
      background: var(--color-accent-subtle);
      color: var(--color-accent);
    }

    .btn-pill-sm {
      padding: 0.35rem 0.85rem;
      font-size: 0.785rem;
    }

    /* Status Pills from Reference */
    .badge-pill {
      display: inline-flex;
      align-items: center;
      gap: 0.3rem;
      font-size: 0.75rem;
      font-weight: 700;
      padding: 0.25rem 0.65rem;
      border-radius: var(--radius-pill);
      white-space: nowrap;
    }

    .badge-pill-blue {
      background: var(--color-accent-subtle);
      color: var(--color-accent);
    }

    .badge-pill-green {
      background: var(--color-verified-bg);
      color: var(--color-verified-text);
    }

    .badge-pill-yellow {
      background: var(--color-warning-bg);
      color: var(--color-warning-text);
    }

    .badge-pill-red {
      background: var(--color-urgent-bg);
      color: var(--color-urgent-text);
    }

    /* Filter Pill Tabs from Reference ("Semua", "Makanan & Minuman", etc) */
    .filter-pills-row {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      overflow-x: auto;
      padding-bottom: 0.4rem;
      scrollbar-width: thin;
    }

    .filter-pill-item {
      display: inline-flex;
      align-items: center;
      font-family: var(--font-display);
      font-size: 0.825rem;
      font-weight: 600;
      padding: 0.4rem 1rem;
      border-radius: var(--radius-pill);
      background: var(--color-surface);
      color: var(--color-text-muted);
      border: 1px solid var(--color-border-card);
      text-decoration: none;
      white-space: nowrap;
      transition: all 0.15s ease;
    }

    .filter-pill-item:hover {
      color: var(--color-accent);
      border-color: var(--color-accent-subtle);
    }

    .filter-pill-item.active {
      background: var(--color-accent);
      color: #ffffff;
      border-color: var(--color-accent);
      box-shadow: 0 3px 10px rgba(37, 99, 235, 0.2);
    }

    /* Forms with Rounded Styling */
    .form-control-pill, .form-select-pill {
      background: #ffffff;
      border: 1px solid var(--color-border-card);
      border-radius: var(--radius-pill);
      padding: 0.6rem 1.15rem;
      font-size: 0.885rem;
      color: var(--color-text-main);
      transition: border-color 0.15s ease, box-shadow 0.15s ease;
      width: 100%;
    }

    .form-control-pill:focus, .form-select-pill:focus {
      outline: none;
      border-color: var(--color-border-focus);
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .form-textarea-pill {
      background: #ffffff;
      border: 1px solid var(--color-border-card);
      border-radius: var(--radius-md);
      padding: 0.75rem 1rem;
      font-size: 0.885rem;
      color: var(--color-text-main);
      width: 100%;
    }

    .form-textarea-pill:focus {
      outline: none;
      border-color: var(--color-border-focus);
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    /* Responsive adjustments */
    #map {
      height: 340px;
      border-radius: var(--radius-md);
      border: 1px solid var(--color-border-card);
    }

    /* Sub-nav for Admin */
    .admin-tab-bar {
      background: #ffffff;
      border: 1px solid var(--color-border-card);
      border-radius: var(--radius-pill);
      padding: 0.35rem;
      display: inline-flex;
      gap: 0.25rem;
      overflow-x: auto;
      max-width: 100%;
      margin-bottom: 1.25rem;
    }

    .admin-tab-link {
      font-size: 0.825rem;
      font-weight: 600;
      font-family: var(--font-display);
      padding: 0.35rem 0.85rem;
      border-radius: var(--radius-pill);
      color: var(--color-text-muted);
      text-decoration: none;
      white-space: nowrap;
    }

    .admin-tab-link.active {
      background: var(--color-accent);
      color: #ffffff;
    }

    /* Alerts */
    .app-alert {
      border-radius: var(--radius-md);
      padding: 0.85rem 1.15rem;
      margin-bottom: 1.25rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      font-size: 0.885rem;
    }
    .app-alert-success {
      background: var(--color-verified-bg);
      color: var(--color-verified-text);
      border: 1px solid rgba(16, 185, 129, 0.2);
    }
    .app-alert-danger {
      background: var(--color-urgent-bg);
      color: var(--color-urgent-text);
      border: 1px solid rgba(239, 68, 68, 0.2);
    }
  </style>
</head>
<body>
  @php
    $u = auth()->user();
  @endphp

  <div class="app-window-shell">
    <div class="app-frame-card">
      
      <!-- Top Titlebar with Decorative Window Dots & User Status -->
      <header class="app-titlebar">
        <div class="d-flex align-items-center gap-2">
          <!-- Window Dots (Soft Aesthetic Reference) -->
          <div class="window-controls-dots d-none d-sm-flex">
            <span class="window-dot window-dot-red"></span>
            <span class="window-dot window-dot-yellow"></span>
            <span class="window-dot window-dot-green"></span>
          </div>
          <span class="small fw-bold text-muted ms-2 d-none d-md-inline" style="font-family: var(--font-display);">
            WargaNet Desktop · Sistem Informasi & Komunikasi Lingkungan
          </span>
        </div>

        <!-- Right Quick Controls -->
        <div class="d-flex align-items-center gap-2">
          <a href="tel:112" class="badge-pill badge-pill-red text-decoration-none" title="Panggilan Darurat Bebas Pulsa">
            🚨 112 Bebas Pulsa
          </a>

          @guest
            <a href="/login" class="btn-pill btn-pill-outline btn-pill-sm">Masuk</a>
            <a href="/register" class="btn-pill btn-pill-primary btn-pill-sm">Daftar</a>
          @else
            <span class="small fw-semibold text-muted d-none d-sm-inline">
              👋 {{ $u->name }} ({{ $u->role === 'admin' ? 'Pengurus' : 'Warga' }})
            </span>
            <form method="post" action="/logout" class="d-inline m-0">
              @csrf
              <button type="submit" class="btn-pill btn-pill-subtle btn-pill-sm">Keluar</button>
            </form>
          @endguest
        </div>
      </header>

      <!-- App Body Layout: Sidebar + Main Content -->
      <div class="app-body-layout">
        
        <!-- Left Sidebar Navigation -->
        <aside class="app-sidebar">
          <div>
            <!-- Brand -->
            <a href="/" class="sidebar-brand">
              <span class="sidebar-brand-icon">🏠</span>
              <span>WargaNet</span>
            </a>

            <!-- Navigation Links (Matching Reference UI) -->
            <nav class="sidebar-nav-group mt-3">
              <a href="/" class="sidebar-nav-link {{ request()->is('/') ? 'active' : '' }}">
                <span class="nav-icon">🏠</span>
                <span>Beranda</span>
              </a>

              <a href="/schedules" class="sidebar-nav-link {{ request()->is('schedules*') ? 'active' : '' }}">
                <span class="nav-icon">📅</span>
                <span>Informasi Lingkungan</span>
              </a>

              <a href="/announcements" class="sidebar-nav-link {{ request()->is('announcements*') ? 'active' : '' }}">
                <span class="nav-icon">📢</span>
                <span>Pengumuman RT/RW</span>
              </a>

              <a href="/emergency-alerts" class="sidebar-nav-link {{ request()->is('emergency-alerts*') ? 'active' : '' }}">
                <span class="nav-icon">🛡️</span>
                <span>EAS (Laporan & Siaga)</span>
              </a>

              <a href="/businesses" class="sidebar-nav-link {{ request()->is('businesses*') ? 'active' : '' }}">
                <span class="nav-icon">🏪</span>
                <span>UMKM Lokal</span>
              </a>

              @auth
                @if($u->role === 'resident')
                  <div class="pt-2 mt-2 border-top" style="border-color: var(--color-border-subtle);">
                    <a href="/resident/reports/create" class="sidebar-nav-link {{ request()->is('resident/reports/create') ? 'active' : '' }}">
                      <span class="nav-icon">📝</span>
                      <span>Kirim Laporan</span>
                    </a>
                    <a href="/resident/dashboard" class="sidebar-nav-link {{ request()->is('resident/dashboard') ? 'active' : '' }}">
                      <span class="nav-icon">📑</span>
                      <span>Laporan Saya</span>
                    </a>
                  </div>
                @else
                  <div class="pt-2 mt-2 border-top" style="border-color: var(--color-border-subtle);">
                    <a href="/admin/dashboard" class="sidebar-nav-link {{ request()->is('admin*') ? 'active' : '' }}">
                      <span class="nav-icon">⚙️</span>
                      <span>Panel Pengurus</span>
                    </a>
                  </div>
                @endif
              @endauth
            </nav>
          </div>

          <!-- Bottom Mascot Widget (Warga Saling Peduli) -->
          <div class="sidebar-mascot-card d-none d-lg-block">
            <img src="{{ asset('images/cat-peeking.png') }}" alt="Mascot WargaNet" class="sidebar-mascot-img">
            <div class="sidebar-mascot-text">
              Warga Saling Peduli,<br>Lingkungan Lebih Baik! 💙
            </div>
          </div>
        </aside>

        <!-- Main Viewport Canvas -->
        <main class="app-main-content">
          @if(session('ok'))
            <div class="app-alert app-alert-success">
              <span class="fw-bold">✓</span>
              <div>{{ session('ok') }}</div>
            </div>
          @endif

          @if($errors->any())
            <div class="app-alert app-alert-danger">
              <div>
                <div class="fw-bold mb-1">Mohon periksa kembali isian Anda:</div>
                <ul class="mb-0 ps-3">
                  @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                  @endforeach
                </ul>
              </div>
            </div>
          @endif

          @yield('content')
        </main>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <!-- Live Dynamic Clock Script matching Reference Time Display -->
  <script>
    function updateClock() {
      const clockEl = document.getElementById('liveClockTime');
      const dateEl = document.getElementById('liveClockDate');
      if (!clockEl && !dateEl) return;

      const now = new Date();
      const hours = String(now.getHours()).padStart(2, '0');
      const minutes = String(now.getMinutes()).padStart(2, '0');

      if (clockEl) clockEl.textContent = `${hours}:${minutes}`;

      if (dateEl) {
        const days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const dayName = days[now.getDay()];
        const dayNum = now.getDate();
        const monthName = months[now.getMonth()];
        const year = now.getFullYear();
        dateEl.textContent = `📅 ${dayName}, ${dayNum} ${monthName} ${year}`;
      }
    }
    updateClock();
    setInterval(updateClock, 1000);
  </script>
  @stack('js')
</body>
</html>
