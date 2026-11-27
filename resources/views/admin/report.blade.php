{{-- Hallmark · macrostructure: Incident Adjudication Dossier · theme: WargaNet Pastel Blue · genre: playful --}}
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

<div class="mb-3">
  <a href="/admin/reports" class="btn-pill btn-pill-outline btn-pill-sm">
    ← Kembali ke Daftar Laporan
  </a>
</div>

<div class="app-card mb-4 p-4">
  <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
    <div>
      <span class="badge-pill badge-pill-blue mb-1">BERKAS #{{ $r->id }}</span>
      <h1 class="h4 fw-bold mb-0 text-dark">{{ $r->title }}</h1>
    </div>
    <span class="badge-pill {{ $col[$r->verification_status] ?? 'badge-pill-blue' }}" style="font-size: 0.85rem; padding: 0.35rem 0.85rem;">
      {{ $st[$r->verification_status] ?? $r->verification_status }}
    </span>
  </div>

  <div class="p-3 rounded mb-3" style="background: var(--color-surface-subtle); border: 1px solid var(--color-border-card);">
    <div class="fw-bold small text-muted mb-1">DESKRIPSI DARI PELAPOR:</div>
    <p class="mb-0" style="line-height: 1.6;">{{ $r->description }}</p>
  </div>

  <div class="row g-3 mb-3 small">
    <div class="col-md-6">
      <div class="p-3 rounded border" style="border-color: var(--color-border-card) !important; background: #ffffff;">
        <div class="fw-bold text-muted small mb-1">DATA PELAPOR</div>
        <div class="fw-bold text-dark">{{ $r->user->name }} ({{ $r->user->email }})</div>
        @if($r->user->phone)<div class="font-monospace text-muted">Telp: {{ $r->user->phone }}</div>@endif
      </div>
    </div>
    <div class="col-md-6">
      <div class="p-3 rounded border" style="border-color: var(--color-border-card) !important; background: #ffffff;">
        <div class="fw-bold text-muted small mb-1">LOKASI & WAKTU KEJADIAN</div>
        <div class="fw-bold text-dark">
          <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
          {{ $r->location }}
        </div>
        <div class="font-monospace text-muted">{{ ($r->occurred_at ?? $r->created_at)->translatedFormat('l, d F Y H:i') }} WIB</div>
      </div>
    </div>
  </div>

  <div class="p-3 rounded mb-3" style="background: #eff6ff; border: 1px solid #bfdbfe;">
    <div class="small text-muted">
      Kategori: <strong>{{ $inc[$r->category] ?? 'Belum ada' }}</strong>
      @if($r->ai_severity) · Tingkat Keparahan AI: <strong>{{ $r->ai_severity }}</strong> @endif
      <br><em>Catatan: Rekomendasi kategori dari AI merupakan panduan awal, bukan vonis mutlak.</em>
    </div>
  </div>

  <!-- Inspection Photo with Fallback -->
  @if(!empty($r->image_path))
    <div class="mb-4">
      <div class="fw-bold small text-muted mb-2">FOTO LAMPIRAN KEJADIAN:</div>
      <img src="{{ asset('storage/'.$r->image_path) }}" 
           onerror="this.onerror=null;this.src='{{ asset('images/eas-badge.png') }}';" 
           alt="{{ $r->title }}" 
           class="img-fluid rounded border shadow-sm" 
           style="max-height: 320px; border-color: var(--color-border-card) !important;">
    </div>
  @endif

  <!-- Verification Decision Form -->
  <div class="pt-3 border-top" style="border-color: var(--color-border-card) !important;">
    <h2 class="h6 fw-bold mb-3 text-dark">Keputusan Verifikasi Pengurus</h2>

    <form method="post" action="/admin/reports/{{ $r->id }}/status" class="row g-3 align-items-end">
      @csrf
      @method('PATCH')

      <div class="col-md-3">
        <label class="form-label fw-bold small text-dark">Keputusan Status</label>
        <select name="status" class="form-select-pill">
          <option value="verified" @selected($r->verification_status === 'verified')>Terverifikasi (Tampilkan ke Publik)</option>
          <option value="rejected" @selected($r->verification_status === 'rejected')>Tolak Laporan</option>
          <option value="resolved" @selected($r->verification_status === 'resolved')>Sudah Ditangani / Selesai</option>
        </select>
      </div>

      <div class="col-md-3">
        <label class="form-label fw-bold small text-dark">Penyesuaian Kategori</label>
        <select name="category" class="form-select-pill">
          <option value="">Biarkan Seperti Aslinya</option>
          @foreach($inc as $k => $v)
            <option value="{{ $k }}" @selected($r->category === $k)>{{ $v }}</option>
          @endforeach
        </select>
      </div>

      <div class="col-md-4">
        <label class="form-label fw-bold small text-dark">Catatan Tindak Lanjut</label>
        <input name="notes" class="form-control-pill" placeholder="Opsional (catatan penanganan)...">
      </div>

      <div class="col-md-2">
        <button type="submit" class="btn-pill btn-pill-primary w-100 py-2">
          Simpan Status
        </button>
      </div>
    </form>
  </div>
</div>

<!-- History Log -->
<div class="app-card">
  <div class="app-card-header mb-2">
    <h3 class="app-card-title">Riwayat Keputusan & Perubahan</h3>
  </div>

  <div class="d-flex flex-column gap-2">
    @forelse($r->logs as $l)
      <div class="p-2 px-3 rounded small font-monospace" style="background: var(--color-surface-subtle); border: 1px solid var(--color-border-card);">
        <strong>{{ $l->created_at->translatedFormat('d M H:i') }}</strong>:
        <span class="text-muted">{{ $st[$l->previous_status] ?? '-' }}</span> →
        <span class="fw-bold text-dark">{{ $st[$l->new_status] ?? $l->new_status }}</span>
        @if($l->notes) — <em>"{{ $l->notes }}"</em> @endif
      </div>
    @empty
      <div class="text-muted small">Belum ada riwayat perubahan status.</div>
    @endforelse
  </div>
</div>
@endsection
