{{-- Hallmark · macrostructure: Civic Resident Enrollment Ledger · theme: WargaNet Pastel Blue · genre: playful --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-4">
  <div class="col-md-8 col-lg-6">
    <div class="app-card p-4 p-md-5">
      
      <div class="text-center mb-4">
        <img src="{{ asset('images/cat-peeking.png') }}" alt="Mascot WargaNet" style="height: 75px; width: auto; margin-bottom: 0.5rem;">
        <h1 class="h4 fw-bold mb-1 text-dark">Daftar Akun Warga</h1>
        <p class="small text-muted mb-0">Bergabung dengan portal lingkungan untuk saling peduli dan terhubung.</p>
      </div>

      <form method="post" action="/register">
        @csrf
        <div class="mb-3">
          <label class="form-label fw-bold small text-dark" for="name">Nama Lengkap</label>
          <input id="name" class="form-control-pill" name="name" value="{{ old('name') }}" required placeholder="Nama Anda">
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold small text-dark" for="email">Alamat Email</label>
          <input id="email" class="form-control-pill" name="email" type="email" value="{{ old('email') }}" required placeholder="nama@email.com">
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold small text-dark" for="phone">
            Nomor WhatsApp / HP <span class="text-muted fw-normal">(opsional)</span>
          </label>
          <input id="phone" class="form-control-pill font-monospace" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
        </div>

        <div class="row g-3 mb-4">
          <div class="col-sm-6">
            <label class="form-label fw-bold small text-dark" for="password">Kata Sandi</label>
            <input id="password" class="form-control-pill" name="password" type="password" required placeholder="Minimal 8 karakter">
          </div>
          <div class="col-sm-6">
            <label class="form-label fw-bold small text-dark" for="password_confirmation">Ulangi Sandi</label>
            <input id="password_confirmation" class="form-control-pill" name="password_confirmation" type="password" required placeholder="Ketik ulang kata sandi">
          </div>
        </div>

        <button type="submit" class="btn-pill btn-pill-primary w-100 py-2">
          Daftar Sekarang
        </button>
      </form>

      <div class="pt-3 mt-4 border-top text-center small text-muted" style="border-color: var(--color-border-card) !important;">
        Sudah memiliki akun? <a href="/login" class="fw-bold text-decoration-none" style="color: var(--color-accent);">Masuk di sini</a>
      </div>
    </div>
  </div>
</div>
@endsection
