@extends('layouts.app') @section('content')
<div class="card mx-auto p-4" style="max-width:420px"><h4>Register</h4>
<form method="post" action="/register">@csrf
<input class="form-control mb-2" name="name" placeholder="Full name" value="{{ old('name') }}" required>
<input class="form-control mb-2" name="email" type="email" placeholder="Email" value="{{ old('email') }}" required>
<input class="form-control mb-2" name="phone" placeholder="Phone (optional)">
<input class="form-control mb-2" name="password" type="password" placeholder="Password (min 8)" required>
<input class="form-control mb-3" name="password_confirmation" type="password" placeholder="Confirm password" required>
<button class="btn btn-primary w-100">Register</button></form></div>@endsection