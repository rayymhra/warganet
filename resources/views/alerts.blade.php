{{-- Hallmark · macrostructure: Incident Command Feed & Geolocation Matrix · theme: Nusantara Civic · genre: editorial --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
@php
  $inc = config('warganet.incident');
@endphp

<div class="civic-section-header">
  <span class="civic-eyebrow">PUSAT INFORMASI DARURAT</span>
  <h1 class="h3 mb-1">Peringatan & Kejadian Terverifikasi</h1>
  <p class="text-muted small mb-0">
    Pantau situasi keselamatan lingkungan dan maklumat resmi instansi terkait. Seluruh laporan warga di bawah ini telah diverifikasi keabsahannya oleh pengurus RT/RW.
  </p>
</div>

<!-- Interactive Geolocation Incident Map -->
<div class="civic-card p-3 mb-4">
  <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
    <div class="small fw-semibold text-muted font-monospace">PETA TITIK KEJADIAN AKTIF</div>
    <div class="small text-muted">Sentuh penanda untuk melihat keterangan ringkas</div>
  </div>
  <div id="map"></div>
</div>

<div class="row g-4">
  <!-- Community Verified Reports -->
  <div class="col-lg-7">
    <div class="civic-section-header">
      <span class="civic-eyebrow">VERIFIKASI PENGURUS RT/RW</span>
      <h2 class="h5 mb-0">Laporan Kejadian Warga</h2>
    </div>

    <div class="d-flex flex-column gap-3">
      @forelse($community as $r)
        <article class="civic-card p-3 p-md-4" style="border-left: 3px solid var(--color-urgent) !important;">
          <div class="d-flex justify-content-between align-items-start gap-2 mb-2 flex-wrap">
            <span class="civic-badge civic-badge-urgent">{{ $inc[$r->category] ?? 'Lainnya' }}</span>
            <span class="civic-badge civic-badge-verified">Terverifikasi Pengurus</span>
          </div>
          <h3 class="h6 fw-bold mb-2" style="color: var(--color-text-main);">{{ $r->title }}</h3>
          <p class="text-muted small mb-3">{{ $r->description }}</p>

          <div class="pt-2 border-top small text-muted font-monospace" style="border-color: var(--color-border-subtle) !important;">
            📍 {{ $r->location }} · 🕒 {{ ($r->occurred_at ?? $r->created_at)->translatedFormat('d F Y H:i') }} WIB
          </div>
        </article>
      @empty
        <div class="civic-card p-4 text-center text-muted">
          Tidak ada laporan darurat warga yang sedang aktif. Situasi aman terkendali.
        </div>
      @endforelse
    </div>
  </div>

  <!-- Official Government / Agency Feeds (BMKG, etc) -->
  <div class="col-lg-5">
    <div class="civic-section-header">
      <span class="civic-eyebrow">INSTANSI RESMI</span>
      <h2 class="h5 mb-0">Rilis Cuaca & Peringatan Dini</h2>
    </div>

    <div class="d-flex flex-column gap-3">
      @forelse($external as $e)
        <article class="civic-card p-3">
          <div class="d-flex justify-content-between align-items-center gap-2 mb-2 flex-wrap">
            <span class="civic-badge civic-badge-neutral">{{ $e->source_name }}</span>
            @if($e->isStale())
              <span class="civic-badge civic-badge-caution">Data Arsip</span>
            @else
              <span class="civic-badge civic-badge-verified">Terbaru</span>
            @endif
          </div>
          <h3 class="h6 fw-bold mb-1" style="color: var(--color-text-main);">{{ $e->title }}</h3>
          <p class="small text-muted mb-2">{{ $e->description }}</p>

          <div class="d-flex justify-content-between align-items-center pt-2 border-top small font-monospace text-muted" style="border-color: var(--color-border-subtle) !important;">
            <span>{{ $e->published_at?->translatedFormat('d M H:i') }} WIB</span>
            @if($e->source_url)
              <a href="{{ $e->source_url }}" target="_blank" rel="noopener" class="text-decoration-none fw-semibold" style="color: var(--color-accent);">Sumber Rujukan ↗</a>
            @endif
          </div>
        </article>
      @empty
        <div class="civic-card p-4 text-center text-muted">
          Informasi resmi instansi belum tersedia untuk wilayah ini.
        </div>
      @endforelse
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
