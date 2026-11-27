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

<!-- Admin Top Navigation Tabs -->
<div class="admin-tab-bar">
  <a href="/admin/dashboard" class="admin-tab-link active">🏠 Ringkasan</a>
  <a href="/admin/reports" class="admin-tab-link">📋 Verifikasi Laporan</a>
  <a href="/admin/schedules" class="admin-tab-link">📅 Jadwal</a>
  <a href="/admin/announcements" class="admin-tab-link">📢 Pengumuman</a>
  <a href="/admin/businesses" class="admin-tab-link">🏪 Usaha</a>
  <a href="/admin/external-alerts" class="admin-tab-link">🌐 Info Resmi (BMKG)</a>
</div>

<!-- Header Title -->
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
  <div>
    <h1 class="h4 fw-bold mb-1">Panel Kendali Pengurus</h1>
    <div class="small text-muted">Ringkasan operasional dan laporan terkini di lingkungan warga</div>
  </div>
</div>

<!-- Operational Stat Cards (Real Data Bindings) -->
<div class="row g-3 mb-4">
  @foreach([
    ['Warga Terdaftar', 'Residents', '👥'],
    ['Jadwal Kegiatan', 'Schedules', '📅'],
    ['Pengumuman', 'Announcements', '📢'],
    ['Laporan Menunggu', 'Pending reports', '⏳'],
    ['Info Darurat Aktif', 'Verified / active alerts', '🚨']
  ] as [$label, $key, $icon])
    <div class="col-6 col-md">
      <div class="stat-pill-card">
        <div class="stat-icon-circle">{{ $icon }}</div>
        <div class="stat-value" style="{{ $key === 'Pending reports' && $stats[$key] > 0 ? 'color: var(--color-urgent);' : '' }}">
          {{ $stats[$key] }}
        </div>
        <div class="stat-label">{{ $label }}</div>
      </div>
    </div>
  @endforeach
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
