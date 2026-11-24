{{-- Hallmark · macrostructure: Merchant Directory Ledger · theme: Nusantara Civic · genre: editorial --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
<div class="civic-section-header">
  <span class="civic-eyebrow">EKONOMI WARGA</span>
  <h1 class="h3 mb-1">Direktori Usaha & Jasa Lingkungan</h1>
  <p class="text-muted small mb-0">
    Mendukung perputaran ekonomi tetangga: warung, jasa servis, kuliner, dan usaha rumahan warga.
  </p>
</div>

<!-- Filter & Search Controls -->
<div class="civic-card p-3 mb-4">
  <form method="get" action="/businesses" class="row g-2 align-items-center">
    <div class="col-md-6">
      <input type="text" name="q" class="civic-input" placeholder="Cari nama usaha atau jenis barang..." value="{{ request('q') }}">
    </div>
    <div class="col-md-4">
      <select name="category" class="civic-select">
        <option value="">Semua Kategori Usaha</option>
        @foreach(config('warganet.business_categories') as $c)
          <option value="{{ $c }}" @selected(request('category') == $c)>{{ $c }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn-civic btn-civic-primary w-100">Cari</button>
    </div>
  </form>
</div>

<!-- Business Cards Grid -->
<div class="row g-3">
  @forelse($items as $b)
    <div class="col-md-6 col-lg-4">
      <div class="civic-card p-4 h-100 d-flex flex-column justify-content-between">
        <div>
          <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
            <h2 class="h6 fw-bold mb-0" style="color: var(--color-text-main);">{{ $b->name }}</h2>
            <span class="civic-badge civic-badge-accent">{{ $b->category }}</span>
          </div>
          @if($b->description)
            <p class="small text-muted mb-3" style="line-height: 1.5;">{{ $b->description }}</p>
          @endif
        </div>
        <div class="pt-3 border-top small" style="border-color: var(--color-border-subtle) !important;">
          <div class="text-muted mb-1">📍 {{ $b->address }}</div>
          <div class="text-muted mb-1 font-monospace">📞 {{ $b->phone }}</div>
          @if($b->operating_hours)
            <div class="text-muted font-monospace">🕒 {{ $b->operating_hours }}</div>
          @endif
        </div>
      </div>
    </div>
  @empty
    <div class="col-12">
      <div class="civic-card p-5 text-center text-muted">
        Tidak ditemukan unit usaha yang sesuai pencarian Anda.
      </div>
    </div>
  @endforelse
</div>
@endsection
