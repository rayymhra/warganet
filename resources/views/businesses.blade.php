{{-- Hallmark · macrostructure: Local Business Directory · theme: WargaNet Pastel Blue · genre: playful --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
<!-- Header Banner matching Screen 3: Local Business Directory with WargaMart Mascot -->
<div class="hero-banner-card mb-4" style="background: linear-gradient(135deg, #ffffff 0%, #dbeafe 100%);">
  <div class="row align-items-center g-3">
    <div class="col-md-8">
      <div class="badge-pill badge-pill-blue mb-2">3. LOCAL BUSINESS DIRECTORY</div>
      <h1 class="h3 fw-bold mb-1">Daftar UMKM Lokal</h1>
      <p class="hero-banner-desc mb-3">
        Dukung produk dan jasa tetangga, majukan perputaran ekonomi warga kita!
      </p>
      @if(auth()->check() && auth()->user()->role === 'admin')
        <a href="/admin/businesses" class="btn-pill btn-pill-primary btn-pill-sm">
          + Tambah UMKM Warga
        </a>
      @endif
    </div>
    <div class="col-md-4 text-md-end d-none d-md-block">
      <img src="{{ asset('images/wargamart-mascot.png') }}" alt="WargaMart Mascot" style="max-height: 125px; width: auto; filter: drop-shadow(0 4px 10px rgba(37,99,235,0.15));">
    </div>
  </div>
</div>

<!-- Search Input matching Reference Screen 3 -->
<div class="app-card p-3 mb-3">
  <form method="get" action="/businesses" class="d-flex gap-2">
    <input type="text" name="q" class="form-control-pill" placeholder="🔍 Cari UMKM, produk, atau jasa..." value="{{ request('q') }}">
    <button type="submit" class="btn-pill btn-pill-primary">Cari</button>
  </form>
</div>

<!-- Filter Pills from Reference Screen 3: Semua, Makanan & Minuman, Fashion, Jasa, etc. -->
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

<!-- UMKM Cards Grid matching Reference Screen 3 Card Structure -->
<div class="row g-3">
  @forelse($items as $b)
    <div class="col-md-6 col-lg-4">
      <div class="app-card p-3 h-100 d-flex flex-column justify-content-between">
        <div>
          <!-- Business Category Pill & Name -->
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="badge-pill badge-pill-blue">{{ $b->category }}</span>
            <span class="small text-muted font-monospace">⭐ Rekomendasi</span>
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
            <div class="text-muted mb-1 text-truncate">📍 {{ $b->address }}</div>
          @endif
          @if($b->phone)
            <div class="text-muted mb-1 font-monospace">📞 {{ $b->phone }}</div>
          @endif
          @if($b->operating_hours)
            <div class="text-muted mb-2 font-monospace">🕒 {{ $b->operating_hours }}</div>
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
        <div class="stat-icon-circle mx-auto mb-2">🏪</div>
        Tidak ditemukan unit UMKM warga yang sesuai kriteria pencarian.
      </div>
    </div>
  @endforelse
</div>
@endsection
