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
  <a href="/admin/dashboard" class="admin-tab-link">
    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
    <span>Ringkasan</span>
  </a>
  <a href="/admin/reports" class="admin-tab-link active">
    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/></svg>
    <span>Verifikasi Laporan</span>
  </a>
  <a href="/admin/schedules" class="admin-tab-link">
    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
    <span>Jadwal</span>
  </a>
  <a href="/admin/announcements" class="admin-tab-link">
    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="m3 11 18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg>
    <span>Pengumuman</span>
  </a>
  <a href="/admin/businesses" class="admin-tab-link">
    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"/><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"/><path d="M2 7h20"/></svg>
    <span>Usaha</span>
  </a>
  <a href="/admin/external-alerts" class="admin-tab-link">
    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" x2="22" y1="12" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
    <span>Info Resmi (BMKG)</span>
  </a>
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
