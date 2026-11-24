@extends('layouts.app') @section('content')
<div class="d-flex justify-content-between"><h3>My Dashboard</h3><a class="btn btn-primary" href="/resident/reports/create">+ New report</a></div>
<div class="row g-4 mt-1"><div class="col-md-8"><h5>My reports</h5>
@forelse($reports as $r)<div class="card p-3 mb-2"><div class="d-flex justify-content-between"><b>{{ $r->title }}</b>
<span class="badge bg-{{ ['pending'=>'warning text-dark','verified'=>'success','rejected'=>'danger','resolved'=>'secondary'][$r->verification_status] }}">{{ $r->verification_status }}</span></div>
<small class="text-muted">{{ $r->category ?? 'uncategorized' }} · {{ $r->created_at->format('d M Y H:i') }}</small></div>
@empty<p class="text-muted">No reports yet.</p>@endforelse</div>
<div class="col-md-4"><h5>Notifications</h5>
@forelse($notes as $n)<div class="card p-2 mb-2 small"><b>{{ $n->title }}</b>{{ $n->message }}</div>
@empty<p class="text-muted">Nothing new.</p>@endforelse</div></div>@endsection