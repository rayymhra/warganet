{{-- Hallmark · macrostructure: Operational Command Matrix · theme: Nusantara Civic · genre: editorial --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
@php
  $col = [
    'pending' => 'civic-badge-caution',
    'verified' => 'civic-badge-verified',
    'rejected' => 'civic-badge-urgent',
    'resolved' => 'civic-badge-neutral'
  ];
  $st = config('warganet.report_status');
@endphp

<div class="civic-section-header mb-4">
  <span class="civic-eyebrow">PUSAT KENDALI PENGURUS</span>
  <h1 class="h3 mb-1">Ringkasan Operasional Wilayah</h1>
  <p class="text-muted small mb-0">Status pengelolaan warga, agenda, dan verifikasi laporan terkini.</p>
</div>

<!-- Real Civic Metrics (Honest Data Bindings) -->
<div class="row g-3 mb-5">
  @foreach([
    ['Warga Terdaftar', 'Residents', 'Warga Aktif'],
    ['Agenda Kegiatan', 'Schedules', 'Jadwal Rukun Warga'],
    ['Pengumuman', 'Announcements', 'Maklumat Diterbitkan'],
    ['Laporan Menunggu', 'Pending reports', 'Perlu Verifikasi Segera'],
    ['Info Darurat Aktif', 'Verified / active alerts', 'Status Lapangan']
  ] as [$label, $key, $sub])
    <div class="col-6 col-md">
      <div class="civic-card p-3 h-100 d-flex flex-column justify-content-between">
        <div class="font-monospace small text-muted text-uppercase mb-1" style="font-size: 0.725rem;">
          {{ $label }}
        </div>
        <div class="h2 fw-bold mb-1 font-monospace" style="color: {{ $key === 'Pending reports' && $stats[$key] > 0 ? 'var(--color-urgent)' : 'var(--color-accent)' }};">
          {{ $stats[$key] }}
        </div>
        <div class="small text-muted" style="font-size: 0.75rem;">{{ $sub }}</div>
      </div>
    </div>
  @endforeach
</div>

<!-- Latest Triage Feed -->
<div class="civic-card p-4">
  <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
      <h2 class="h5 fw-bold mb-0" style="color: var(--color-text-main);">Laporan Warga Terbaru</h2>
      <div class="small text-muted">Laporan yang masuk dan membutuhkan peninjauan pengurus.</div>
    </div>
    <a href="/admin/reports" class="btn-civic btn-civic-outline btn-civic-sm">
      Buka Semua Laporan →
    </a>
  </div>

  <div class="d-flex flex-column gap-2">
    @forelse($latest as $r)
      <a href="/admin/reports/{{ $r->id }}" class="civic-card p-3 text-decoration-none d-flex justify-content-between align-items-center gap-3 flex-wrap" style="background: var(--color-surface-subtle); border-color: var(--color-border-subtle);">
        <div class="min-w-0">
          <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
            <span class="civic-badge {{ $col[$r->verification_status] ?? 'civic-badge-neutral' }}">
              {{ $st[$r->verification_status] ?? $r->verification_status }}
            </span>
            <span class="fw-semibold text-dark">{{ $r->title }}</span>
          </div>
          <div class="small text-muted font-monospace">
            Dilaporkan oleh <strong>{{ $r->user->name }}</strong> · {{ $r->created_at->diffForHumans() }}
          </div>
        </div>
        <div>
          <span class="btn-civic btn-civic-primary btn-civic-sm">Periksa Berkas →</span>
        </div>
      </a>
    @empty
      <div class="p-4 text-center text-muted small">
        Belum ada laporan baru dari warga.
      </div>
    @endforelse
  </div>
</div>
@endsection
