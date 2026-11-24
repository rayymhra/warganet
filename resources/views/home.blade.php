@extends('layouts.app') @section('content')
@php $u = auth()->user(); $inc = config('warganet.incident'); @endphp
<div class="hero rounded-4 p-4 p-md-5 mb-4">
<h1 class="fw-bold">Kampung Kita, Terhubung.</h1>
<p class="lead mb-4">Lihat jadwal kegiatan, baca pengumuman, dan laporkan kejadian di sekitar Anda — semua di satu tempat.</p>
<a href="/schedules" class="btn btn-light btn-lg me-2 mb-2">📅 Lihat Jadwal</a>
@guest <a href="/register" class="btn btn-outline-light btn-lg mb-2">Daftar untuk Melapor</a>
@elseif($u->role === 'resident') <a href="/resident/reports/create" class="btn btn-danger btn-lg mb-2">📢 Buat Laporan</a>
@else <a href="/admin/dashboard" class="btn btn-outline-light btn-lg mb-2">⚙️ Buka Panel Admin</a> @endguest
</div>

@if($alerts->count())<div class="alert alert-danger"><b>🚨 Ada info darurat terverifikasi.</b> <a href="/emergency-alerts" class="alert-link">Lihat sekarang</a></div>@endif

<div class="card p-4 mb-4"><h4 class="mb-3">Cara memakai WargaNet</h4><div class="row g-3">
@foreach([['Lihat informasi','Jadwal dan pengumuman bisa dibaca siapa saja, tanpa daftar.'],
          ['Daftar / Masuk','Klik tombol Daftar. Cukup nama, email, dan kata sandi.'],
          ['Laporkan kejadian','Klik "Buat Laporan", tulis kejadian, lalu pilih tempatnya di peta.'],
          ['Admin memeriksa','Laporan diperiksa admin. Jika benar, tampil di menu Info Darurat.']] as $i => [$t, $d])
<div class="col-md-6 col-lg-3 d-flex gap-3"><div class="step-no">{{ $i + 1 }}</div><div><b>{{ $t }}</b><div class="text-muted small">{{ $d }}</div></div></div>@endforeach
</div></div>

<div class="row g-4">
<div class="col-lg-4"><h5>📅 Jadwal Terdekat</h5>
@forelse($schedules as $s)<div class="card p-3 mb-2"><b>{{ $s->title }}</b><small class="text-muted">{{ $s->date->translatedFormat('l, d F') }} · {{ substr($s->start_time,0,5) }} · {{ $s->location }}</small></div>
@empty<p class="text-muted">Belum ada jadwal.</p>@endforelse<a href="/schedules">Lihat semua jadwal →</a></div>
<div class="col-lg-4"><h5>📢 Pengumuman Terbaru</h5>
@forelse($announcements as $a)<div class="card p-3 mb-2"><b>{{ $a->title }} @if($a->is_important)<span class="badge bg-danger">Penting</span>@endif</b><small class="text-muted">{{ \Illuminate\Support\Str::limit($a->content, 80) }}</small></div>
@empty<p class="text-muted">Belum ada pengumuman.</p>@endforelse<a href="/announcements">Lihat semua pengumuman →</a></div>
<div class="col-lg-4"><h5>🚨 Info Darurat</h5>
@forelse($alerts as $x)<div class="card p-3 mb-2 border-start border-danger border-4"><b>{{ $x->title }}</b><small class="text-muted">{{ $inc[$x->category] ?? 'Lainnya' }} · {{ $x->location }}</small><span class="badge bg-success align-self-start mt-1">Sudah diperiksa admin</span></div>
@empty<p class="text-muted">Tidak ada info darurat saat ini.</p>@endforelse<a href="/emergency-alerts">Lihat semua →</a></div></div>
<h5 class="mt-4">🛒 Usaha Warga</h5><div class="row g-3">@foreach($businesses as $b)<div class="col-md-4"><div class="card p-3"><b>{{ $b->name }}</b><small class="text-muted">{{ $b->category }} · {{ $b->phone }}</small></div></div>@endforeach</div>
@endsection
