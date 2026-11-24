@extends('layouts.app') @section('content')
<div class="card mx-auto p-4" style="max-width:420px"><h4>Login</h4>
<form method="post" action="/login">@csrf
<input class="form-control mb-2" name="email" type="email" placeholder="Email" value="{{ old('email') }}" required>
<input class="form-control mb-3" name="password" type="password" placeholder="Password" required>
<button class="btn btn-primary w-100">Login</button></form>
<a class="small mt-3" href="/register">Create a resident account</a></div>@endsection