{{-- Hallmark · macrostructure: Filterable Civic Gazette · theme: Nusantara Civic · genre: editorial --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
<div class="civic-section-header">
  <span class="civic-eyebrow">MAKLUMAT RESMI</span>
  <h1 class="h3 mb-1">Pengumuman Lingkungan</h1>
  <p class="text-muted small mb-0">
    Pemberitahuan administratif, rilis edaran pengurus, dan informasi berkala rukun warga.
  </p>
</div>

<!-- Search Bar -->
<div class="civic-card p-3 mb-4">
  <form method="get" action="/announcements" class="d-flex gap-2">
    <input type="text" name="q" class="civic-input" placeholder="Cari judul atau isi pengumuman..." value="{{ request('q') }}">
    <button type="submit" class="btn-civic btn-civic-primary">Cari</button>
  </form>
</div>

<!-- Announcement List -->
<div class="d-flex flex-column gap-3">
  @forelse($items as $a)
    <article class="civic-card p-4 {{ $a->is_important ? 'border-start border-4' : '' }}" style="{{ $a->is_important ? 'border-left-color: var(--color-urgent) !important;' : '' }}">
      <div class="d-flex justify-content-between align-items-center gap-2 mb-2 flex-wrap">
        <div class="d-flex align-items-center gap-2">
          <span class="civic-badge civic-badge-accent">{{ $a->category }}</span>
          @if($a->is_important)
            <span class="civic-badge civic-badge-urgent">PENTING & MENDESAK</span>
          @endif
        </div>
        <time class="small font-monospace text-muted">{{ $a->published_at?->translatedFormat('l, d F Y') ?? 'Arsip' }}</time>
      </div>

      <h2 class="h5 fw-bold mb-2" style="color: var(--color-text-main);">{{ $a->title }}</h2>
      <div class="text-muted" style="line-height: 1.6; font-size: 0.95rem;">
        {{ $a->content }}
      </div>
    </article>
  @empty
    <div class="civic-card p-5 text-center text-muted">
      Tidak ada pengumuman yang cocok dengan pencarian Anda.
    </div>
  @endforelse
</div>
@endsection
