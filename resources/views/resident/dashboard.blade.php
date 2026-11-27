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

<!-- Header Title from Reference: "Daftar Laporan Saya" -->
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
  <div>
    <h1 class="h4 fw-bold mb-1">Daftar Laporan Saya</h1>
    <div class="small text-muted">Pantau status laporan dan penanganan pengurus RT/RW</div>
  </div>
  <a href="/resident/reports/create" class="btn-pill btn-pill-danger">
    📢 Kirim Laporan Kejadian
  </a>
</div>

<!-- Filter Pills from Reference Screen 2: "Semua", "Diproses", "Terverifikasi" -->
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
                @if(str_contains(strtolower($r->title), 'pohon')) 🌳
                @elseif(str_contains(strtolower($r->title), 'banjir') || str_contains(strtolower($r->title), 'air')) 💧
                @elseif(str_contains(strtolower($r->title), 'lampu') || str_contains(strtolower($r->title), 'listrik')) 💡
                @else ⚠️ @endif
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
            <div class="stat-icon-circle mx-auto mb-2">📋</div>
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
            <div class="fw-bold text-dark small mb-1">🔔 {{ $n->title }}</div>
            <div class="small text-muted" style="line-height: 1.5;">{{ $n->message }}</div>
          </div>
        @empty
          <div class="text-center py-4 text-muted small">
            Belum ada pemberitahuan baru.
          </div>
        @endforelse
      </div>

      <div class="p-3 rounded mt-3 text-center" style="background: #f0f7ff; border: 1px solid #dbeafe;">
        <img src="{{ asset('images/cat-peeking.png') }}" alt="Mascot" style="height: 60px; width: auto; margin-bottom: 0.4rem;">
        <div class="small fw-bold text-primary">Status Verifikasi Cepat</div>
        <div class="small text-muted" style="font-size: 0.75rem;">Pengurus RT/RW selalu memantau laporan warga 24/7.</div>
      </div>
    </div>
  </div>
</div>
@endsection
