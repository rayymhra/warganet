@extends('layouts.app') @section('content')
@php $st = config('warganet.report_status'); $inc = config('warganet.incident'); @endphp
<a href="/admin/reports">← Kembali ke daftar</a>
<h3 class="mt-2">{{ $r->title }} <span class="badge bg-secondary fs-6">{{ $st[$r->verification_status] }}</span></h3>
<div class="card p-3 mb-3"><p>{{ $r->description }}</p>
<small class="text-muted">Pelapor: {{ $r->user->name }} ({{ $r->user->email }}) · 📍 {{ $r->location }}<br>
Kategori: {{ $inc[$r->category] ?? 'belum ada' }} @if($r->ai_severity)· tingkat: {{ $r->ai_severity }}@endif — <i>kategori dari AI hanya saran, bukan bukti kejadian.</i></small>
@if($r->image_path)<img src="{{ asset('storage/'.$r->image_path) }}" class="img-fluid rounded mt-2" style="max-height:260px">@endif</div>
<form method="post" action="/admin/reports/{{ $r->id }}/status" class="card p-3 mb-3">@csrf @method('PATCH')
<div class="row g-2"><div class="col-md-3"><label class="form-label">Keputusan</label><select name="status" class="form-select">
<option value="verified">✅ Benar (tampilkan ke warga)</option><option value="rejected">❌ Tolak</option><option value="resolved">☑️ Sudah selesai</option></select></div>
<div class="col-md-3"><label class="form-label">Ubah kategori</label><select name="category" class="form-select"><option value="">Biarkan</option>@foreach($inc as $k=>$v)<option value="{{ $k }}">{{ $v }}</option>@endforeach</select></div>
<div class="col-md-4"><label class="form-label">Catatan</label><input name="notes" class="form-control" placeholder="Opsional"></div>
<div class="col-md-2 d-flex align-items-end"><button class="btn btn-primary w-100">Simpan</button></div></div></form>
<h6>Riwayat</h6>@forelse($r->logs as $l)<div class="small">{{ $l->created_at->translatedFormat('d M H:i') }}: {{ $st[$l->previous_status] ?? '-' }} → {{ $st[$l->new_status] }} {{ $l->notes }}</div>@empty<div class="small text-muted">Belum ada.</div>@endforelse @endsection
