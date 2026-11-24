{{-- Hallmark · macrostructure: Civic Bulletin & Operational Gazette · theme: Nusantara Civic · genre: editorial --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
@php
  $u = auth()->user();
  $inc = config('warganet.incident');
@endphp

<!-- Lead Civic Dispatch Header -->
<section class="civic-card p-4 p-md-5 mb-4 border-0" style="background: var(--color-surface); border-left: 4px solid var(--color-accent) !important;">
  <div class="row g-4 align-items-center">
    <div class="col-lg-8">
      <div class="civic-eyebrow">PORTAL KOORDINASI WARGA</div>
      <h1 class="display-6 fw-bold mb-3" style="color: var(--color-text-main); line-height: 1.15;">
        Pusat Komunikasi & Ketertiban Lingkungan Warga.
      </h1>
      <p class="mb-4 text-muted" style="max-width: 620px; font-size: 1.025rem;">
        Kanal resmi pemantauan agenda lingkungan, rilis maklumat pengurus, dan pelaporan kejadian cepat terverifikasi untuk ketenteraman warga bersama.
      </p>
      <div class="d-flex align-items-center gap-2 flex-wrap">
        <a href="/schedules" class="btn-civic btn-civic-primary">
          <span>Lihat Agenda Kegiatan</span>
          <span>→</span>
        </a>
        @guest
          <a href="/register" class="btn-civic btn-civic-outline">Daftar Akun Warga</a>
        @elseif($u->role === 'resident')
          <a href="/resident/reports/create" class="btn-civic btn-civic-urgent">📢 Laporkan Kejadian</a>
        @else
          <a href="/admin/dashboard" class="btn-civic btn-civic-outline">Buka Panel Admin</a>
        @endguest
      </div>
    </div>
    <div class="col-lg-4">
      <div class="p-3" style="background: var(--color-surface-subtle); border: 1px solid var(--color-border-subtle); border-radius: var(--radius-sm);">
        <div class="civic-eyebrow mb-1">STATUS LINGKUNGAN</div>
        @if($alerts->count())
          <div class="d-flex align-items-center gap-2 text-danger fw-semibold mb-2">
            <span class="civic-badge civic-badge-urgent">WASPADA</span>
            <span>{{ $alerts->count() }} Peringatan Terverifikasi</span>
          </div>
          <p class="small text-muted mb-2">Periksa informasi keadaan darurat dan imbauan keselamatan pengurus.</p>
          <a href="/emergency-alerts" class="btn-civic btn-civic-urgent btn-civic-sm w-100">Buka Info Darurat</a>
        @else
          <div class="d-flex align-items-center gap-2 text-success fw-semibold mb-1">
            <span class="civic-badge civic-badge-verified">KONDUSIF</span>
            <span style="color: var(--color-verified-text);">Situasi Terpantau Aman</span>
          </div>
          <p class="small text-muted mb-0">Tidak ada laporan darurat yang aktif. Laporkan segera jika menemukan potensi kendala di sekitar Anda.</p>
        @endif
      </div>
    </div>
  </div>
</section>

<!-- Active Emergency Flash (Shown only when real alerts exist) -->
@if($alerts->count())
  <div class="civic-alert civic-alert-urgent align-items-center justify-content-between flex-wrap gap-2 mb-4">
    <div class="d-flex align-items-center gap-2">
      <span class="civic-badge civic-badge-urgent">PERINGATAN</span>
      <span class="fw-semibold">Terdapat {{ $alerts->count() }} kejadian yang telah diverifikasi oleh pengurus.</span>
    </div>
    <a href="/emergency-alerts" class="btn-civic btn-civic-urgent btn-civic-sm">Lihat Detail Laporan & Titik Lokasi →</a>
  </div>
@endif

<!-- Asymmetric Dual Gazette: Agenda & Maklumat -->
<div class="row g-4 mb-5">
  <!-- Left Column: Announcements (Warta Warga) -->
  <div class="col-lg-7">
    <div class="civic-section-header">
      <span class="civic-eyebrow">WARTA & MAKLUMAT</span>
      <h2 class="h4 mb-0">Pengumuman Terbaru</h2>
    </div>

    <div class="d-flex flex-column gap-3">
      @forelse($announcements as $a)
        <article class="civic-card p-3 p-md-4 position-relative">
          <div class="d-flex align-items-center justify-content-between gap-2 mb-2 flex-wrap">
            <div class="d-flex align-items-center gap-2">
              <span class="civic-badge civic-badge-accent">{{ $a->category }}</span>
              @if($a->is_important)
                <span class="civic-badge civic-badge-urgent">PENTING</span>
              @endif
            </div>
            <time class="small font-monospace text-muted">{{ $a->published_at?->translatedFormat('d M Y') ?? 'Baru saja' }}</time>
          </div>
          <h3 class="h5 mb-2 fw-bold" style="color: var(--color-text-main);">{{ $a->title }}</h3>
          <p class="text-muted mb-0" style="font-size: 0.925rem; line-height: 1.55;">
            {{ \Illuminate\Support\Str::limit($a->content, 140) }}
          </p>
        </article>
      @empty
        <div class="civic-card p-4 text-center text-muted">
          Belum ada pengumuman yang diterbitkan saat ini.
        </div>
      @endforelse

      <div>
        <a href="/announcements" class="btn-civic btn-civic-subtle btn-civic-sm">
          Semua Pengumuman Lingkungan →
        </a>
      </div>
    </div>
  </div>

  <!-- Right Column: Agenda & Schedules -->
  <div class="col-lg-5">
    <div class="civic-section-header">
      <span class="civic-eyebrow">AGENDA WILAYAH</span>
      <h2 class="h4 mb-0">Jadwal Terdekat</h2>
    </div>

    <div class="d-flex flex-column gap-3">
      @forelse($schedules as $s)
        <div class="civic-card p-3">
          <div class="d-flex gap-3 align-items-start">
            <div class="text-center p-2 rounded" style="background: var(--color-surface-subtle); border: 1px solid var(--color-border-subtle); min-width: 3.5rem;">
              <div class="small fw-bold text-uppercase font-monospace" style="color: var(--color-accent);">{{ $s->date->translatedFormat('M') }}</div>
              <div class="h4 mb-0 fw-bold">{{ $s->date->translatedFormat('d') }}</div>
            </div>
            <div class="flex-grow-1 min-w-0">
              <div class="d-flex align-items-center gap-2 mb-1">
                <span class="civic-badge civic-badge-neutral">{{ $s->category }}</span>
                @if($s->status === 'cancelled')
                  <span class="civic-badge civic-badge-caution">Dibatalkan</span>
                @endif
              </div>
              <h4 class="h6 fw-bold mb-1" style="color: var(--color-text-main);">{{ $s->title }}</h4>
              <div class="small text-muted font-monospace">
                🕒 {{ substr($s->start_time, 0, 5) }} WIB · 📍 {{ $s->location }}
              </div>
            </div>
          </div>
        </div>
      @empty
        <div class="civic-card p-4 text-center text-muted">
          Belum ada jadwal kegiatan terdaftar.
        </div>
      @endforelse

      <div>
        <a href="/schedules" class="btn-civic btn-civic-subtle btn-civic-sm">
          Kalender Agenda Lengkap →
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Local Business Registry (Pasar Warga) -->
<section class="mb-5">
  <div class="civic-section-header">
    <span class="civic-eyebrow">EKONOMI LOKAL</span>
    <div class="d-flex justify-content-between align-items-baseline flex-wrap gap-2">
      <h2 class="h4 mb-0">Direktori Usaha Warga</h2>
      <a href="/businesses" class="small text-decoration-none fw-semibold" style="color: var(--color-accent);">Lihat semua unit usaha →</a>
    </div>
  </div>

  <div class="row g-3">
    @forelse($businesses->take(6) as $b)
      <div class="col-md-6 col-lg-4">
        <div class="civic-card p-3 h-100 d-flex flex-column justify-content-between">
          <div>
            <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
              <h3 class="h6 fw-bold mb-0" style="color: var(--color-text-main);">{{ $b->name }}</h3>
              <span class="civic-badge civic-badge-neutral">{{ $b->category }}</span>
            </div>
            @if($b->description)
              <p class="small text-muted mb-3">{{ \Illuminate\Support\Str::limit($b->description, 80) }}</p>
            @endif
          </div>
          <div class="pt-2 border-top" style="border-color: var(--color-border-subtle) !important;">
            <div class="small text-muted">
              @if($b->address)<div>📍 {{ $b->address }}</div>@endif
              @if($b->phone)<div>📞 <span class="font-monospace">{{ $b->phone }}</span></div>@endif
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <div class="civic-card p-4 text-center text-muted">
          Belum ada profil usaha warga yang didaftarkan.
        </div>
      </div>
    @endforelse
  </div>
</section>

<!-- Civic Participation Protocol -->
<section class="civic-card p-4 p-md-5">
  <div class="civic-section-header">
    <span class="civic-eyebrow">PANDUAN SISTEM</span>
    <h2 class="h4 mb-0">Alur Partisipasi & Pelaporan Warga</h2>
  </div>

  <div class="row g-4">
    @foreach([
      ['1', 'Akses Terbuka', 'Jadwal kerja bakti, posyandu, dan maklumat lingkungan dapat dibaca langsung oleh siapapun tanpa keharusan memiliki akun.'],
      ['2', 'Pendaftaran Warga', 'Cukup daftarkan nama dan kontak Anda untuk mengaktifkan akses penyampaian laporan kejadian atau usulan lingkungan.'],
      ['3', 'Pelaporan Presisi', 'Unggah kronologi singkat kejadian serta penanda titik lokasi langsung pada peta interaktif yang tersedia.'],
      ['4', 'Verifikasi Pengurus', 'Setiap laporan ditinjau oleh pengurus RT/RW sebelum diterbitkan menjadi Maklumat Darurat publik demi validitas kabar.']
    ] as [$num, $title, $desc])
      <div class="col-md-6 col-lg-3">
        <div class="d-flex flex-column h-100">
          <div class="font-monospace fw-bold mb-2" style="font-size: 1.15rem; color: var(--color-accent);">{{ $num }}.</div>
          <h3 class="h6 fw-bold mb-2">{{ $title }}</h3>
          <p class="small text-muted mb-0" style="line-height: 1.55;">{{ $desc }}</p>
        </div>
      </div>
    @endforeach
  </div>
</section>
@endsection
