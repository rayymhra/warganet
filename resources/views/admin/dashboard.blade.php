{{-- Hallmark · macrostructure: Operational Command Matrix · theme: WargaNet Pastel Blue · genre: playful --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
@php
  $col = [
    'pending' => 'badge-pill-yellow',
    'verified' => 'badge-pill-green',
    'rejected' => 'badge-pill-red',
    'resolved' => 'badge-pill-blue'
  ];
  $st = config('warganet.report_status');
@endphp

<!-- Admin Top Navigation Tabs (SVG Icons) -->
<div class="admin-tab-bar">
  <a href="/admin/dashboard" class="admin-tab-link active">
    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
    <span>Ringkasan</span>
  </a>
  <a href="/admin/reports" class="admin-tab-link">
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

<!-- Header Title -->
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
  <div>
    <h1 class="h4 fw-bold mb-1">Panel Kendali Pengurus</h1>
    <div class="small text-muted">Ringkasan operasional dan laporan terkini di lingkungan warga</div>
  </div>
</div>

<!-- Operational Stat Cards (100% Dynamic Database Values) -->
<div class="row g-3 mb-4">
  <div class="col-6 col-md">
    <div class="stat-pill-card">
      <div class="stat-icon-circle">
        <svg class="svg-icon" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      </div>
      <div class="stat-value">{{ $stats['Residents'] ?? 0 }}</div>
      <div class="stat-label">Warga Terdaftar</div>
    </div>
  </div>

  <div class="col-6 col-md">
    <div class="stat-pill-card">
      <div class="stat-icon-circle">
        <svg class="svg-icon" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
      </div>
      <div class="stat-value">{{ $stats['Schedules'] ?? 0 }}</div>
      <div class="stat-label">Jadwal Kegiatan</div>
    </div>
  </div>

  <div class="col-6 col-md">
    <div class="stat-pill-card">
      <div class="stat-icon-circle">
        <svg class="svg-icon" viewBox="0 0 24 24"><path d="m3 11 18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg>
      </div>
      <div class="stat-value">{{ $stats['Announcements'] ?? 0 }}</div>
      <div class="stat-label">Pengumuman</div>
    </div>
  </div>

  <div class="col-6 col-md">
    <div class="stat-pill-card">
      <div class="stat-icon-circle" style="{{ ($stats['Pending reports'] ?? 0) > 0 ? 'background: #fee2e2; color: #ef4444;' : '' }}">
        <svg class="svg-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 14 14"/></svg>
      </div>
      <div class="stat-value" style="{{ ($stats['Pending reports'] ?? 0) > 0 ? 'color: var(--color-urgent);' : '' }}">
        {{ $stats['Pending reports'] ?? 0 }}
      </div>
      <div class="stat-label">Laporan Menunggu</div>
    </div>
  </div>

  <div class="col-6 col-md">
    <div class="stat-pill-card">
      <div class="stat-icon-circle" style="{{ ($stats['Verified / active alerts'] ?? 0) > 0 ? 'background: #fee2e2; color: #ef4444;' : '' }}">
        <svg class="svg-icon" viewBox="0 0 24 24"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
      </div>
      <div class="stat-value" style="{{ ($stats['Verified / active alerts'] ?? 0) > 0 ? 'color: var(--color-urgent);' : '' }}">
        {{ $stats['Verified / active alerts'] ?? 0 }}
      </div>
      <div class="stat-label">Info Darurat Aktif</div>
    </div>
  </div>
</div>

<!-- Latest Citizen Reports -->
<div class="app-card">
  <div class="app-card-header">
    <h2 class="app-card-title">Laporan Warga Terbaru Masuk</h2>
    <a href="/admin/reports" class="app-card-action">Lihat Semua Laporan →</a>
  </div>

  <div class="d-flex flex-column gap-2">
    @forelse($latest as $r)
      <a href="/admin/reports/{{ $r->id }}" class="p-3 rounded text-decoration-none d-flex align-items-center justify-content-between flex-wrap gap-2" style="background: var(--color-surface-subtle); border: 1px solid var(--color-border-card);">
        <div class="min-w-0">
          <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
            <span class="badge-pill {{ $col[$r->verification_status] ?? 'badge-pill-blue' }}">
              {{ $st[$r->verification_status] ?? $r->verification_status }}
            </span>
            <span class="fw-bold text-dark">{{ $r->title }}</span>
          </div>
          <div class="small text-muted font-monospace">
            Oleh: <strong>{{ $r->user->name }}</strong> · {{ $r->created_at->diffForHumans() }}
          </div>
        </div>

        <div>
          <span class="btn-pill btn-pill-primary btn-pill-sm">Periksa Laporan →</span>
        </div>
      </a>
    @empty
      <div class="text-center py-4 text-muted small">
        Tidak ada laporan baru yang menunggu verifikasi.
      </div>
    @endforelse
  </div>
</div>
@endsection
