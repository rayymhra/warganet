@extends('layouts.app') @section('content')
<h3>📢 Pengumuman</h3>
<form class="mb-3"><input class="form-control" name="q" placeholder="Cari pengumuman..." value="{{ request('q') }}"></form>
@forelse($items as $a)<div class="card p-3 mb-2 {{ $a->is_important ? 'border-start border-danger border-4' : '' }}">
<div><b>{{ $a->title }}</b> @if($a->is_important)<span class="badge bg-danger">Penting</span>@endif</div>
<div class="text-muted small">{{ $a->category }} · {{ $a->published_at?->translatedFormat('d F Y') }}</div><div class="mt-1">{{ $a->content }}</div></div>
@empty<div class="alert alert-light">Belum ada pengumuman.</div>@endforelse @endsection
