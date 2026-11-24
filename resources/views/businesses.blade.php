@extends('layouts.app') @section('content')
<h3>Local Businesses</h3>
<form class="row g-2 mb-3"><div class="col-md-6"><input class="form-control" name="q" placeholder="Search" value="{{ request('q') }}"></div>
<div class="col-md-4"><select class="form-select" name="category"><option value="">All categories</option>@foreach($cats as $c)<option @selected(request('category')==$c)>{{ $c }}</option>@endforeach</select></div>
<div class="col-md-2"><button class="btn btn-primary w-100">Filter</button></div></form>
<div class="row g-3">@forelse($items as $b)<div class="col-md-4"><div class="card p-3 h-100"><b>{{ $b->name }}</b><span class="badge bg-info text-dark align-self-start">{{ $b->category }}</span>
<p class="mb-1">{{ $b->description }}</p><small class="text-muted">{{ $b->address }}<br>{{ $b->phone }}<br>{{ $b->operating_hours }}</small></div></div>
@empty<p class="text-muted">No businesses found.</p>@endforelse</div>@endsection