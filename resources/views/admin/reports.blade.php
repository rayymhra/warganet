@extends('layouts.app') @section('content')
@php $st = config('warganet.report_status'); $inc = config('warganet.incident'); @endphp
<h3>Laporan Warga</h3>
<div class="mb-3 d-flex gap-2 flex-wrap"><a class="btn btn-sm {{ request('status') ? 'btn-outline-secondary' : 'btn-primary' }}" href="/admin/reports">Semua</a>
@foreach($st as $k=>$v)<a class="btn btn-sm {{ request('status')==$k ? 'btn-primary' : 'btn-outline-secondary' }}" href="/admin/reports?status={{ $k }}">{{ $v }}</a>@endforeach</div>
<div class="table-responsive"><table class="table bg-white align-middle"><thead><tr><th>Judul</th><th>Kategori (saran AI)</th><th>Status</th><th>Pelapor</th><th></th></tr></thead><tbody>
@forelse($items as $r)<tr><td>{{ $r->title }}</td><td>{{ $inc[$r->category] ?? '—' }} @if($r->ai_confidence)<small class="text-muted">({{ round($r->ai_confidence*100) }}%)</small>@endif</td>
<td>{{ $st[$r->verification_status] }}</td><td>{{ $r->user->name }}</td><td><a class="btn btn-sm btn-primary" href="/admin/reports/{{ $r->id }}">Periksa</a></td></tr>
@empty<tr><td colspan="5" class="text-muted">Tidak ada laporan.</td></tr>@endforelse</tbody></table></div>@endsection
