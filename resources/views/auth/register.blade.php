@extends('layouts.app') @section('content')
<div class="card mx-auto p-4" style="max-width:440px"><h3>Daftar Akun Warga</h3>
<form method="post" action="/register">@csrf
<label class="form-label">Nama lengkap</label><input class="form-control mb-3" name="name" value="{{ old('name') }}" required>
<label class="form-label">Email</label><input class="form-control mb-3" name="email" type="email" value="{{ old('email') }}" required>
<label class="form-label">No. HP / WhatsApp <span class="text-muted">(boleh dikosongkan)</span></label><input class="form-control mb-3" name="phone" value="{{ old('phone') }}">
<label class="form-label">Kata sandi <span class="text-muted">(minimal 8 karakter)</span></label><input class="form-control mb-3" name="password" type="password" required>
<label class="form-label">Ulangi kata sandi</label><input class="form-control mb-3" name="password_confirmation" type="password" required>
<button class="btn btn-primary w-100 btn-lg">Daftar</button></form>
<p class="mt-3 mb-0">Sudah punya akun? <a href="/login">Masuk</a></p></div>@endsection
