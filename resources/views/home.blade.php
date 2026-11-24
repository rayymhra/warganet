@extends('layouts.app') @section('content')
<div class="hero rounded-4 p-5 mb-4"><h1 class="fw-bold">Your Neighborhood, Connected.</h1>
<p class="lead">Schedules, announcements, verified alerts and local businesses in one place.</p>
<a href="/schedules" class="btn btn-light me-2">Explore Neighborhood Information</a>
<a href="/resident/reports/create" class="btn btn-outline-light">Report an Incident</a></div>
<div class="row g-4">
<div class="col-md-4"><h5>Upcoming Schedules</h5>
@forelse($schedules as $s)<div class="card p-3 mb-2"><b>{{ $s->title }}</b><small>{{ $s->date->format('D, d M') }} {{ substr($s->start_time,0,5) }} · {{ $s->location }}</small></div>
@empty<p class="text-muted">None scheduled.</p>@endforelse</div>
<div class="col-md-4"><h5>Latest Announcements</h5>
@forelse($announcements as $a)<div class="card p-3 mb-2"><b>{{ $a->title }}</b>@if($a->is_important)<span class="badge bg-danger align-self-start">Important</span>@endif<small>{{ \Illuminate\Support\Str::limit($a->content,80) }}</small></div>
@empty<p class="text-muted">None yet.</p>@endforelse</div>
<div class="col-md-4"><h5>Verified Alerts</h5>
@forelse($alerts as $x)<div class="card p-3 mb-2"><b>{{ $x->title }}</b><small>{{ $x->category }} · {{ $x->location }}</small><span class="badge bg-success align-self-start">Verified by admin</span></div>
@empty<p class="text-muted">No active verified alerts.</p>@endforelse</div></div>
<h5 class="mt-4">Local Businesses</h5>
<div class="row g-3">@foreach($businesses as $b)<div class="col-md-4"><div class="card p-3"><b>{{ $b->name }}</b><small class="text-muted">{{ $b->category }} · {{ $b->phone }}</small></div></div>@endforeach</div>
@endsection