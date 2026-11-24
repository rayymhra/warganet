<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>WargaNet — Kampung Kita, Terhubung</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<style>
:root{--bs-primary:#0f8b8d;--bs-primary-rgb:15,139,141}
body{font-family:Inter,sans-serif;background:#f4f7f8;font-size:1.05rem}
.btn-primary{--bs-btn-bg:#0f8b8d;--bs-btn-border-color:#0f8b8d;--bs-btn-hover-bg:#0b6e70;--bs-btn-hover-border-color:#0b6e70}
.btn{padding:.55rem 1rem;border-radius:.6rem}.form-control,.form-select{padding:.65rem .8rem}
.hero{background:linear-gradient(135deg,#0f8b8d,#2f6fb0);color:#fff}
.card{border:0;border-radius:1rem;box-shadow:0 2px 8px rgba(0,0,0,.06)}
.step-no{width:2.4rem;height:2.4rem;border-radius:50%;background:#0f8b8d;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;flex:none}
#map{height:340px;border-radius:.8rem}.nav-link.active{color:#0f8b8d!important;font-weight:600}
</style></head><body>
@php $u = auth()->user(); @endphp
<nav class="navbar navbar-expand-lg bg-white shadow-sm"><div class="container">
<a class="navbar-brand fw-bold text-primary fs-4" href="/">🏘️ WargaNet</a>
<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nv"><span class="navbar-toggler-icon"></span></button>
<div class="collapse navbar-collapse" id="nv">
<ul class="navbar-nav me-auto">
<li class="nav-item"><a class="nav-link {{ request()->is('schedules') ? 'active' : '' }}" href="/schedules">📅 Jadwal</a></li>
<li class="nav-item"><a class="nav-link {{ request()->is('announcements') ? 'active' : '' }}" href="/announcements">📢 Pengumuman</a></li>
<li class="nav-item"><a class="nav-link {{ request()->is('emergency-alerts') ? 'active' : '' }}" href="/emergency-alerts">🚨 Info Darurat</a></li>
<li class="nav-item"><a class="nav-link {{ request()->is('businesses') ? 'active' : '' }}" href="/businesses">🛒 Usaha Warga</a></li></ul>
<div class="d-flex gap-2 align-items-center flex-wrap">
@guest
<a class="btn btn-outline-primary" href="/login">Masuk</a><a class="btn btn-primary" href="/register">Daftar</a>
@else
@if($u->role === 'resident')
<a class="btn btn-danger" href="/resident/reports/create">📢 Buat Laporan</a><a class="btn btn-outline-primary" href="/resident/dashboard">Laporan Saya</a>
@else
<a class="btn btn-primary" href="/admin/dashboard">⚙️ Panel Admin</a>
@endif
<form method="post" action="/logout">@csrf<button class="btn btn-light">Keluar</button></form>
@endguest
</div></div></div></nav>
@if($u && $u->role === 'admin' && request()->is('admin/*'))
<div class="bg-white border-bottom"><div class="container py-2 d-flex gap-2 flex-wrap">
@foreach(['dashboard'=>'🏠 Ringkasan','reports'=>'📋 Laporan Warga','schedules'=>'📅 Jadwal','announcements'=>'📢 Pengumuman','businesses'=>'🛒 Usaha','external-alerts'=>'🌐 Info Resmi'] as $p=>$l)
<a href="/admin/{{ $p }}" class="btn btn-sm {{ request()->is("admin/$p*") ? 'btn-primary' : 'btn-outline-secondary' }}">{{ $l }}</a>@endforeach
</div></div>@endif
<main class="container py-4">
@if(session('ok'))<div class="alert alert-success">✅ {{ session('ok') }}</div>@endif
@if($errors->any())<div class="alert alert-danger"><b>Mohon periksa isian Anda:</b>@foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach</div>@endif
@yield('content')</main>
<footer class="text-center text-muted small py-4 px-3">WargaNet · Laporan diperiksa admin sebelum ditampilkan · Kategori dari AI hanya saran · Nama pelapor tidak ditampilkan ke publik.<br>Keadaan darurat? Segera hubungi <b>112</b>.</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@stack('js')</body></html>
