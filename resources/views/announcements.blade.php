{{-- Hallmark · macrostructure: Neighborhood Information Management · theme: WargaNet Pastel Blue · genre: playful --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
<!-- Header Banner with Fallback Image -->
<div class="hero-banner-card mb-4" style="background: linear-gradient(135deg, #ffffff 0%, #dbeafe 100%);">
  <div class="row align-items-center g-3">
    <div class="col-md-8">
      <div class="badge-pill badge-pill-blue mb-2">PENGUMUMAN RT/RW</div>
      <h1 class="h3 fw-bold mb-1">Pemberitahuan & Maklumat Warga</h1>
      <p class="hero-banner-desc mb-0">
        Informasi resmi dari pengurus lingkungan mengenai kegiatan, keamanan, dan administrasi.
      </p>
    </div>
    <div class="col-md-4 text-md-end d-none d-md-block">
      <img src="{{ asset('images/cat-megaphone.png') }}" 
           onerror="this.onerror=null;this.src='{{ asset('images/cat-waving.png') }}';" 
           alt="Mascot Pengumuman" 
           style="max-height: 95px; width: auto;">
    </div>
  </div>
</div>

<!-- Search & Action -->
<div class="app-card p-3 mb-4">
  <form method="get" action="/announcements" class="row g-2 align-items-center">
    <div class="col-md-8">
      <input type="text" name="q" class="form-control-pill" placeholder="Cari isi atau judul pengumuman..." value="{{ request('q') }}">
    </div>
    <div class="col-md-4 d-flex gap-2">
      <button type="submit" class="btn-pill btn-pill-primary w-100">
        <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        <span>Cari</span>
      </button>
      @if(auth()->check() && auth()->user()->role === 'admin')
        <a href="/admin/announcements" class="btn-pill btn-pill-outline text-nowrap">+ Buat Pengumuman</a>
      @endif
    </div>
  </form>
</div>

<!-- Announcement List -->
<div class="app-card">
  <div class="app-card-header">
    <h2 class="app-card-title">Daftar Pengumuman ({{ $items->count() }})</h2>
    <a href="/schedules" class="app-card-action">Buka Jadwal Kegiatan →</a>
  </div>

  <div class="d-flex flex-column gap-3">
    @forelse($items as $a)
      <div class="p-3 rounded {{ $a->is_important ? 'border-start border-4' : '' }}" style="background: var(--color-surface-subtle); border: 1px solid var(--color-border-card); {{ $a->is_important ? 'border-left-color: var(--color-urgent) !important;' : '' }}">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
          <div class="d-flex align-items-center gap-2">
            <span class="badge-pill badge-pill-blue">{{ $a->category }}</span>
            @if($a->is_important)
              <span class="badge-pill badge-pill-red">Penting & Mendesak</span>
            @endif
          </div>
          <span class="small text-muted font-monospace">{{ $a->published_at?->translatedFormat('l, d F Y') ?? 'Arsip' }}</span>
        </div>

        <h3 class="h6 fw-bold mb-2 text-dark">{{ $a->title }}</h3>
        <p class="small text-muted mb-0" style="line-height: 1.6;">{{ $a->content }}</p>
      </div>
    @empty
      <div class="text-center py-5 text-muted">
        Tidak ada pengumuman yang sesuai dengan pencarian Anda.
      </div>
    @endforelse
  </div>
</div>
@endsection
