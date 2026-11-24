@extends('layouts.app') @section('content')
<h3>Incident Reports</h3>
<div class="mb-3"><a href="/admin/reports">All</a> · @foreach(['pending','verified','rejected','resolved'] as $s)<a href="/admin/reports?status={{ $s }}">{{ $s }}</a> · @endforeach</div>
<table class="table bg-white"><thead><tr><th>Title</th><th>Category (AI)</th><th>Status</th><th>By</th><th></th></tr></thead><tbody>
@foreach($items as $r)<tr><td>{{ $r->title }}</td><td>{{ $r->category ?? '—' }} @if($r->ai_confidence)<small class="text-muted">({{ round($r->ai_confidence*100) }}%)</small>@endif</td><td>{{ $r->verification_status }}</td><td>{{ $r->user->name }}</td><td><a href="/admin/reports/{{ $r->id }}">Review</a></td></tr>@endforeach</tbody></table>@endsection