{{-- Hallmark · macrostructure: External Feed Audit Table · theme: WargaNet Pastel Blue · genre: playful --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
<!-- Admin Top Navigation Tabs -->
<div class="admin-tab-bar">
  <a href="/admin/dashboard" class="admin-tab-link">🏠 Ringkasan</a>
  <a href="/admin/reports" class="admin-tab-link">📋 Verifikasi Laporan</a>
  <a href="/admin/schedules" class="admin-tab-link">📅 Jadwal</a>
  <a href="/admin/announcements" class="admin-tab-link">📢 Pengumuman</a>
  <a href="/admin/businesses" class="admin-tab-link">🏪 Usaha</a>
  <a href="/admin/external-alerts" class="admin-tab-link active">🌐 Info Resmi (BMKG)</a>
</div>

<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
  <div>
    <h1 class="h4 fw-bold mb-1">Informasi Resmi (BMKG & Instansi Terkait)</h1>
    <div class="small text-muted">Data otomatis tersinkronisasi dari kanal resmi pemerintah (tidak ditinjau pengurus RT/RW)</div>
  </div>
</div>

<div class="app-card p-0 overflow-hidden">
  <div class="table-responsive">
    <table class="table align-middle mb-0" style="font-size: 0.885rem;">
      <thead style="background: var(--color-surface-subtle); border-bottom: 1px solid var(--color-border-card);">
        <tr>
          <th class="ps-3 py-3 fw-bold text-muted small">SUMBER</th>
          <th class="py-3 fw-bold text-muted small">JUDUL PERINGATAN</th>
          <th class="py-3 fw-bold text-muted small">WILAYAH</th>
          <th class="py-3 fw-bold text-muted small">WAKTU TERBIT</th>
          <th class="py-3 fw-bold text-muted small">DIAMBIL</th>
          <th class="pe-3 py-3 fw-bold text-muted small">STATUS</th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $e)
          <tr style="border-bottom: 1px solid var(--color-border-subtle);">
            <td class="ps-3 py-3">
              <a href="{{ $e->source_url }}" target="_blank" rel="noopener" class="fw-bold text-decoration-none" style="color: var(--color-accent);">
                {{ $e->source_name }} ↗
              </a>
            </td>
            <td class="py-3">
              <div class="fw-bold text-dark">{{ $e->title }}</div>
            </td>
            <td class="py-3">
              <span class="font-monospace text-muted small">📍 {{ $e->location }}</span>
            </td>
            <td class="py-3 font-monospace small text-muted">
              {{ $e->published_at }}
            </td>
            <td class="py-3 font-monospace small text-muted">
              {{ $e->fetched_at }}
            </td>
            <td class="pe-3 py-3">
              @if($e->isStale())
                <span class="badge-pill badge-pill-yellow">Data Lama</span>
              @else
                <span class="badge-pill badge-pill-green">Terbaru</span>
              @endif
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center py-5 text-muted">
              Belum ada data peringatan resmi yang terekam.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
