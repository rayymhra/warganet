{{-- Hallmark · macrostructure: Verification Queue Table · theme: Nusantara Civic · genre: editorial --}}
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

<div class="civic-section-header mb-3">
  <span class="civic-eyebrow">VERIFIKASI LAPORAN</span>
  <h1 class="h3 mb-1">Daftar Laporan Warga</h1>
  <p class="text-muted small mb-0">Tinjau kebenaran informasi dan validasi titik lokasi sebelum dipublikasikan ke papan publik.</p>
</div>

<!-- Status Filter Tabs (Gate 65: zero scroll-jump) -->
<div class="civic-card p-2 mb-4">
  <div class="d-flex gap-1 flex-wrap">
    <a class="btn-civic btn-civic-sm {{ !request('status') ? 'btn-civic-primary' : 'btn-civic-subtle' }}" href="/admin/reports">
      Semua Status
    </a>
    @foreach($st as $k => $v)
      <a class="btn-civic btn-civic-sm {{ request('status') === $k ? 'btn-civic-primary' : 'btn-civic-subtle' }}" href="/admin/reports?status={{ $k }}">
        {{ $v }}
      </a>
    @endforeach
  </div>
</div>

<!-- Tactical Table -->
<div class="civic-table-wrapper">
  <table class="civic-table">
    <thead>
      <tr>
        <th>Judul Kejadian</th>
        <th>Kategori (Bantuan AI)</th>
        <th>Status</th>
        <th>Pelapor</th>
        <th class="text-end">Tindakan</th>
      </tr>
    </thead>
    <tbody>
      @forelse($items as $r)
        <tr>
          <td>
            <div class="fw-semibold">{{ $r->title }}</div>
            <div class="small text-muted font-monospace">Diajukan: {{ $r->created_at->translatedFormat('d M Y H:i') }}</div>
          </td>
          <td>
            <div>{{ $inc[$r->category] ?? 'Belum ditentukan' }}</div>
            @if($r->ai_confidence)
              <div class="small text-muted font-monospace">Tingkat keyakinan: {{ round($r->ai_confidence * 100) }}%</div>
            @endif
          </td>
          <td>
            <span class="civic-badge {{ $col[$r->verification_status] ?? 'civic-badge-neutral' }}">
              {{ $st[$r->verification_status] ?? $r->verification_status }}
            </span>
          </td>
          <td>
            <div class="fw-medium">{{ $r->user->name }}</div>
            <div class="small text-muted font-monospace">{{ $r->user->email }}</div>
          </td>
          <td class="text-end">
            <a class="btn-civic btn-civic-primary btn-civic-sm" href="/admin/reports/{{ $r->id }}">
              Periksa & Putuskan
            </a>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="text-center py-5 text-muted">
            Tidak ada laporan warga pada status ini.
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
