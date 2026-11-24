@extends('layouts.app') @section('content')
<h3>📅 Jadwal Kegiatan</h3><p class="text-muted">Jadwal kegiatan dan layanan di lingkungan kita.</p>
<form class="row g-2 mb-3"><div class="col-md-6"><input class="form-control" name="q" placeholder="Cari jadwal atau tempat..." value="{{ request('q') }}"></div>
<div class="col-md-4"><select class="form-select" name="category"><option value="">Semua kategori</option>@foreach(config('warganet.schedule_categories') as $c)<option @selected(request('category')==$c)>{{ $c }}</option>@endforeach</select></div>
<div class="col-md-2"><button class="btn btn-primary w-100">Cari</button></div></form>
@forelse($items as $s)<div class="card p-3 mb-2"><div class="d-flex justify-content-between"><b>{{ $s->title }}</b>
<span class="badge bg-{{ $s->status=='cancelled' ? 'warning text-dark' : 'primary' }}">{{ $s->status=='cancelled' ? 'Dibatalkan' : $s->category }}</span></div>
<div class="text-muted">🗓 {{ $s->date->translatedFormat('l, d F Y') }} · 🕒 {{ substr($s->start_time,0,5) }}{{ $s->end_time ? ' – '.substr($s->end_time,0,5) : '' }} · 📍 {{ $s->location }}</div>
@if($s->description)<div class="mt-1">{{ $s->description }}</div>@endif</div>
@empty<div class="alert alert-light">Belum ada jadwal yang cocok.</div>@endforelse @endsection
