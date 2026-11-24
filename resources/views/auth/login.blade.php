@extends('layouts.app') @section('content')
<div class="card mx-auto p-4" style="max-width:440px"><h3>Masuk</h3><p class="text-muted">Masuk untuk membuat laporan atau mengelola informasi.</p>
<form method="post" action="/login">@csrf
<label class="form-label">Email</label><input class="form-control mb-3" name="email" type="email" value="{{ old('email') }}" required>
<label class="form-label">Kata sandi</label><input class="form-control mb-3" name="password" type="password" required>
<button class="btn btn-primary w-100 btn-lg">Masuk</button></form>
<p class="mt-3 mb-0">Belum punya akun? <a href="/register">Daftar di sini</a></p></div>@endsection
