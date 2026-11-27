{{-- Hallmark · macrostructure: Verification Queue Table · theme: WargaNet Pastel Blue · genre: playful --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
@php
  $st = config('warganet.report_status');
  $inc = config('warganet.incident');
  $col = [
    'pending' => 'badge-pill-yellow',
    'verified' => 'badge-pill-green',
    'rejected' => 'badge-pill-red',
    'resolved' => 'badge-pill-blue'
  ];
@endphp

<!-- Admin Top Navigation Tabs -->
<div class="admin-tab-bar">
  <a href="/admin/dashboard" class="admin-tab-link">🏠 Ringkasan</a>
  <a href="/admin/reports" class="admin-tab-link active">📋 Verifikasi Laporan</a>
  <a href="/admin/schedules" class="admin-tab-link">📅 Jadwal</a>
  <a href="/admin/announcements" class="admin-tab-link">📢 Pengumuman</a>
  <a href="/admin/businesses" class="admin-tab-link">🏪 Usaha</a>
  <a href="/admin/external-alerts" class="admin-tab-link">🌐 Info Resmi (BMKG)</a>
</div>

<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
  <div>
    <h1 class="h4 fw-bold mb-1">Daftar Laporan Kejadian Warga</h1>
    <div class="small text-muted">Periksa keabsahan dan tentukan status verifikasi sebelum tayang ke publik</div>
  </div>
</div>

<!-- Status Filters -->
<div class="filter-pills-row mb-4">
  <a href="/admin/reports" class="filter-pill-item {{ !request('status') ? 'active' : '' }}">
    Semua Status
  </a>
  @foreach($st as $k => $v)
    <a href="/admin/reports?status={{ $k }}" class="filter-pill-item {{ request('status') === $k ? 'active' : '' }}">
      {{ $v }}
    </a>
  @endforeach
</div>

<!-- Table Container -->
<div class="app-card p-0 overflow-hidden">
  <div class="table-responsive">
    <table class="table align-middle mb-0" style="font-size: 0.885rem;">
      <thead style="background: var(--color-surface-subtle); border-bottom: 1px solid var(--color-border-card);">
        <tr>
          <th class="ps-3 py-3 fw-bold text-muted small">JUDUL KEJADIAN</th>
          <th class="py-3 fw-bold text-muted small">KATEGORI (AI)</th>
          <th class="py-3 fw-bold text-muted small">STATUS</th>
          <th class="py-3 fw-bold text-muted small">PELAPOR</th>
          <th class="pe-3 py-3 text-end fw-bold text-muted small">AKSI</th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $r)
          <tr style="border-bottom: 1px solid var(--color-border-subtle);">
            <td class="ps-3 py-3">
              <div class="fw-bold text-dark">{{ $r->title }}</div>
              <div class="small text-muted font-monospace">{{ $r->created_at->translatedFormat('d M Y H:i') }}</div>
            </td>
            <td class="py-3">
              <div>{{ $inc[$r->category] ?? '—' }}</div>
              @if($r->ai_confidence)
                <span class="badge-pill badge-pill-blue" style="font-size: 0.7rem;">Keyakinan AI: {{ round($r->ai_confidence * 100) }}%</span>
              @endif
            </td>
            <td class="py-3">
              <span class="badge-pill {{ $col[$r->verification_status] ?? 'badge-pill-blue' }}">
                {{ $st[$r->verification_status] ?? $r->verification_status }}
              </span>
            </td>
            <td class="py-3">
              <div class="fw-semibold">{{ $r->user->name }}</div>
              <div class="small text-muted font-monospace">{{ $r->user->email }}</div>
            </td>
            <td class="pe-3 py-3 text-end">
              <a href="/admin/reports/{{ $r->id }}" class="btn-pill btn-pill-primary btn-pill-sm">
                Periksa Berkas
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center py-5 text-muted">
              Tidak ada data laporan pada status ini.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
