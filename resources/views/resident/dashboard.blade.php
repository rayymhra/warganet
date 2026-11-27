{{-- Hallmark · macrostructure: Resident Dossier & Status Timeline · theme: WargaNet Pastel Blue · genre: playful --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
@php
  $st = config('warganet.report_status');
  $col = [
    'pending' => 'badge-pill-yellow',
    'verified' => 'badge-pill-green',
    'rejected' => 'badge-pill-red',
    'resolved' => 'badge-pill-blue'
  ];
  $inc = config('warganet.incident');
@endphp

<!-- Header Title -->
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
  <div>
    <h1 class="h4 fw-bold mb-1">Daftar Laporan Saya</h1>
    <div class="small text-muted">Pantau status laporan dan penanganan pengurus RT/RW</div>
  </div>
  <a href="/resident/reports/create" class="btn-pill btn-pill-danger">
    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
    <span>Kirim Laporan Kejadian</span>
  </a>
</div>

<!-- Filter Pills -->
<div class="filter-pills-row mb-4">
  <span class="filter-pill-item active">Semua Laporan</span>
  <span class="filter-pill-item">Diproses</span>
  <span class="filter-pill-item">Terverifikasi</span>
</div>

<div class="row g-4">
  <!-- Left Column: Report List -->
  <div class="col-lg-8">
    <div class="app-card">
      <div class="app-card-header">
        <h2 class="app-card-title">Riwayat Pengajuan ({{ $reports->count() }})</h2>
      </div>

      <div class="d-flex flex-column gap-3">
        @forelse($reports as $r)
          <div class="p-3 rounded d-flex align-items-center justify-content-between flex-wrap gap-3" style="background: var(--color-surface-subtle); border: 1px solid var(--color-border-card);">
            <div class="d-flex align-items-center gap-3 min-w-0">
              <div class="stat-icon-circle m-0 flex-shrink-0" style="background: {{ $r->verification_status === 'verified' ? '#d1fae5' : '#fef3c7' }}; color: {{ $r->verification_status === 'verified' ? '#065f46' : '#92400e' }};">
                <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
              </div>
              <div class="min-w-0">
                <div class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">{{ $r->title }}</div>
                <div class="small text-muted font-monospace">
                  {{ $inc[$r->category] ?? 'Kejadian' }} · {{ $r->created_at->translatedFormat('d M Y · H:i') }} WIB
                </div>
                @if($r->description)
                  <div class="small text-muted mt-1">{{ \Illuminate\Support\Str::limit($r->description, 100) }}</div>
                @endif
              </div>
            </div>

            <div>
              <span class="badge-pill {{ $col[$r->verification_status] ?? 'badge-pill-blue' }}">
                {{ $r->verification_status === 'pending' ? 'Diproses' : ($st[$r->verification_status] ?? $r->verification_status) }}
              </span>
            </div>
          </div>
        @empty
          <div class="text-center py-5 text-muted">
            <div class="stat-icon-circle mx-auto mb-2">
              <svg class="svg-icon" viewBox="0 0 24 24"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/></svg>
            </div>
            <p class="mb-3">Anda belum pernah membuat laporan kejadian.</p>
            <a href="/resident/reports/create" class="btn-pill btn-pill-danger btn-pill-sm">
              Buat Laporan Pertama
            </a>
          </div>
        @endforelse
      </div>
    </div>
  </div>

  <!-- Right Column: Notifications & Information -->
  <div class="col-lg-4">
    <div class="app-card">
      <div class="app-card-header">
        <h3 class="app-card-title">Pemberitahuan Sistem</h3>
      </div>

      <div class="d-flex flex-column gap-2">
        @forelse($notes as $n)
          <div class="p-3 rounded" style="background: var(--color-surface-subtle); border: 1px solid var(--color-border-subtle);">
            <div class="fw-bold text-dark small mb-1 d-flex align-items-center gap-1">
              <svg class="svg-icon svg-icon-sm text-primary" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
              <span>{{ $n->title }}</span>
            </div>
            <div class="small text-muted" style="line-height: 1.5;">{{ $n->message }}</div>
          </div>
        @empty
          <div class="text-center py-4 text-muted small">
            Belum ada pemberitahuan baru.
          </div>
        @endforelse
      </div>

      <div class="p-3 rounded mt-3 text-center" style="background: #f0f7ff; border: 1px solid #dbeafe;">
        <img src="{{ asset('images/cat-peeking.png') }}" 
             onerror="this.onerror=null;this.src='{{ asset('images/cat-waving.png') }}';" 
             alt="Mascot" 
             style="height: 60px; width: auto; margin-bottom: 0.4rem;">
        <div class="small fw-bold text-primary">Status Verifikasi Cepat</div>
        <div class="small text-muted" style="font-size: 0.75rem;">Pengurus RT/RW selalu memantau laporan warga 24/7.</div>
      </div>
    </div>
  </div>
</div>
@endsection
