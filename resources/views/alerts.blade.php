@extends('layouts.app') @section('content')
@php $inc = config('warganet.incident'); @endphp
<h3>🚨 Info Darurat</h3><div id="map" class="mb-4"></div>
<h5>Laporan warga <span class="badge bg-success">Sudah diperiksa admin</span></h5>
@forelse($community as $r)<div class="card p-3 mb-2 border-start border-danger border-4"><b>{{ $r->title }}</b>
<div class="text-muted small">{{ $inc[$r->category] ?? 'Lainnya' }} · 📍 {{ $r->location }} · {{ ($r->occurred_at ?? $r->created_at)->translatedFormat('d F Y H:i') }} · Sumber: laporan warga</div>
<div class="mt-1">{{ $r->description }}</div></div>
@empty<div class="alert alert-light">Belum ada laporan terverifikasi.</div>@endforelse

<h5 class="mt-4">Informasi resmi dari instansi <span class="badge bg-secondary">Bukan hasil pemeriksaan admin RT/RW</span></h5>
@forelse($external as $e)<div class="card p-3 mb-2"><b>{{ $e->title }}</b>
<div class="text-muted small">Sumber: {{ $e->source_name }} · terbit {{ $e->published_at?->translatedFormat('d F Y H:i') }} · diambil {{ $e->fetched_at->diffForHumans() }}
@if($e->isStale())<span class="badge bg-warning text-dark">Data mungkin sudah lama</span>@endif</div>
<div class="mt-1">{{ $e->description }}</div>@if($e->source_url)<a class="small" href="{{ $e->source_url }}" target="_blank" rel="noopener">Lihat sumber asli</a>@endif</div>
@empty<div class="alert alert-light">Informasi resmi sedang tidak tersedia.</div>@endforelse
@endsection
@push('js')<script>
const m=L.map('map').setView([-6.9,107.0],11);
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png',{attribution:'© OpenStreetMap'}).addTo(m);
@foreach($community as $r) @if($r->latitude && $r->longitude)
L.marker([{{ $r->latitude }},{{ $r->longitude }}]).addTo(m).bindPopup(@json($r->title));
@endif @endforeach
</script>@endpush
