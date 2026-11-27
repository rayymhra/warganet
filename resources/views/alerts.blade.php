{{-- Hallmark · macrostructure: Emergency Alert System · theme: WargaNet Pastel Blue · genre: playful --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
@php
  $inc = config('warganet.incident');
@endphp

<!-- EAS Hero Banner (Matching Reference Screen 2: EAS Header) -->
<div class="hero-banner-card mb-4" style="background: linear-gradient(135deg, #ffffff 0%, #dbeafe 100%);">
  <div class="row align-items-center g-3">
    <div class="col-md-8">
      <div class="badge-pill badge-pill-blue mb-2">2. EMERGENCY ALERT SYSTEM (EAS)</div>
      <h1 class="h3 fw-bold mb-1">Sistem Laporan & Peringatan Darurat</h1>
      <p class="hero-banner-desc mb-3">
        Laporkan kejadian di sekitar, bantu lingkungan kita lebih aman dan responsif!
      </p>
      @auth
        @if(auth()->user()->role === 'resident')
          <a href="/resident/reports/create" class="btn-pill btn-pill-danger btn-pill-sm">
            📢 Kirim Laporan Kejadian Sekarang
          </a>
        @endif
      @else
        <a href="/login" class="btn-pill btn-pill-primary btn-pill-sm">
          Masuk untuk Melapor
        </a>
      @endauth
    </div>
    <div class="col-md-4 text-md-end d-none d-md-block">
      <img src="{{ asset('images/eas-badge.png') }}" alt="Mascot EAS" style="max-height: 120px; width: auto; filter: drop-shadow(0 4px 10px rgba(37,99,235,0.15));">
    </div>
  </div>
</div>

<!-- 4-Step Process Pipeline from Reference Screen 2 -->
<div class="app-card mb-4 p-4">
  <div class="row g-3 text-center align-items-center justify-content-between">
    <div class="col-6 col-md-3">
      <div class="d-flex flex-column align-items-center">
        <div class="stat-icon-circle" style="background: var(--color-accent); color: #ffffff; font-weight: 800;">1</div>
        <div class="fw-bold small text-dark">Laporkan Kejadian</div>
        <div class="text-muted" style="font-size: 0.75rem;">Unggah detail & peta</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="d-flex flex-column align-items-center">
        <div class="stat-icon-circle" style="background: var(--color-accent-subtle); color: var(--color-accent); font-weight: 800;">2</div>
        <div class="fw-bold small text-dark">Sistem Analisis AI</div>
        <div class="text-muted" style="font-size: 0.75rem;">Deteksi kategori cepat</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="d-flex flex-column align-items-center">
        <div class="stat-icon-circle" style="background: var(--color-accent-subtle); color: var(--color-accent); font-weight: 800;">3</div>
        <div class="fw-bold small text-dark">Verifikasi Pengurus</div>
        <div class="text-muted" style="font-size: 0.75rem;">Validasi kebenaran data</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="d-flex flex-column align-items-center">
        <div class="stat-icon-circle" style="background: var(--color-verified-bg); color: var(--color-verified-text); font-weight: 800;">4</div>
        <div class="fw-bold small text-dark">Informasi ke Warga</div>
        <div class="text-muted" style="font-size: 0.75rem;">Siaga tanggap bersama</div>
      </div>
    </div>
  </div>
</div>

<!-- Interactive Geolocation Incident Map -->
<div class="app-card mb-4 p-3">
  <div class="app-card-header mb-2">
    <h2 class="app-card-title">Peta Titik Kejadian Aktif</h2>
    <span class="small text-muted font-monospace">Koordinat Terverifikasi</span>
  </div>
  <div id="map"></div>
</div>

<div class="row g-4">
  <!-- Community Verified Alerts (Laporan Warga) -->
  <div class="col-lg-7">
    <div class="app-card">
      <div class="app-card-header">
        <h3 class="app-card-title">Laporan Warga Terverifikasi</h3>
        <span class="badge-pill badge-pill-green">Ditinjau Pengurus</span>
      </div>

      <div class="d-flex flex-column gap-3">
        @forelse($community as $r)
          <div class="p-3 rounded" style="background: #fff5f5; border: 1px solid #fed7d7; border-left: 4px solid var(--color-urgent) !important;">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
              <span class="badge-pill badge-pill-red">{{ $inc[$r->category] ?? 'Kejadian' }}</span>
              <span class="small text-muted font-monospace">{{ ($r->occurred_at ?? $r->created_at)->translatedFormat('d M Y · H:i') }} WIB</span>
            </div>

            <h4 class="h6 fw-bold mb-1 text-dark">{{ $r->title }}</h4>
            <p class="small text-muted mb-2">{{ $r->description }}</p>

            <div class="small font-monospace text-muted pt-2 border-top" style="border-color: #fecaca !important;">
              📍 {{ $r->location }} · Terverifikasi oleh Pengurus RT/RW
            </div>
          </div>
        @empty
          <div class="text-center py-4 text-muted small">
            Situasi kondusif. Tidak ada laporan darurat aktif dari warga.
          </div>
        @endforelse
      </div>
    </div>
  </div>

  <!-- Official Government / Agency Feeds (BMKG) -->
  <div class="col-lg-5">
    <div class="app-card">
      <div class="app-card-header">
        <h3 class="app-card-title">Informasi Resmi Instansi</h3>
        <span class="badge-pill badge-pill-blue">BMKG & Resmi</span>
      </div>

      <div class="d-flex flex-column gap-3">
        @forelse($external as $e)
          <div class="p-3 rounded" style="background: var(--color-surface-subtle); border: 1px solid var(--color-border-card);">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <span class="badge-pill badge-pill-blue">{{ $e->source_name }}</span>
              @if($e->isStale())
                <span class="badge-pill badge-pill-yellow">Data Lama</span>
              @else
                <span class="badge-pill badge-pill-green">Terkini</span>
              @endif
            </div>

            <h4 class="h6 fw-bold mb-1 text-dark">{{ $e->title }}</h4>
            <p class="small text-muted mb-2">{{ $e->description }}</p>

            <div class="d-flex justify-content-between align-items-center small font-monospace text-muted pt-2 border-top" style="border-color: var(--color-border-subtle) !important;">
              <span>{{ $e->published_at?->translatedFormat('d M H:i') }} WIB</span>
              @if($e->source_url)
                <a href="{{ $e->source_url }}" target="_blank" rel="noopener" class="text-decoration-none fw-bold" style="color: var(--color-accent);">Sumber Rujukan ↗</a>
              @endif
            </div>
          </div>
        @empty
          <div class="text-center py-4 text-muted small">
            Informasi resmi instansi belum tersedia untuk wilayah ini.
          </div>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script>
  const m = L.map('map').setView([-6.9, 107.0], 11);
  L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
  }).addTo(m);

  @foreach($community as $r)
    @if($r->latitude && $r->longitude)
      L.marker([{{ $r->latitude }}, {{ $r->longitude }}])
        .addTo(m)
        .bindPopup("<strong>{{ addslashes($r->title) }}</strong><br><small>{{ addslashes($r->location) }}</small>");
    @endif
  @endforeach
</script>
@endpush
