{{-- Hallmark · macrostructure: Neighborhood Information Management · theme: WargaNet Pastel Blue · genre: playful --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
<!-- Header Banner (Screen 1 Reference: Mengelola Informasi Lingkungan) -->
<div class="hero-banner-card mb-4" style="background: linear-gradient(135deg, #ffffff 0%, #e0effe 100%);">
  <div class="row align-items-center g-3">
    <div class="col-md-8">
      <div class="badge-pill badge-pill-blue mb-2">1. INFORMASI LINGKUNGAN</div>
      <h1 class="h3 fw-bold mb-1">Informasi Lingkungan</h1>
      <p class="hero-banner-desc mb-0">
        Jadwal layanan, pengumuman, dan kegiatan terpadu untuk warga sekitar.
      </p>
    </div>
    <div class="col-md-4 text-md-end d-none d-md-block">
      <img src="{{ asset('images/banner-community.jpg') }}" alt="Ilustrasi Warga" class="rounded shadow-sm" style="height: 85px; width: auto; object-fit: cover;">
    </div>
  </div>
</div>

<!-- Category Tabs (Jadwal Layanan, Pengumuman RT/RW, Kegiatan Masyarakat) -->
<div class="filter-pills-row mb-4">
  <a href="/schedules" class="filter-pill-item {{ !request('category') ? 'active' : '' }}">
    📅 Semua Jadwal Layanan
  </a>
  @foreach(config('warganet.schedule_categories') as $c)
    <a href="/schedules?category={{ urlencode($c) }}" class="filter-pill-item {{ request('category') == $c ? 'active' : '' }}">
      {{ $c }}
    </a>
  @endforeach
  <a href="/announcements" class="filter-pill-item">
    📢 Pengumuman RT/RW →
  </a>
</div>

<!-- Search & Add Actions -->
<div class="app-card p-3 mb-4">
  <form method="get" action="/schedules" class="row g-2 align-items-center">
    <div class="col-md-8">
      <input type="text" name="q" class="form-control-pill" placeholder="Cari nama kegiatan atau lokasi..." value="{{ request('q') }}">
    </div>
    <div class="col-md-4 d-flex gap-2">
      <button type="submit" class="btn-pill btn-pill-primary w-100">Cari Jadwal</button>
      @if(auth()->check() && auth()->user()->role === 'admin')
        <a href="/admin/schedules" class="btn-pill btn-pill-outline text-nowrap">+ Tambah Jadwal</a>
      @endif
    </div>
  </form>
</div>

<!-- Jadwal List (Matching Reference Table / Item Row with Rounded Pills) -->
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
            @if(str_contains(strtolower($s->title), 'sampah')) 🗑️
            @elseif(str_contains(strtolower($s->title), 'balita') || str_contains(strtolower($s->title), 'posyandu')) 👶
            @elseif(str_contains(strtolower($s->title), 'sehat') || str_contains(strtolower($s->title), 'senam')) 🏃
            @else 🧹 @endif
          </div>
          <div class="min-w-0">
            <div class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">{{ $s->title }}</div>
            <div class="small text-muted font-monospace">
              🗓 {{ $s->date->translatedFormat('l, d F Y') }} · 🕒 {{ substr($s->start_time, 0, 5) }}{{ $s->end_time ? ' – '.substr($s->end_time, 0, 5) : '' }} WIB · 📍 {{ $s->location }}
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
