{{-- Hallmark · macrostructure: Chronological Civic Agenda · theme: Nusantara Civic · genre: editorial --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
<div class="civic-section-header">
  <span class="civic-eyebrow">AGENDA WILAYAH</span>
  <h1 class="h3 mb-1">Jadwal Kegiatan & Layanan Warga</h1>
  <p class="text-muted small mb-0">
    Jadwal gotong royong, ronda malam (siskamling), posyandu, dan agenda pertemuan warga.
  </p>
</div>

<!-- Filter & Search Controls -->
<div class="civic-card p-3 mb-4">
  <form method="get" action="/schedules" class="row g-2 align-items-center">
    <div class="col-md-6">
      <input type="text" name="q" class="civic-input" placeholder="Cari kegiatan atau lokasi..." value="{{ request('q') }}">
    </div>
    <div class="col-md-4">
      <select name="category" class="civic-select">
        <option value="">Semua Kategori Kegiatan</option>
        @foreach(config('warganet.schedule_categories') as $c)
          <option value="{{ $c }}" @selected(request('category') == $c)>{{ $c }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn-civic btn-civic-primary w-100">Saring</button>
    </div>
  </form>
</div>

<!-- Schedule Items Feed -->
<div class="d-flex flex-column gap-3">
  @forelse($items as $s)
    <article class="civic-card p-3 p-md-4">
      <div class="row g-3 align-items-center">
        <div class="col-auto">
          <div class="text-center p-3 rounded" style="background: var(--color-surface-subtle); border: 1px solid var(--color-border-subtle); min-width: 4.5rem;">
            <div class="small fw-bold text-uppercase font-monospace" style="color: var(--color-accent);">{{ $s->date->translatedFormat('M') }}</div>
            <div class="h3 mb-0 fw-bold">{{ $s->date->translatedFormat('d') }}</div>
            <div class="small text-muted font-monospace">{{ $s->date->translatedFormat('Y') }}</div>
          </div>
        </div>
        <div class="col">
          <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
            <span class="civic-badge civic-badge-neutral">{{ $s->category }}</span>
            @if($s->status === 'cancelled')
              <span class="civic-badge civic-badge-caution">Dibatalkan</span>
            @else
              <span class="civic-badge civic-badge-verified">Terjadwal</span>
            @endif
          </div>
          <h2 class="h5 fw-bold mb-1" style="color: var(--color-text-main);">{{ $s->title }}</h2>
          <div class="small text-muted font-monospace mb-2">
            🗓 {{ $s->date->translatedFormat('l') }} · 🕒 {{ substr($s->start_time, 0, 5) }}{{ $s->end_time ? ' – ' . substr($s->end_time, 0, 5) : '' }} WIB · 📍 {{ $s->location }}
          </div>
          @if($s->description)
            <p class="small text-muted mb-0" style="line-height: 1.5;">{{ $s->description }}</p>
          @endif
        </div>
      </div>
    </article>
  @empty
    <div class="civic-card p-5 text-center text-muted">
      Belum ada jadwal kegiatan yang terdaftar sesuai kriteria.
    </div>
  @endforelse
</div>
@endsection
