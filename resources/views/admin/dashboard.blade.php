@extends('layouts.app') @section('content')
<h3>Admin Dashboard</h3>
<div class="mb-3"><a class="btn btn-sm btn-outline-primary" href="/admin/reports">Reports</a> <a class="btn btn-sm btn-outline-primary" href="/admin/schedules">Schedules</a>
<a class="btn btn-sm btn-outline-primary" href="/admin/announcements">Announcements</a> <a class="btn btn-sm btn-outline-primary" href="/admin/businesses">Businesses</a> <a class="btn btn-sm btn-outline-primary" href="/admin/external-alerts">External alerts</a></div>
<div class="row g-3 mb-4">@foreach($stats as $k=>$v)<div class="col-6 col-md"><div class="card p-3 text-center"><div class="fs-2 fw-bold text-primary">{{ $v }}</div><small>{{ $k }}</small></div></div>@endforeach</div>
<h5>Latest reports</h5>
@foreach($latest as $r)<a href="/admin/reports/{{ $r->id }}" class="card p-3 mb-2 text-decoration-none text-dark">{{ $r->title }} <small class="text-muted">{{ $r->verification_status }} · {{ $r->user->name }}</small></a>@endforeach @endsection