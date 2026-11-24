@extends('layouts.app') @section('content')
<h3>Schedules</h3>
<form class="row g-2 mb-3"><div class="col-md-6"><input class="form-control" name="q" placeholder="Search" value="{{ request('q') }}"></div>
<div class="col-md-4"><select class="form-select" name="category"><option value="">All categories</option>@foreach($cats as $c)<option @selected(request('category')==$c)>{{ $c }}</option>@endforeach</select></div>
<div class="col-md-2"><button class="btn btn-primary w-100">Filter</button></div></form>
@forelse($items as $s)<div class="card p-3 mb-2"><div class="d-flex justify-content-between"><b>{{ $s->title }}</b><span class="badge bg-{{ $s->status=='cancelled'?'warning text-dark':'primary' }}">{{ $s->status }}</span></div>
<div class="text-muted small">{{ $s->category }} · {{ $s->date->format('D, d M Y') }} · {{ substr($s->start_time,0,5) }}{{ $s->end_time ? '–'.substr($s->end_time,0,5) : '' }} · {{ $s->location }}</div>
<div>{{ $s->description }}</div></div>
@empty<p class="text-muted">No schedules found.</p>@endforelse @endsection