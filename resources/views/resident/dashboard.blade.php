{{-- Hallmark · macrostructure: Resident Dossier & Status Timeline · theme: Nusantara Civic · genre: editorial --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
@php
  $st = config('warganet.report_status');
  $col = [
    'pending' => 'civic-badge-caution',
    'verified' => 'civic-badge-verified',
    'rejected' => 'civic-badge-urgent',
    'resolved' => 'civic-badge-neutral'
  ];
  $inc = config('warganet.incident');
@endphp

<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
  <div class="civic-section-header mb-0">
    <span class="civic-eyebrow">DASBOR WARGA</span>
    <h1 class="h3 mb-0">Laporan & Partisipasi Saya</h1>
  </div>
  <a class="btn-civic btn-civic-urgent" href="/resident/reports/create">
    📢 Buat Laporan Baru
  </a>
</div>

<div class="row g-4">
  <!-- Left Column: Personal Report History -->
  <div class="col-lg-8">
    <div class="civic-section-header">
      <span class="civic-eyebrow">RIWAYAT PENGAJUAN</span>
      <h2 class="h5 mb-0">Laporan Kejadian yang Diajukan</h2>
    </div>

    <div class="d-flex flex-column gap-3">
      @forelse($reports as $r)
        <article class="civic-card p-3 p-md-4">
          <div class="d-flex justify-content-between align-items-start gap-2 mb-2 flex-wrap">
            <h3 class="h6 fw-bold mb-0" style="color: var(--color-text-main);">{{ $r->title }}</h3>
            <span class="civic-badge {{ $col[$r->verification_status] ?? 'civic-badge-neutral' }}">
              {{ $st[$r->verification_status] ?? $r->verification_status }}
            </span>
          </div>

          <div class="small text-muted font-monospace mb-2">
            {{ $inc[$r->category] ?? 'Belum dikategorikan' }} · Diajukan pada {{ $r->created_at->translatedFormat('d F Y H:i') }} WIB
          </div>

          @if($r->description)
            <p class="small text-muted mb-0" style="line-height: 1.5;">
              {{ \Illuminate\Support\Str::limit($r->description, 120) }}
            </p>
          @endif
        </article>
      @empty
        <div class="civic-card p-5 text-center">
          <div class="font-monospace small text-muted mb-2">BELUM ADA LAPORAN</div>
          <p class="mb-3 text-muted">Anda belum pernah mengirimkan laporan kejadian lingkungan.</p>
          <a class="btn-civic btn-civic-urgent btn-civic-sm" href="/resident/reports/create">
            Kirim Laporan Pertama Anda
          </a>
        </div>
      @endforelse
    </div>
  </div>

  <!-- Right Column: Personal Notifications & Guidance -->
  <div class="col-lg-4">
    <div class="civic-section-header">
      <span class="civic-eyebrow">KOTAK MASUK</span>
      <h2 class="h5 mb-0">Pemberitahuan</h2>
    </div>

    <div class="d-flex flex-column gap-3">
      @forelse($notes as $n)
        <div class="civic-card p-3">
          <div class="d-flex align-items-center gap-2 mb-1">
            <span class="civic-badge civic-badge-accent">INFO</span>
            <div class="fw-semibold small" style="color: var(--color-text-main);">{{ $n->title }}</div>
          </div>
          <p class="small text-muted mb-0" style="line-height: 1.5;">{{ $n->message }}</p>
        </div>
      @empty
        <div class="civic-card p-4 text-center text-muted small">
          Belum ada pemberitahuan baru untuk akun Anda.
        </div>
      @endforelse

      <div class="p-3 rounded" style="background: var(--color-surface-subtle); border: 1px solid var(--color-border-subtle);">
        <div class="civic-eyebrow mb-1">CATATAN PENGURUS</div>
        <p class="small text-muted mb-0">
          Setiap status perubahan (Terverifikasi, Selesai, atau Ditolak) akan otomatis dicatat pada riwayat di sebelah kiri.
        </p>
      </div>
    </div>
  </div>
</div>
@endsection
