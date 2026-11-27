{{-- Hallmark · macrostructure: Playful Civic Dashboard · theme: WargaNet Pastel Blue · genre: playful --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
@php
  $u = auth()->user();
  $inc = config('warganet.incident');
@endphp

<!-- Top Hero Banner -->
<div class="hero-banner-card mb-4">
  <div class="row align-items-center g-3">
    <!-- Greeting & Subtitle -->
    <div class="col-md-7 col-lg-7">
      <h1 class="hero-banner-title">
        Halo, {{ $u ? $u->name : 'Warga' }}!
      </h1>
      <p class="hero-banner-desc">
        Semoga hari Anda menyenangkan di lingkungan kita bersama.
      </p>
      <div class="mt-3 d-flex align-items-center gap-2 flex-wrap">
        @guest
          <a href="/register" class="btn-pill btn-pill-primary btn-pill-sm">Gabung Jadi Warga</a>
          <a href="/schedules" class="btn-pill btn-pill-outline btn-pill-sm">Lihat Jadwal</a>
        @elseif($u->role === 'resident')
          <a href="/resident/reports/create" class="btn-pill btn-pill-danger btn-pill-sm">
            <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
            <span>Lapor Kejadian</span>
          </a>
          <a href="/schedules" class="btn-pill btn-pill-outline btn-pill-sm">Agenda Lingkungan</a>
        @else
          <a href="/admin/dashboard" class="btn-pill btn-pill-primary btn-pill-sm">Buka Panel Pengurus</a>
        @endguest
      </div>
    </div>

    <!-- Center Mascot & Live Clock Card -->
    <div class="col-md-5 col-lg-5 d-flex align-items-center justify-content-md-end gap-3 flex-wrap">
      <img src="{{ asset('images/cat-waving.png') }}" onerror="this.onerror=null;this.src='{{ asset('images/cat-peeking.png') }}';" alt="Mascot WargaNet" class="hero-mascot-img d-none d-sm-block">

      <!-- Live Clock Card -->
      <div class="live-clock-card">
        <div id="liveClockDate" class="clock-date">Memuat waktu...</div>
        <div id="liveClockTime" class="clock-time">--:--</div>
        <div class="clock-wib">WIB</div>
      </div>
    </div>
  </div>
</div>

<!-- Active Emergency Alert Card (Shown dynamically only if alerts exist in database) -->
@if($alerts->count())
  @php $firstAlert = $alerts->first(); @endphp
  <div class="app-card mb-4 p-3" style="background: linear-gradient(135deg, #fff5f5, #fed7d7); border-color: #fca5a5;">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
      <div class="d-flex align-items-center gap-3">
        <div class="stat-icon-circle m-0" style="background: #fee2e2; color: #dc2626;">
          <svg class="svg-icon" viewBox="0 0 24 24"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        </div>
        <div>
          <div class="fw-bold text-danger" style="font-size: 1rem;">
            Peringatan Darurat: {{ $firstAlert->title }}
          </div>
          <div class="small text-muted font-monospace">
            <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
            {{ $firstAlert->location }} · {{ $firstAlert->created_at->translatedFormat('d M Y · H:i') }} WIB
          </div>
        </div>
      </div>
      <a href="/emergency-alerts" class="btn-pill btn-pill-danger btn-pill-sm">
        Lihat Detail Kejadian →
      </a>
    </div>
  </div>
@endif

<!-- Section: "Ringkasan Hari Ini" (4 Stat Cards - 100% Dynamic DB Data) -->
<div class="mb-4">
  <h2 class="h5 fw-bold mb-3" style="font-family: var(--font-display); color: var(--color-text-main);">
    Ringkasan Hari Ini
  </h2>

  <div class="row g-3">
    <!-- Card 1: Pengumuman Baru -->
    <div class="col-6 col-md-3">
      <div class="stat-pill-card">
        <div class="stat-icon-circle">
          <svg class="svg-icon" viewBox="0 0 24 24"><path d="m3 11 18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg>
        </div>
        <div class="stat-value">{{ $announcements->count() }}</div>
        <div class="stat-label">Pengumuman Baru</div>
      </div>
    </div>

    <!-- Card 2: Kegiatan RT/RW -->
    <div class="col-6 col-md-3">
      <div class="stat-pill-card">
        <div class="stat-icon-circle">
          <svg class="svg-icon" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
        </div>
        <div class="stat-value">{{ $schedules->count() }}</div>
        <div class="stat-label">Kegiatan RT/RW</div>
      </div>
    </div>

    <!-- Card 3: Laporan Siaga -->
    <div class="col-6 col-md-3">
      <div class="stat-pill-card">
        <div class="stat-icon-circle" style="{{ $alerts->count() > 0 ? 'background: #fee2e2; color: #ef4444;' : '' }}">
          <svg class="svg-icon" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        </div>
        <div class="stat-value" style="{{ $alerts->count() > 0 ? 'color: #ef4444;' : '' }}">{{ $alerts->count() }}</div>
        <div class="stat-label">Laporan Siaga</div>
      </div>
    </div>

    <!-- Card 4: UMKM Terdaftar -->
    <div class="col-6 col-md-3">
      <div class="stat-pill-card">
        <div class="stat-icon-circle">
          <svg class="svg-icon" viewBox="0 0 24 24"><path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"/><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"/><path d="M2 7h20"/></svg>
        </div>
        <div class="stat-value">{{ $businesses->count() }}</div>
        <div class="stat-label">UMKM Terdaftar</div>
      </div>
    </div>
  </div>
</div>

<!-- Main Content Grid -->
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
              <div class="stat-icon-circle m-0 flex-shrink-0" style="width: 2.3rem; height: 2.3rem;">
                <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="m3 11 18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg>
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

  <!-- Right Column: Kegiatan Mendatang -->
  <div class="col-lg-5">
    <div class="app-card">
      <div class="app-card-header">
        <h3 class="app-card-title">Kegiatan Mendatang</h3>
        <a href="/schedules" class="app-card-action">
          Lihat Semua <span>→</span>
        </a>
      </div>

      <!-- Featured Upcoming Event Card with Fallback Image -->
      @if($schedules->isNotEmpty())
        @php $featured = $schedules->first(); @endphp
        <div class="rounded overflow-hidden mb-3" style="border: 1px solid var(--color-border-card); background: #ffffff;">
          <img src="{{ !empty($featured->image_path) ? asset('storage/'.$featured->image_path) : asset('images/banner-activities.jpg') }}" 
               onerror="this.onerror=null;this.src='{{ asset('images/banner-activities.jpg') }}';" 
               alt="{{ $featured->title }}" 
               class="w-100 object-fit-cover" 
               style="height: 120px;">
          <div class="p-3">
            <div class="d-flex align-items-center justify-content-between mb-1">
              <h4 class="h6 fw-bold mb-0 text-dark">{{ $featured->title }}</h4>
              <span class="badge-pill badge-pill-green">Terjadwal</span>
            </div>
            <div class="small text-muted mb-2 font-monospace">
              <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
              {{ $featured->date->translatedFormat('D, d M Y') }} · {{ substr($featured->start_time, 0, 5) }} WIB<br>
              <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
              {{ $featured->location }}
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
                  {{ $sec->date->translatedFormat('d M') }} · {{ $sec->location }}
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
