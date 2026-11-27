{{-- Hallmark · macrostructure: Playful Civic Dashboard · theme: WargaNet Pastel Blue · genre: playful --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
@php
  $u = auth()->user();
  $inc = config('warganet.incident');
@endphp

<!-- Top Hero Banner (Matching Reference Screen 1) -->
<div class="hero-banner-card mb-4">
  <div class="row align-items-center g-3">
    <!-- Greeting & Subtitle -->
    <div class="col-md-7 col-lg-7">
      <h1 class="hero-banner-title">
        Halo, {{ $u ? $u->name : 'Brev' }}! 👋
      </h1>
      <p class="hero-banner-desc">
        Semoga hari kamu menyenangkan di lingkungan kita!
      </p>
      <div class="mt-3 d-flex align-items-center gap-2 flex-wrap">
        @guest
          <a href="/register" class="btn-pill btn-pill-primary btn-pill-sm">Gabung Jadi Warga</a>
          <a href="/schedules" class="btn-pill btn-pill-outline btn-pill-sm">Lihat Jadwal</a>
        @elseif($u->role === 'resident')
          <a href="/resident/reports/create" class="btn-pill btn-pill-danger btn-pill-sm">📢 Lapor Kejadian</a>
          <a href="/schedules" class="btn-pill btn-pill-outline btn-pill-sm">Agenda Lingkungan</a>
        @else
          <a href="/admin/dashboard" class="btn-pill btn-pill-primary btn-pill-sm">Buka Panel Pengurus</a>
        @endguest
      </div>
    </div>

    <!-- Center Mascot & Live Clock Card from Reference -->
    <div class="col-md-5 col-lg-5 d-flex align-items-center justify-content-md-end gap-3 flex-wrap">
      <img src="{{ asset('images/cat-waving.png') }}" alt="Mascot WargaNet" class="hero-mascot-img d-none d-sm-block">

      <!-- Live Clock Card matching Reference -->
      <div class="live-clock-card">
        <div id="liveClockDate" class="clock-date">📅 Memuat...</div>
        <div id="liveClockTime" class="clock-time">--:--</div>
        <div class="clock-wib">WIB</div>
      </div>
    </div>
  </div>
</div>

<!-- Active Emergency Alert Card (Peringatan Darurat from Reference) -->
@if($alerts->count())
  @php $firstAlert = $alerts->first(); @endphp
  <div class="app-card mb-4 p-3" style="background: linear-gradient(135deg, #fff5f5, #fed7d7); border-color: #fca5a5;">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
      <div class="d-flex align-items-center gap-3">
        <div class="stat-icon-circle m-0" style="background: #fee2e2; color: #dc2626;">🚨</div>
        <div>
          <div class="fw-bold text-danger" style="font-size: 1rem;">
            Peringatan Darurat: {{ $firstAlert->title }}
          </div>
          <div class="small text-muted font-monospace">
            📍 {{ $firstAlert->location }} · {{ $firstAlert->created_at->translatedFormat('d M Y · H:i') }} WIB
          </div>
        </div>
      </div>
      <a href="/emergency-alerts" class="btn-pill btn-pill-danger btn-pill-sm">
        Lihat Detail Kejadian →
      </a>
    </div>
  </div>
@endif

<!-- Section: "Ringkasan Hari Ini" (4 Stat Cards from Reference) -->
<div class="mb-4">
  <h2 class="h5 fw-bold mb-3" style="font-family: var(--font-display); color: var(--color-text-main);">
    Ringkasan Hari Ini
  </h2>

  <div class="row g-3">
    <!-- Card 1: Pengumuman Baru -->
    <div class="col-6 col-md-3">
      <div class="stat-pill-card">
        <div class="stat-icon-circle">📢</div>
        <div class="stat-value">{{ $announcements->count() }}</div>
        <div class="stat-label">Pengumuman Baru</div>
      </div>
    </div>

    <!-- Card 2: Kegiatan RT/RW -->
    <div class="col-6 col-md-3">
      <div class="stat-pill-card">
        <div class="stat-icon-circle">📅</div>
        <div class="stat-value">{{ $schedules->count() }}</div>
        <div class="stat-label">Kegiatan RT/RW</div>
      </div>
    </div>

    <!-- Card 3: Laporan Siaga -->
    <div class="col-6 col-md-3">
      <div class="stat-pill-card">
        <div class="stat-icon-circle" style="{{ $alerts->count() > 0 ? 'background: #fee2e2; color: #ef4444;' : '' }}">🛡️</div>
        <div class="stat-value" style="{{ $alerts->count() > 0 ? 'color: #ef4444;' : '' }}">{{ $alerts->count() }}</div>
        <div class="stat-label">Laporan Siaga</div>
      </div>
    </div>

    <!-- Card 4: UMKM Terdaftar -->
    <div class="col-6 col-md-3">
      <div class="stat-pill-card">
        <div class="stat-icon-circle">🏪</div>
        <div class="stat-value">{{ $businesses->count() }}</div>
        <div class="stat-label">UMKM Terdaftar</div>
      </div>
    </div>
  </div>
</div>

<!-- Main Content Grid: Pengumuman Terbaru & Kegiatan Mendatang -->
<div class="row g-4">
  
  <!-- Left Column: Pengumuman Terbaru -->
  <div class="col-lg-7">
    <div class="app-card">
      <div class="app-card-header">
        <h3 class="app-card-title">Pengumuman Terbaru</h3>
        <a href="/announcements" class="app-card-action">
          Lihat Semua <span>→</span>
        </a>
      </div>

      <div class="d-flex flex-column gap-2">
        @forelse($announcements->take(4) as $a)
          <div class="p-3 rounded d-flex align-items-center justify-content-between gap-3" style="background: var(--color-surface-subtle); border: 1px solid var(--color-border-subtle);">
            <div class="d-flex align-items-center gap-3 min-w-0">
              <div class="stat-icon-circle m-0 flex-shrink-0" style="width: 2.3rem; height: 2.3rem; font-size: 1rem;">
                📢
              </div>
              <div class="min-w-0">
                <div class="fw-bold text-dark text-truncate" style="font-size: 0.925rem;">
                  {{ $a->title }}
                </div>
                <div class="small text-muted font-monospace">
                  {{ $a->category }} · {{ $a->published_at?->translatedFormat('d M Y') ?? 'Baru saja' }}
                </div>
              </div>
            </div>

            <div class="flex-shrink-0">
              @if($a->is_important)
                <span class="badge-pill badge-pill-red">Penting</span>
              @else
                <span class="badge-pill badge-pill-blue">Baru</span>
              @endif
            </div>
          </div>
        @empty
          <div class="text-center py-4 text-muted small">
            Belum ada pengumuman terbaru saat ini.
          </div>
        @endforelse
      </div>
    </div>
  </div>

  <!-- Right Column: Kegiatan Mendatang (Illustrated Card with Mascot Banner) -->
  <div class="col-lg-5">
    <div class="app-card">
      <div class="app-card-header">
        <h3 class="app-card-title">Kegiatan Mendatang</h3>
        <a href="/schedules" class="app-card-action">
          Lihat Semua <span>→</span>
        </a>
      </div>

      <!-- Featured Upcoming Event Card matching Reference -->
      @if($schedules->isNotEmpty())
        @php $featured = $schedules->first(); @endphp
        <div class="rounded overflow-hidden mb-3" style="border: 1px solid var(--color-border-card); background: #ffffff;">
          <img src="{{ asset('images/banner-activities.jpg') }}" alt="Kegiatan Lingkungan" class="w-100 object-fit-cover" style="height: 120px;">
          <div class="p-3">
            <div class="d-flex align-items-center justify-content-between mb-1">
              <h4 class="h6 fw-bold mb-0 text-dark">{{ $featured->title }}</h4>
              <span class="badge-pill badge-pill-green">Terjadwal</span>
            </div>
            <div class="small text-muted mb-2 font-monospace">
              🗓 {{ $featured->date->translatedFormat('D, d M Y') }} · {{ substr($featured->start_time, 0, 5) }} WIB<br>
              📍 {{ $featured->location }}
            </div>
            <a href="/schedules" class="btn-pill btn-pill-outline btn-pill-sm w-100">
              Lihat Detail Kegiatan
            </a>
          </div>
        </div>
      @else
        <div class="text-center py-4 text-muted small">
          Belum ada jadwal kegiatan mendatang.
        </div>
      @endif

      <!-- Secondary Schedules List -->
      @if($schedules->count() > 1)
        <div class="d-flex flex-column gap-2 mt-2">
          @foreach($schedules->slice(1, 2) as $sec)
            <div class="p-2 px-3 rounded d-flex justify-content-between align-items-center" style="background: var(--color-surface-subtle); border: 1px solid var(--color-border-subtle);">
              <div class="min-w-0">
                <div class="fw-semibold text-truncate small">{{ $sec->title }}</div>
                <div class="small text-muted font-monospace" style="font-size: 0.75rem;">
                  {{ $sec->date->translatedFormat('d M') }} · 📍 {{ $sec->location }}
                </div>
              </div>
              <span class="badge-pill badge-pill-blue" style="font-size: 0.7rem;">{{ $sec->category }}</span>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </div>

</div>
@endsection
