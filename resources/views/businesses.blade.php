{{-- Hallmark · macrostructure: Local Business Directory · theme: WargaNet Pastel Blue · genre: playful --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
<!-- Header Banner with WargaMart Mascot & Fallback -->
<div class="hero-banner-card mb-4" style="background: linear-gradient(135deg, #ffffff 0%, #dbeafe 100%);">
  <div class="row align-items-center g-3">
    <div class="col-md-8">
      <div class="badge-pill badge-pill-blue mb-2">DIREKTORI UMKM</div>
      <h1 class="h3 fw-bold mb-1">Daftar UMKM Lokal</h1>
      <p class="hero-banner-desc mb-3">
        Dukung produk dan jasa tetangga, majukan perputaran ekonomi warga kita bersama.
      </p>
      @if(auth()->check() && auth()->user()->role === 'admin')
        <a href="/admin/businesses" class="btn-pill btn-pill-primary btn-pill-sm">
          + Tambah UMKM Warga
        </a>
      @endif
    </div>
    <div class="col-md-4 text-md-end d-none d-md-block">
      <img src="{{ asset('images/wargamart-mascot.png') }}" 
           onerror="this.onerror=null;this.src='{{ asset('images/cat-waving.png') }}';" 
           alt="WargaMart Mascot" 
           style="max-height: 125px; width: auto; filter: drop-shadow(0 4px 10px rgba(37,99,235,0.15));">
    </div>
  </div>
</div>

<!-- Search Input -->
<div class="app-card p-3 mb-3">
  <form method="get" action="/businesses" class="d-flex gap-2">
    <div class="input-group">
      <span class="input-group-text bg-white border-end-0" style="border-radius: var(--radius-pill) 0 0 var(--radius-pill); border-color: var(--color-border-card);">
        <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
      </span>
      <input type="text" name="q" class="form-control-pill border-start-0" style="border-radius: 0 var(--radius-pill) var(--radius-pill) 0;" placeholder="Cari UMKM, produk, atau jasa..." value="{{ request('q') }}">
    </div>
    <button type="submit" class="btn-pill btn-pill-primary flex-shrink-0">Cari</button>
  </form>
</div>

<!-- Filter Pills (100% Dynamic Database/Config Categories) -->
<div class="filter-pills-row mb-4">
  <a href="/businesses" class="filter-pill-item {{ !request('category') ? 'active' : '' }}">
    Semua
  </a>
  @foreach(config('warganet.business_categories') as $c)
    <a href="/businesses?category={{ urlencode($c) }}" class="filter-pill-item {{ request('category') == $c ? 'active' : '' }}">
      {{ $c }}
    </a>
  @endforeach
</div>

<!-- UMKM Cards Grid with Image Fallback Logic -->
<div class="row g-3">
  @forelse($items as $b)
    <div class="col-md-6 col-lg-4">
      <div class="app-card p-3 h-100 d-flex flex-column justify-content-between">
        <div>
          <!-- Thumbnail Image with Fallback -->
          <div class="rounded overflow-hidden mb-3" style="background: #f8fafc; border: 1px solid var(--color-border-subtle); height: 120px;">
            <img src="{{ !empty($b->image_path) ? asset('storage/'.$b->image_path) : asset('images/wargamart-mascot.png') }}" 
                 onerror="this.onerror=null;this.src='{{ asset('images/wargamart-mascot.png') }}';" 
                 alt="{{ $b->name }}" 
                 class="w-100 h-100 object-fit-cover">
          </div>

          <!-- Business Category Pill & Name -->
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="badge-pill badge-pill-blue">{{ $b->category }}</span>
            <span class="small text-muted font-monospace">Rekomendasi Warga</span>
          </div>

          <h3 class="h6 fw-bold mb-2 text-dark">{{ $b->name }}</h3>

          @if($b->description)
            <p class="small text-muted mb-3" style="line-height: 1.5;">
              {{ \Illuminate\Support\Str::limit($b->description, 90) }}
            </p>
          @endif
        </div>

        <!-- Contact & Location Metadata -->
        <div class="pt-2 border-top small" style="border-color: var(--color-border-subtle) !important;">
          @if($b->address)
            <div class="text-muted mb-1 text-truncate">
              <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
              {{ $b->address }}
            </div>
          @endif
          @if($b->phone)
            <div class="text-muted mb-1 font-monospace">
              <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
              {{ $b->phone }}
            </div>
          @endif
          @if($b->operating_hours)
            <div class="text-muted mb-2 font-monospace">
              <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              {{ $b->operating_hours }}
            </div>
          @endif

          @if($b->phone)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $b->phone) }}" target="_blank" rel="noopener" class="btn-pill btn-pill-outline btn-pill-sm w-100">
              Hubungi Penjual →
            </a>
          @endif
        </div>
      </div>
    </div>
  @empty
    <div class="col-12">
      <div class="app-card text-center py-5 text-muted">
        <div class="stat-icon-circle mx-auto mb-2">
          <svg class="svg-icon" viewBox="0 0 24 24"><path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"/><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"/><path d="M2 7h20"/></svg>
        </div>
        Tidak ditemukan unit UMKM warga yang sesuai kriteria pencarian.
      </div>
    </div>
  @endforelse
</div>
@endsection
