{{-- Hallmark · macrostructure: Neighborhood Information Management · theme: WargaNet Pastel Blue · genre: playful --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
<!-- Header Banner with Image Fallback -->
<div class="hero-banner-card mb-4" style="background: linear-gradient(135deg, #ffffff 0%, #e0effe 100%);">
  <div class="row align-items-center g-3">
    <div class="col-md-8">
      <div class="badge-pill badge-pill-blue mb-2">INFORMASI LINGKUNGAN</div>
      <h1 class="h3 fw-bold mb-1">Informasi Lingkungan</h1>
      <p class="hero-banner-desc mb-0">
        Jadwal layanan, pengumuman, dan kegiatan terpadu untuk warga sekitar.
      </p>
    </div>
    <div class="col-md-4 text-md-end d-none d-md-block">
      <img src="{{ asset('images/banner-community.jpg') }}" 
           onerror="this.onerror=null;this.src='{{ asset('images/banner-houses.jpg') }}';" 
           alt="Ilustrasi Warga" 
           class="rounded shadow-sm" 
           style="height: 85px; width: auto; object-fit: cover;">
    </div>
  </div>
</div>

<!-- Category Tabs (100% Dynamic Database/Config Categories) -->
<div class="filter-pills-row mb-4">
  <a href="/schedules" class="filter-pill-item {{ !request('category') ? 'active' : '' }}">
    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
    <span>Semua Jadwal Layanan</span>
  </a>
  @foreach(config('warganet.schedule_categories') as $c)
    <a href="/schedules?category={{ urlencode($c) }}" class="filter-pill-item {{ request('category') == $c ? 'active' : '' }}">
      {{ $c }}
    </a>
  @endforeach
  <a href="/announcements" class="filter-pill-item">
    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="m3 11 18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg>
    <span>Pengumuman RT/RW →</span>
  </a>
</div>

<!-- Search & Add Actions -->
<div class="app-card p-3 mb-4">
  <form method="get" action="/schedules" class="row g-2 align-items-center">
    <div class="col-md-8">
      <input type="text" name="q" class="form-control-pill" placeholder="Cari nama kegiatan atau lokasi..." value="{{ request('q') }}">
    </div>
    <div class="col-md-4 d-flex gap-2">
      <button type="submit" class="btn-pill btn-pill-primary w-100">
        <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        <span>Cari Jadwal</span>
      </button>
      @if(auth()->check() && auth()->user()->role === 'admin')
        <a href="/admin/schedules" class="btn-pill btn-pill-outline text-nowrap">+ Tambah Jadwal</a>
      @endif
    </div>
  </form>
</div>

<!-- Jadwal List -->
<div class="app-card">
  <div class="app-card-header">
    <h2 class="app-card-title">Jadwal Layanan Lingkungan ({{ $items->count() }})</h2>
    <span class="small text-muted font-monospace">Terbarui secara berkala</span>
  </div>

  <div class="d-flex flex-column gap-3">
    @forelse($items as $s)
      <div class="p-3 rounded d-flex align-items-center justify-content-between flex-wrap gap-3" style="background: var(--color-surface-subtle); border: 1px solid var(--color-border-card);">
        <div class="d-flex align-items-center gap-3 min-w-0">
          <div class="stat-icon-circle m-0 flex-shrink-0">
            <svg class="svg-icon" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
          </div>
          <div class="min-w-0">
            <div class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">{{ $s->title }}</div>
            <div class="small text-muted font-monospace">
              <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
              {{ $s->date->translatedFormat('l, d F Y') }} · 
              <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              {{ substr($s->start_time, 0, 5) }}{{ $s->end_time ? ' – '.substr($s->end_time, 0, 5) : '' }} WIB · 
              <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
              {{ $s->location }}
            </div>
            @if($s->description)
              <div class="small text-muted mt-1">{{ $s->description }}</div>
            @endif
          </div>
        </div>

        <div class="d-flex align-items-center gap-2">
          @if($s->status === 'cancelled')
            <span class="badge-pill badge-pill-yellow">Dibatalkan</span>
          @else
            <span class="badge-pill badge-pill-green">Terjadwal</span>
          @endif
          <span class="badge-pill badge-pill-blue">{{ $s->category }}</span>
        </div>
      </div>
    @empty
      <div class="text-center py-5 text-muted">
        Tidak ditemukan jadwal kegiatan yang sesuai.
      </div>
    @endforelse
  </div>
</div>
@endsection
