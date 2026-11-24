@extends('layouts.app') @section('content')
<h3>Announcements</h3>
<form class="mb-3"><input class="form-control" name="q" placeholder="Search announcements" value="{{ request('q') }}"></form>
@forelse($items as $a)<div class="card p-3 mb-2 {{ $a->is_important ? 'border-start border-danger border-4' : '' }}">
<b>{{ $a->title }}</b> @if($a->is_important)<span class="badge bg-danger">Important</span>@endif
<div class="text-muted small">{{ $a->category }} · {{ $a->published_at?->format('d M Y') }}</div><div>{{ $a->content }}</div></div>
@empty<p class="text-muted">No announcements.</p>@endforelse @endsection