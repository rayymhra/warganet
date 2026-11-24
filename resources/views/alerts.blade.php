@extends('layouts.app') @section('content')
<h3>Emergency Alerts</h3><div id="map" class="mb-4"></div>
<h5>Community alerts <span class="badge bg-success">Verified by administrator</span></h5>
@forelse($community as $r)<div class="card p-3 mb-2 border-start border-danger border-4"><b>{{ $r->title }}</b>
<div class="text-muted small">{{ str_replace('_',' ',$r->category) }} · {{ $r->location }} · {{ ($r->occurred_at ?? $r->created_at)->format('d M Y H:i') }} · Source: community report @if($r->ai_severity)· severity: {{ $r->ai_severity }}@endif</div>
<div>{{ $r->description }}</div></div>
@empty<p class="text-muted">No verified community alerts.</p>@endforelse

<h5 class="mt-4">Official external information <span class="badge bg-secondary">Not reviewed by neighborhood admins</span></h5>
@forelse($external as $e)<div class="card p-3 mb-2"><b>{{ $e->title }}</b>
<div class="text-muted small">Source: {{ $e->source_name }} · published {{ $e->published_at?->format('d M Y H:i') }} · last retrieved {{ $e->fetched_at->diffForHumans() }}
@if($e->isStale())<span class="badge bg-warning text-dark">Outdated — source may be unavailable</span>@endif</div>
<div>{{ $e->description }}</div>
@if($e->source_url)<a class="small" href="{{ $e->source_url }}" target="_blank" rel="noopener">Original source</a>@endif</div>
@empty<p class="text-muted">External data currently unavailable.</p>@endforelse
@endsection
@push('js')<script>
const m=L.map('map').setView([-6.9,107.0],11);
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png',{attribution:'© OpenStreetMap'}).addTo(m);
@foreach($community as $r) @if($r->latitude && $r->longitude)
L.marker([{{ $r->latitude }},{{ $r->longitude }}]).addTo(m).bindPopup(@json($r->title));
@endif @endforeach
</script>@endpush