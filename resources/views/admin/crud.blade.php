@extends('layouts.app') @section('content')
<h3 class="text-capitalize">Manage {{ $res }}</h3><a href="/admin/dashboard">← Dashboard</a>
<form method="post" action="/admin/{{ $res }}" class="card p-3 my-3"><div class="row g-2">@csrf
@foreach($fields as $f)<div class="col-md-4"><label class="small text-muted">{{ str_replace('_',' ',$f) }}</label>
@if($f=='status')<select name="status" class="form-select">@foreach(['published','draft','cancelled','unpublished'] as $o)<option>{{ $o }}</option>@endforeach</select>
@elseif(in_array($f,['description','content','address','operating_hours']))<textarea name="{{ $f }}" class="form-control" rows="2"></textarea>
@else<input name="{{ $f }}" type="{{ $f=='date'?'date':(str_contains($f,'time')?'time':'text') }}" class="form-control">@endif</div>@endforeach
@if($res=='announcements')<div class="col-12"><label><input type="checkbox" name="is_important" value="1"> Mark important</label></div>@endif</div>
<button class="btn btn-primary mt-3">Add</button></form>
<table class="table bg-white"><tbody>@foreach($rows as $r)<tr><td>{{ $r->title ?? $r->name }}</td><td>{{ $r->category }}</td><td>{{ $r->status }}</td>
<td><form method="post" action="/admin/{{ $res }}/{{ $r->id }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form></td></tr>@endforeach</tbody></table>@endsection