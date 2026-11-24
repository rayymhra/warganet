@extends('layouts.app') @section('content')
<h3>Kelola {{ $title }}</h3>
<form method="post" action="/admin/{{ $res }}" class="card p-4 my-3"><h5>Tambah {{ $title }} baru</h5><div class="row g-3">@csrf
@foreach($fields as $name => [$label, $rule, $type])<div class="col-md-6"><label class="form-label">{{ $label }}</label>
@if($type==='textarea')<textarea name="{{ $name }}" class="form-control" rows="2" @required(str_contains($rule,'required'))>{{ old($name) }}</textarea>
@else<input name="{{ $name }}" type="{{ $type }}" class="form-control" value="{{ old($name) }}" @required(str_contains($rule,'required'))>@endif</div>@endforeach
<div class="col-md-6"><label class="form-label">Kategori</label><select name="category" class="form-select" required><option value="">— pilih kategori —</option>@foreach($cats as $c)<option @selected(old('category')==$c)>{{ $c }}</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">Status</label><select name="status" class="form-select">@foreach($statuses as $k=>$v)<option value="{{ $k }}">{{ $v }}</option>@endforeach</select></div>
@if($res==='announcements')<div class="col-12"><label><input type="checkbox" name="is_important" value="1"> ⭐ Tandai sebagai pengumuman penting</label></div>@endif</div>
<button class="btn btn-primary mt-3 align-self-start">Simpan</button></form>
<div class="table-responsive"><table class="table bg-white align-middle"><thead><tr><th>Nama</th><th>Kategori</th><th>Status</th><th></th></tr></thead><tbody>
@forelse($rows as $r)<tr><td>{{ $r->title ?? $r->name }}</td><td>{{ $r->category }}</td><td>{{ $statuses[$r->status] ?? $r->status }}</td>
<td><form method="post" action="/admin/{{ $res }}/{{ $r->id }}" onsubmit="return confirm('Yakin ingin menghapus?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Hapus</button></form></td></tr>
@empty<tr><td colspan="4" class="text-muted">Belum ada data.</td></tr>@endforelse</tbody></table></div>@endsection
