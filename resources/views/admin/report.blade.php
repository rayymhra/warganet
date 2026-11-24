{{-- Hallmark · macrostructure: Incident Adjudication Dossier · theme: Nusantara Civic · genre: editorial --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
@php
  $st = config('warganet.report_status');
  $inc = config('warganet.incident');
  $col = [
    'pending' => 'civic-badge-caution',
    'verified' => 'civic-badge-verified',
    'rejected' => 'civic-badge-urgent',
    'resolved' => 'civic-badge-neutral'
  ];
@endphp

<div class="mb-3">
  <a href="/admin/reports" class="btn-civic btn-civic-subtle btn-civic-sm">
    ← Kembali ke Daftar Laporan
  </a>
</div>

<div class="civic-card p-4 p-md-5 mb-4">
  <div class="d-flex justify-content-between align-items-start gap-2 mb-3 flex-wrap">
    <div>
      <span class="civic-eyebrow">BERKAS LAPORAN #{{ $r->id }}</span>
      <h1 class="h3 fw-bold mb-1" style="color: var(--color-text-main);">{{ $r->title }}</h1>
    </div>
    <span class="civic-badge {{ $col[$r->verification_status] ?? 'civic-badge-neutral' }} fs-6">
      Status: {{ $st[$r->verification_status] ?? $r->verification_status }}
    </span>
  </div>

  <div class="p-3 mb-4 rounded" style="background: var(--color-surface-subtle); border: 1px solid var(--color-border-subtle);">
    <div class="fw-semibold text-muted small mb-1">KETERANGAN LAPORAN WARGA:</div>
    <p class="mb-0" style="font-size: 1rem; line-height: 1.6;">{{ $r->description }}</p>
  </div>

  <div class="row g-3 mb-4 small">
    <div class="col-md-6">
      <div class="p-3 rounded border" style="border-color: var(--color-border-subtle) !important;">
        <div class="civic-eyebrow mb-1">IDENTITAS PELAPOR</div>
        <div class="fw-semibold text-dark">{{ $r->user->name }}</div>
        <div class="font-monospace text-muted">{{ $r->user->email }}</div>
        @if($r->user->phone)<div class="font-monospace text-muted">Telp: {{ $r->user->phone }}</div>@endif
      </div>
    </div>
    <div class="col-md-6">
      <div class="p-3 rounded border" style="border-color: var(--color-border-subtle) !important;">
        <div class="civic-eyebrow mb-1">DATA LOKASI & WAKTU</div>
        <div class="fw-semibold text-dark">📍 {{ $r->location }}</div>
        <div class="font-monospace text-muted">Koordinat: {{ $r->latitude ?? '-' }}, {{ $r->longitude ?? '-' }}</div>
        <div class="font-monospace text-muted">Kejadian: {{ ($r->occurred_at ?? $r->created_at)->translatedFormat('l, d F Y H:i') }} WIB</div>
      </div>
    </div>
  </div>

  <div class="p-3 rounded mb-4" style="background: var(--color-surface-subtle); border: 1px solid var(--color-border-subtle);">
    <div class="civic-eyebrow mb-1">ANALISIS SISTEM / BANTUAN AI</div>
    <div class="small text-muted">
      Kategori Terdeteksi: <strong>{{ $inc[$r->category] ?? 'Belum ada' }}</strong>
      @if($r->ai_severity) · Tingkat Keparahan: <strong>{{ $r->ai_severity }}</strong> @endif
      — <em>Catatan: Rekomendasi sistem hanya sebagai panduan awal, bukan dasar penetapan fakta.</em>
    </div>
  </div>

  @if($r->image_path)
    <div class="mb-4">
      <div class="civic-eyebrow mb-2">LAMPIRAN FOTO LAPANGAN</div>
      <figure class="m-0">
        <img src="{{ asset('storage/'.$r->image_path) }}" alt="Foto dokumentasi kejadian" class="img-fluid rounded border" style="max-height: 380px; border-color: var(--color-border-subtle) !important;">
      </figure>
    </div>
  @endif

  <!-- Adjudication Decision Form -->
  <div class="pt-4 border-top" style="border-color: var(--color-border-subtle) !important;">
    <div class="civic-eyebrow mb-2">KEPUTUSAN PENGURUS RT/RW</div>
    <form method="post" action="/admin/reports/{{ $r->id }}/status" class="row g-3 align-items-end">
      @csrf
      @method('PATCH')

      <div class="col-md-3">
        <label class="civic-label">Keputusan Verifikasi</label>
        <select name="status" class="civic-select">
          <option value="verified" @selected($r->verification_status === 'verified')>✓ Terverifikasi (Tampilkan ke Publik)</option>
          <option value="rejected" @selected($r->verification_status === 'rejected')>✕ Tolak (Tidak Valid)</option>
          <option value="resolved" @selected($r->verification_status === 'resolved')>☑ Sudah Ditangani / Selesai</option>
        </select>
      </div>

      <div class="col-md-3">
        <label class="civic-label">Penyesuaian Kategori</label>
        <select name="category" class="civic-select">
          <option value="">Pertahankan Kategori Saat Ini</option>
          @foreach($inc as $k => $v)
            <option value="{{ $k }}" @selected($r->category === $k)>{{ $v }}</option>
          @endforeach
        </select>
      </div>

      <div class="col-md-4">
        <label class="civic-label">Catatan Verifikasi</label>
        <input name="notes" class="civic-input" placeholder="Alasan keputusan atau petunjuk penanganan...">
      </div>

      <div class="col-md-2">
        <button type="submit" class="btn-civic btn-civic-primary w-100">Simpan Status</button>
      </div>
    </form>
  </div>
</div>

<!-- Audit Trail Logs -->
<div class="civic-card p-4">
  <div class="civic-eyebrow mb-2">REKAM JEJAK VERIFIKASI</div>
  <h2 class="h6 fw-bold mb-3">Riwayat Perubahan Berkas</h2>

  <div class="d-flex flex-column gap-2">
    @forelse($r->logs as $l)
      <div class="small p-2 rounded d-flex justify-content-between align-items-center flex-wrap gap-2" style="background: var(--color-surface-subtle); border: 1px solid var(--color-border-subtle);">
        <div class="font-monospace">
          <strong>{{ $l->created_at->translatedFormat('d M Y H:i') }}</strong>:
          <span class="text-muted">{{ $st[$l->previous_status] ?? 'Awal' }}</span> →
          <span class="fw-semibold text-dark">{{ $st[$l->new_status] ?? $l->new_status }}</span>
          @if($l->notes) — <em>"{{ $l->notes }}"</em> @endif
        </div>
      </div>
    @empty
      <div class="small text-muted">Belum ada riwayat perubahan status untuk berkas ini.</div>
    @endforelse
  </div>
</div>
@endsection
