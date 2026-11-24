{{-- Hallmark · macrostructure: Civic Bulletin & Operational Gazette · theme: Nusantara Civic · genre: editorial --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WargaNet — Portal Pelayanan & Informasi Warga</title>

  <!-- Typography: Plus Jakarta Sans (Civic Display), Inter (Editorial Body), JetBrains Mono (Data/Code) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500;600&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

  <style>
    /* Hallmark Locked Token System — Nusantara Civic Palette */
    :root {
      --font-display: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
      --font-body: 'Inter', system-ui, -apple-system, sans-serif;
      --font-mono: 'JetBrains Mono', ui-monospace, monospace;

      /* Surfaces */
      --color-canvas: oklch(0.985 0.005 85);
      --color-surface: oklch(1 0 0);
      --color-surface-subtle: oklch(0.965 0.006 85);
      --color-surface-muted: oklch(0.935 0.008 85);
      --color-surface-inset: oklch(0.91 0.01 85);

      /* Borders */
      --color-border-subtle: oklch(0.89 0.012 85);
      --color-border-strong: oklch(0.72 0.02 85);
      --color-border-focus: oklch(0.42 0.12 185);

      /* Typography */
      --color-text-main: oklch(0.20 0.02 260);
      --color-text-muted: oklch(0.45 0.02 260);
      --color-text-faint: oklch(0.62 0.015 260);
      --color-text-inverse: oklch(0.99 0.002 85);

      /* Civic Brand & Verdigris Accent */
      --color-accent: oklch(0.42 0.11 185);
      --color-accent-hover: oklch(0.36 0.12 185);
      --color-accent-subtle: oklch(0.94 0.028 185);
      --color-accent-border: oklch(0.75 0.06 185);
      --color-accent-text: oklch(0.30 0.11 185);

      /* Urgency & Incident Signals */
      --color-urgent: oklch(0.55 0.21 28);
      --color-urgent-bg: oklch(0.965 0.035 28);
      --color-urgent-border: oklch(0.84 0.08 28);
      --color-urgent-text: oklch(0.38 0.18 28);

      --color-verified: oklch(0.48 0.14 150);
      --color-verified-bg: oklch(0.96 0.03 150);
      --color-verified-border: oklch(0.82 0.07 150);
      --color-verified-text: oklch(0.32 0.12 150);

      --color-caution: oklch(0.68 0.15 78);
      --color-caution-bg: oklch(0.965 0.04 78);
      --color-caution-border: oklch(0.86 0.08 78);
      --color-caution-text: oklch(0.42 0.14 78);

      /* Shadows & Radii */
      --radius-sm: 0.375rem;
      --radius-md: 0.5rem;
      --radius-lg: 0.75rem;
      --radius-full: 9999px;

      --shadow-tactile: 0 1px 2px oklch(0.2 0.02 260 / 0.04), 0 2px 6px oklch(0.2 0.02 260 / 0.03);
      --shadow-lift: 0 4px 12px oklch(0.2 0.02 260 / 0.06), 0 1px 3px oklch(0.2 0.02 260 / 0.04);
    }

    /* Strict Mobile Responsiveness Hard Floor */
    html, body {
      overflow-x: clip !important;
      background-color: var(--color-canvas);
      color: var(--color-text-main);
      font-family: var(--font-body);
      font-size: 15px;
      line-height: 1.6;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    h1, h2, h3, h4, h5, h6 {
      font-family: var(--font-display);
      color: var(--color-text-main);
      font-weight: 700;
      letter-spacing: -0.02em;
      overflow-wrap: anywhere;
      min-width: 0;
    }

    /* Civic Masthead & Navigation */
    .civic-topbar {
      background: var(--color-surface);
      border-bottom: 1px solid var(--color-border-subtle);
      font-size: 0.8125rem;
      color: var(--color-text-muted);
    }

    .civic-topbar-inner {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 1rem;
      padding: 0.4rem 0;
    }

    .civic-emergency-pill {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      padding: 0.15rem 0.55rem;
      background: var(--color-urgent-bg);
      color: var(--color-urgent-text);
      border: 1px solid var(--color-urgent-border);
      border-radius: var(--radius-full);
      font-size: 0.75rem;
      font-weight: 600;
      text-decoration: none;
      white-space: nowrap;
    }

    .civic-navbar {
      background: var(--color-surface);
      border-bottom: 1px solid var(--color-border-subtle);
      padding: 0.65rem 0;
      box-shadow: var(--shadow-tactile);
    }

    .civic-brand {
      display: inline-flex;
      align-items: center;
      gap: 0.6rem;
      font-family: var(--font-display);
      font-weight: 800;
      font-size: 1.15rem;
      color: var(--color-text-main);
      text-decoration: none;
      letter-spacing: -0.025em;
    }

    .civic-brand-mark {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 1.9rem;
      height: 1.9rem;
      background: var(--color-accent);
      color: var(--color-text-inverse);
      border-radius: var(--radius-sm);
      font-size: 0.95rem;
      font-weight: 800;
    }

    .civic-nav-link {
      color: var(--color-text-muted);
      font-weight: 500;
      font-size: 0.9rem;
      padding: 0.45rem 0.75rem;
      border-radius: var(--radius-sm);
      text-decoration: none;
      transition: color 0.15s ease, background-color 0.15s ease;
      white-space: nowrap;
    }

    .civic-nav-link:hover {
      color: var(--color-text-main);
      background-color: var(--color-surface-subtle);
    }

    .civic-nav-link.active {
      color: var(--color-accent);
      background-color: var(--color-accent-subtle);
      font-weight: 600;
    }

    /* Sub-nav for Admin & Management */
    .civic-subnav {
      background: var(--color-surface-subtle);
      border-bottom: 1px solid var(--color-border-subtle);
      padding: 0.4rem 0;
    }

    .civic-subnav-pills {
      display: flex;
      gap: 0.4rem;
      overflow-x: auto;
      padding-bottom: 2px;
      scrollbar-width: thin;
    }

    .civic-subnav-item {
      font-size: 0.825rem;
      font-weight: 500;
      padding: 0.35rem 0.75rem;
      border-radius: var(--radius-sm);
      color: var(--color-text-muted);
      background: var(--color-surface);
      border: 1px solid var(--color-border-subtle);
      text-decoration: none;
      white-space: nowrap;
      transition: all 0.15s ease;
    }

    .civic-subnav-item.active {
      background: var(--color-accent);
      color: var(--color-text-inverse);
      border-color: var(--color-accent);
      font-weight: 600;
    }

    /* Core Tactical Components */
    .civic-card {
      background: var(--color-surface);
      border: 1px solid var(--color-border-subtle);
      border-radius: var(--radius-md);
      box-shadow: var(--shadow-tactile);
      transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .civic-card:hover {
      border-color: var(--color-border-strong);
    }

    .civic-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.25rem;
      font-size: 0.75rem;
      font-family: var(--font-mono);
      font-weight: 500;
      padding: 0.2rem 0.55rem;
      border-radius: var(--radius-sm);
      line-height: 1.3;
      white-space: nowrap;
    }

    .civic-badge-verified {
      background: var(--color-verified-bg);
      color: var(--color-verified-text);
      border: 1px solid var(--color-verified-border);
    }

    .civic-badge-urgent {
      background: var(--color-urgent-bg);
      color: var(--color-urgent-text);
      border: 1px solid var(--color-urgent-border);
    }

    .civic-badge-caution {
      background: var(--color-caution-bg);
      color: var(--color-caution-text);
      border: 1px solid var(--color-caution-border);
    }

    .civic-badge-neutral {
      background: var(--color-surface-subtle);
      color: var(--color-text-muted);
      border: 1px solid var(--color-border-subtle);
    }

    .civic-badge-accent {
      background: var(--color-accent-subtle);
      color: var(--color-accent-text);
      border: 1px solid var(--color-accent-border);
    }

    /* Buttons with Hard-Floor Clickable Target Safety */
    .btn-civic {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.45rem;
      font-family: var(--font-body);
      font-weight: 600;
      font-size: 0.875rem;
      padding: 0.525rem 1rem;
      border-radius: var(--radius-sm);
      border: 1px solid transparent;
      text-decoration: none;
      white-space: nowrap;
      min-height: 2.375rem;
      cursor: pointer;
      transition: background-color 0.15s ease, border-color 0.15s ease, transform 0.05s ease;
    }

    .btn-civic:active {
      transform: translateY(1px);
    }

    .btn-civic-primary {
      background: var(--color-accent);
      color: var(--color-text-inverse);
      border-color: var(--color-accent);
    }

    .btn-civic-primary:hover {
      background: var(--color-accent-hover);
      color: var(--color-text-inverse);
    }

    .btn-civic-outline {
      background: var(--color-surface);
      color: var(--color-text-main);
      border-color: var(--color-border-strong);
    }

    .btn-civic-outline:hover {
      background: var(--color-surface-subtle);
      color: var(--color-text-main);
      border-color: var(--color-text-main);
    }

    .btn-civic-urgent {
      background: var(--color-urgent);
      color: var(--color-text-inverse);
      border-color: var(--color-urgent);
    }

    .btn-civic-urgent:hover {
      background: oklch(0.48 0.22 28);
      color: var(--color-text-inverse);
    }

    .btn-civic-subtle {
      background: var(--color-surface-subtle);
      color: var(--color-text-main);
      border-color: var(--color-border-subtle);
    }

    .btn-civic-subtle:hover {
      background: var(--color-surface-muted);
      color: var(--color-text-main);
    }

    .btn-civic-sm {
      padding: 0.35rem 0.7rem;
      font-size: 0.8125rem;
      min-height: 1.95rem;
    }

    /* Forms */
    .civic-input, .civic-select, .civic-textarea {
      width: 100%;
      background: var(--color-surface);
      border: 1px solid var(--color-border-subtle);
      border-radius: var(--radius-sm);
      padding: 0.55rem 0.8rem;
      font-size: 0.9rem;
      color: var(--color-text-main);
      font-family: var(--font-body);
      transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .civic-input:focus, .civic-select:focus, .civic-textarea:focus {
      outline: none;
      border-color: var(--color-border-focus);
      box-shadow: 0 0 0 3px oklch(0.42 0.11 185 / 0.15);
    }

    .civic-label {
      display: block;
      font-family: var(--font-display);
      font-weight: 600;
      font-size: 0.84rem;
      margin-bottom: 0.35rem;
      color: var(--color-text-main);
    }

    .civic-helper {
      font-size: 0.8rem;
      color: var(--color-text-muted);
      margin-top: 0.25rem;
    }

    /* Gate 66 Compliance: No hanging headers. Tag above heading in same column */
    .civic-section-header {
      margin-bottom: 1.25rem;
      display: block;
    }

    .civic-eyebrow {
      display: inline-block;
      font-family: var(--font-mono);
      font-size: 0.725rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: var(--color-accent-text);
      margin-bottom: 0.3rem;
    }

    /* Image grid track safety */
    .civic-image-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(0, 1fr));
      gap: 1rem;
    }

    /* Alerts */
    .civic-alert {
      padding: 0.85rem 1.1rem;
      border-radius: var(--radius-md);
      font-size: 0.875rem;
      margin-bottom: 1.25rem;
      display: flex;
      align-items: flex-start;
      gap: 0.75rem;
    }

    .civic-alert-success {
      background: var(--color-verified-bg);
      border: 1px solid var(--color-verified-border);
      color: var(--color-verified-text);
    }

    .civic-alert-urgent {
      background: var(--color-urgent-bg);
      border: 1px solid var(--color-urgent-border);
      color: var(--color-urgent-text);
    }

    .civic-alert-caution {
      background: var(--color-caution-bg);
      border: 1px solid var(--color-caution-border);
      color: var(--color-caution-text);
    }

    /* Civic Tables */
    .civic-table-wrapper {
      background: var(--color-surface);
      border: 1px solid var(--color-border-subtle);
      border-radius: var(--radius-md);
      overflow-x: auto;
      box-shadow: var(--shadow-tactile);
    }

    .civic-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.875rem;
      text-align: left;
    }

    .civic-table th {
      background: var(--color-surface-subtle);
      color: var(--color-text-muted);
      font-family: var(--font-display);
      font-weight: 600;
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      padding: 0.75rem 1rem;
      border-bottom: 1px solid var(--color-border-subtle);
      white-space: nowrap;
    }

    .civic-table td {
      padding: 0.85rem 1rem;
      border-bottom: 1px solid var(--color-border-subtle);
      color: var(--color-text-main);
      vertical-align: middle;
    }

    .civic-table tr:last-child td {
      border-bottom: none;
    }

    .civic-table tr:hover td {
      background: var(--color-surface-subtle);
    }

    /* Footer */
    .civic-footer {
      margin-top: 4rem;
      background: var(--color-surface);
      border-top: 1px solid var(--color-border-subtle);
      padding: 2.5rem 0 2rem;
      color: var(--color-text-muted);
      font-size: 0.825rem;
    }

    /* Leaflet Overrides */
    #map {
      height: 360px;
      border-radius: var(--radius-md);
      border: 1px solid var(--color-border-subtle);
      z-index: 1;
    }
  </style>
</head>
<body>
  @php $u = auth()->user(); @endphp

  <!-- Civic Masthead Bar -->
  <header class="civic-topbar">
    <div class="container civic-topbar-inner">
      <div class="d-flex align-items-center gap-2">
        <span class="civic-badge civic-badge-neutral">PORTAL WARGA</span>
        <span class="d-none d-sm-inline">Layanan Terpadu Rukun Tetangga & Rukun Warga</span>
      </div>
      <div class="d-flex align-items-center gap-3">
        <a href="tel:112" class="civic-emergency-pill" title="Panggilan Darurat Bebas Pulsa">
          <span>🚨 Darurat: 112</span>
        </a>
      </div>
    </div>
  </header>

  <!-- Primary Navigation -->
  <nav class="civic-navbar">
    <div class="container d-flex align-items-center justify-content-between flex-wrap gap-2">
      <a class="civic-brand" href="/">
        <span class="civic-brand-mark">W</span>
        <span>WargaNet</span>
      </a>

      <!-- Primary Links -->
      <div class="d-flex align-items-center gap-1 flex-wrap">
        <a class="civic-nav-link {{ request()->is('schedules*') ? 'active' : '' }}" href="/schedules">Jadwal Kegiatan</a>
        <a class="civic-nav-link {{ request()->is('announcements*') ? 'active' : '' }}" href="/announcements">Pengumuman</a>
        <a class="civic-nav-link {{ request()->is('emergency-alerts*') ? 'active' : '' }}" href="/emergency-alerts">Info Darurat</a>
        <a class="civic-nav-link {{ request()->is('businesses*') ? 'active' : '' }}" href="/businesses">Direktori Usaha</a>
      </div>

      <!-- Action & Auth Area -->
      <div class="d-flex align-items-center gap-2 flex-wrap">
        @guest
          <a class="btn-civic btn-civic-outline btn-civic-sm" href="/login">Masuk</a>
          <a class="btn-civic btn-civic-primary btn-civic-sm" href="/register">Daftar Warga</a>
        @else
          @if($u->role === 'resident')
            <a class="btn-civic btn-civic-urgent btn-civic-sm" href="/resident/reports/create">📢 Buat Laporan</a>
            <a class="btn-civic btn-civic-outline btn-civic-sm" href="/resident/dashboard">Laporan Saya</a>
          @else
            <a class="btn-civic btn-civic-primary btn-civic-sm" href="/admin/dashboard">Panel Pengurus</a>
          @endif
          <form method="post" action="/logout" class="d-inline m-0">
            @csrf
            <button type="submit" class="btn-civic btn-civic-subtle btn-civic-sm">Keluar</button>
          </form>
        @endguest
      </div>
    </div>
  </nav>

  <!-- Sub-Nav for Admin Control Room -->
  @if($u && $u->role === 'admin' && request()->is('admin/*'))
    <div class="civic-subnav">
      <div class="container civic-subnav-pills">
        @foreach([
          'dashboard' => 'Ringkasan',
          'reports' => 'Verifikasi Laporan',
          'schedules' => 'Kelola Jadwal',
          'announcements' => 'Kelola Pengumuman',
          'businesses' => 'Kelola Usaha',
          'external-alerts' => 'Feed Instansi Resmi'
        ] as $p => $l)
          <a href="/admin/{{ $p }}" class="civic-subnav-item {{ request()->is("admin/$p*") ? 'active' : '' }}">
            {{ $l }}
          </a>
        @endforeach
      </div>
    </div>
  @endif

  <!-- Main Content Container -->
  <main class="container py-4">
    @if(session('ok'))
      <div class="civic-alert civic-alert-success">
        <span class="fw-bold">✓</span>
        <div>{{ session('ok') }}</div>
      </div>
    @endif

    @if($errors->any())
      <div class="civic-alert civic-alert-urgent">
        <div class="w-100">
          <div class="fw-bold mb-1">Periksa kembali data yang diisi:</div>
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

  <!-- Grounded Civic Footer -->
  <footer class="civic-footer">
    <div class="container">
      <div class="row g-4 align-items-center">
        <div class="col-md-7">
          <div class="civic-brand mb-1">
            <span class="civic-brand-mark">W</span>
            <span>WargaNet</span>
          </div>
          <p class="mb-0 text-muted small">
            Sistem informasi dan respons cepat lingkungan warga. Setiap laporan warga melalui proses verifikasi pengurus sebelum dipublikasikan demi ketertiban bersama.
          </p>
        </div>
        <div class="col-md-5 text-md-end">
          <div class="small fw-semibold text-dark mb-1">Pusat Layanan Kedaruratan</div>
          <div class="small text-muted mb-2">Layanan Darurat Nasional: <strong>112</strong> · Pos Kamling / RT Terdekat</div>
          <div class="small text-muted font-monospace">WargaNet v2.4 · Lingkungan Rukun Warga</div>
        </div>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  @stack('js')
</body>
</html>
