@extends('layouts.app') @section('content')
<a href="/admin/reports">← Reports</a><h3>{{ $r->title }} <span class="badge bg-secondary">{{ $r->verification_status }}</span></h3>
<div class="card p-3 mb-3"><p>{{ $r->description }}</p>
<small class="text-muted">Reporter: {{ $r->user->name }} ({{ $r->user->email }}) · {{ $r->location }} · AI suggestion: {{ $r->category ?? 'unavailable' }} {{ $r->ai_severity }} — a suggestion, not confirmation.</small>
@if($r->image_path)<img src="{{ asset('storage/'.$r->image_path) }}" class="img-fluid mt-2" style="max-height:260px">@endif</div>
<form method="post" action="/admin/reports/{{ $r->id }}/status" class="card p-3 mb-3">@csrf @method('PATCH')
<div class="row g-2"><div class="col-md-3"><select name="status" class="form-select"><option>verified</option><option>rejected</option><option>resolved</option></select></div>
<div class="col-md-3"><select name="category" class="form-select"><option value="">Keep category</option>@foreach(\App\Services\AiClassificationService::CATEGORIES as $c)<option>{{ $c }}</option>@endforeach</select></div>
<div class="col-md-4"><input name="notes" class="form-control" placeholder="Review notes"></div><div class="col-md-2"><button class="btn btn-primary w-100">Save</button></div></div>
<small class="text-muted">Verified reports appear publicly under Emergency Alerts.</small></form>
<h6>History</h6>@foreach($r->logs as $l)<div class="small">{{ $l->created_at->format('d M H:i') }}: {{ $l->previous_status }} → {{ $l->new_status }} {{ $l->notes }}</div>@endforeach @endsection