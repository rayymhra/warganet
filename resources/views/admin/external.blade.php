@extends('layouts.app') @section('content')
<h3>Informasi Resmi (BMKG)</h3><p class="text-muted">Data otomatis dari instansi resmi. Tidak diperiksa oleh admin RT/RW.</p>
<div class="table-responsive"><table class="table bg-white"><thead><tr><th>Sumber</th><th>Judul</th><th>Wilayah</th><th>Terbit</th><th>Diambil</th><th>Status</th></tr></thead><tbody>
@forelse($items as $e)<tr><td><a href="{{ $e->source_url }}" target="_blank" rel="noopener">{{ $e->source_name }}</a></td><td>{{ $e->title }}</td><td>{{ $e->location }}</td><td>{{ $e->published_at }}</td><td>{{ $e->fetched_at }}</td><td>{{ $e->isStale() ? 'Sudah lama' : 'Terbaru' }}</td></tr>
@empty<tr><td colspan="6" class="text-muted">Belum ada data.</td></tr>@endforelse</tbody></table></div>@endsection
