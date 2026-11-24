@extends('layouts.app') @section('content')
@php $st = config('warganet.report_status'); $col = ['pending'=>'warning text-dark','verified'=>'success','rejected'=>'danger','resolved'=>'secondary']; $inc = config('warganet.incident'); @endphp
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2"><h3>Laporan Saya</h3><a class="btn btn-danger" href="/resident/reports/create">📢 Buat Laporan Baru</a></div>
<div class="row g-4 mt-1"><div class="col-lg-8">
@forelse($reports as $r)<div class="card p-3 mb-2"><div class="d-flex justify-content-between gap-2"><b>{{ $r->title }}</b><span class="badge bg-{{ $col[$r->verification_status] }}">{{ $st[$r->verification_status] }}</span></div>
<small class="text-muted">{{ $inc[$r->category] ?? 'Belum dikategorikan' }} · {{ $r->created_at->translatedFormat('d F Y H:i') }}</small></div>
@empty<div class="card p-4 text-center"><p class="mb-2">Anda belum pernah membuat laporan.</p><a class="btn btn-danger" href="/resident/reports/create">Buat laporan pertama</a></div>@endforelse</div>
<div class="col-lg-4"><h5>🔔 Pemberitahuan</h5>
@forelse($notes as $n)<div class="card p-3 mb-2"><b>{{ $n->title }}</b><small>{{ $n->message }}</small></div>
@empty<p class="text-muted">Belum ada pemberitahuan.</p>@endforelse</div></div>@endsection
