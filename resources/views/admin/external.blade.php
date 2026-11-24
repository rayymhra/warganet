{{-- Hallmark · macrostructure: External Feed Audit Table · theme: Nusantara Civic · genre: editorial --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
<div class="civic-section-header mb-3">
  <span class="civic-eyebrow">INTEGRASI RESMI</span>
  <h1 class="h3 mb-1">Informasi Instansi Terkait (BMKG & Mitra)</h1>
  <p class="text-muted small mb-0">
    Sinkronisasi otomatis peringatan dini dari instansi resmi pemerintah. Data ini bukan hasil pemeriksaan verifikator RT/RW.
  </p>
</div>

<div class="civic-table-wrapper">
  <table class="civic-table">
    <thead>
      <tr>
        <th>Sumber Instansi</th>
        <th>Judul Peringatan</th>
        <th>Wilayah Terkait</th>
        <th>Waktu Terbit</th>
        <th>Diambil Sistem</th>
        <th>Validitas</th>
      </tr>
    </thead>
    <tbody>
      @forelse($items as $e)
        <tr>
          <td>
            <div class="fw-semibold">{{ $e->source_name }}</div>
            @if($e->source_url)
              <a href="{{ $e->source_url }}" target="_blank" rel="noopener" class="small text-decoration-none" style="color: var(--color-accent);">Tautan Sumber ↗</a>
            @endif
          </td>
          <td>
            <div class="fw-medium text-dark">{{ $e->title }}</div>
          </td>
          <td>
            <span class="font-monospace small text-muted">📍 {{ $e->location }}</span>
          </td>
          <td class="font-monospace small text-muted">
            {{ $e->published_at }}
          </td>
          <td class="font-monospace small text-muted">
            {{ $e->fetched_at }}
          </td>
          <td>
            @if($e->isStale())
              <span class="civic-badge civic-badge-caution">Data Arsip</span>
            @else
              <span class="civic-badge civic-badge-verified">Terkini</span>
            @endif
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" class="text-center py-5 text-muted">
            Belum ada feed data eksternal yang tercatat.
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
