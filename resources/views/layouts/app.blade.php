<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>WargaNet</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<style>:root{--bs-primary:#0f8b8d;--bs-primary-rgb:15,139,141}body{font-family:Inter,sans-serif;background:#f6f8f9}
.btn-primary{--bs-btn-bg:#0f8b8d;--bs-btn-border-color:#0f8b8d;--bs-btn-hover-bg:#0b6e70;--bs-btn-hover-border-color:#0b6e70}
.hero{background:linear-gradient(135deg,#0f8b8d,#2f6fb0);color:#fff}.card{border:0;box-shadow:0 1px 4px rgba(0,0,0,.08)}#map{height:340px;border-radius:.5rem}</style></head><body>
<nav class="navbar navbar-expand-lg bg-white shadow-sm"><div class="container">
<a class="navbar-brand fw-bold text-primary" href="/">WargaNet</a>
<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nv"><span class="navbar-toggler-icon"></span></button>
<div class="collapse navbar-collapse" id="nv"><ul class="navbar-nav me-auto">
<li class="nav-item"><a class="nav-link" href="/schedules">Schedules</a></li>
<li class="nav-item"><a class="nav-link" href="/announcements">Announcements</a></li>
<li class="nav-item"><a class="nav-link" href="/emergency-alerts">Emergency Alerts</a></li>
<li class="nav-item"><a class="nav-link" href="/businesses">Local Businesses</a></li></ul>
@auth
<a class="btn btn-sm btn-outline-primary me-2" href="{{ auth()->user()->role=='admin' ? '/admin/dashboard' : '/resident/dashboard' }}">{{ auth()->user()->name }}</a>
<form method="post" action="/logout">@csrf<button class="btn btn-sm btn-light">Logout</button></form>
@else <a class="btn btn-sm btn-primary" href="/login">Login</a> @endauth
</div></div></nav>
<main class="container py-4">
@if(session('ok'))<div class="alert alert-success">{{ session('ok') }}</div>@endif
@if($errors->any())<div class="alert alert-danger">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif
@yield('content')</main>
<footer class="text-center text-muted small py-4">WargaNet — reports are reviewed by administrators; AI categories are suggestions only. Your identity is never shown on public alerts.</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@stack('js')</body></html>