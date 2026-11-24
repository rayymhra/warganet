@extends('layouts.app') @section('content')
<h3>Report an Incident</h3>
<p class="text-muted">Reports are reviewed by an administrator before becoming public. In a life-threatening emergency, call local emergency services first.</p>
<form method="post" action="/resident/reports" enctype="multipart/form-data" class="card p-4">@csrf
<input class="form-control mb-2" name="title" placeholder="Incident title" value="{{ old('title') }}" required>
<textarea class="form-control mb-2" name="description" rows="4" placeholder="What happened?" required>{{ old('description') }}</textarea>
<div class="row g-2 mb-2"><div class="col-md-6"><input class="form-control" name="location" placeholder="Location (e.g. RT 02 RW 03)" value="{{ old('location') }}" required></div>
<div class="col-md-3"><select class="form-select" name="category"><option value="">Category (auto)</option>@foreach(\App\Services\AiClassificationService::CATEGORIES as $c)<option value="{{ $c }}">{{ str_replace('_',' ',$c) }}</option>@endforeach</select></div>
<div class="col-md-3"><input class="form-control" type="datetime-local" name="occurred_at"></div></div>
<label class="small text-muted">Click the map to pin the location (optional)</label><div id="map" class="mb-2"></div>
<input type="hidden" name="latitude" id="lat"><input type="hidden" name="longitude" id="lng">
<input class="form-control mb-3" type="file" name="image" accept="image/*">
<button class="btn btn-primary">Submit report</button></form>@endsection
@push('js')<script>
const m=L.map('map').setView([-6.9,107.0],12);let pin;
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png',{attribution:'© OpenStreetMap'}).addTo(m);
m.on('click',e=>{pin?pin.setLatLng(e.latlng):pin=L.marker(e.latlng).addTo(m);lat.value=e.latlng.lat;lng.value=e.latlng.lng;});
</script>@endpush