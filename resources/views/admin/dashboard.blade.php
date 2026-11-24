@extends('layouts.app') @section('content')
@php $col = ['pending'=>'warning text-dark','verified'=>'success','rejected'=>'danger','resolved'=>'secondary']; $st = config('warganet.report_status'); @endphp
<h3>Ringkasan</h3>
<div class="row g-3 mb-4">
@foreach(['Warga terdaftar'=>'Residents','Jadwal'=>'Schedules','Pengumuman'=>'Announcements','Laporan menunggu'=>'Pending reports','Info darurat aktif'=>'Verified / active alerts'] as $label=>$key)
<div class="col-6 col-md"><div class="card p-3 text-center"><div class="fs-1 fw-bold text-primary">{{ $stats[$key] }}</div><small>{{ $label }}</small></div></div>@endforeach</div>
<h5>Laporan terbaru</h5>
@forelse($latest as $r)<a href="/admin/reports/{{ $r->id }}" class="card p-3 mb-2 text-decoration-none text-dark"><div class="d-flex justify-content-between"><b>{{ $r->title }}</b><span class="badge bg-{{ $col[$r->verification_status] }}">{{ $st[$r->verification_status] }}</span></div><small class="text-muted">oleh {{ $r->user->name }} · {{ $r->created_at->diffForHumans() }}</small></a>
@empty<p class="text-muted">Belum ada laporan.</p>@endforelse @endsection
