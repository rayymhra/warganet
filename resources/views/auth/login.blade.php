{{-- Hallmark · macrostructure: Focused Civic Access Card · theme: Nusantara Civic · genre: editorial --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-4">
  <div class="col-md-7 col-lg-5">
    <div class="civic-card p-4 p-md-5">
      <div class="civic-section-header text-center mb-4">
        <span class="civic-eyebrow">AKSES WARGA & PENGURUS</span>
        <h1 class="h4 mb-1">Masuk ke WargaNet</h1>
        <p class="text-muted small mb-0">Masuk untuk menyampaikan laporan kejadian atau mengelola data lingkungan.</p>
      </div>

      <form method="post" action="/login">
        @csrf
        <div class="mb-3">
          <label class="civic-label" for="email">Alamat Email</label>
          <input id="email" class="civic-input" name="email" type="email" value="{{ old('email') }}" required autofocus placeholder="nama@domain.id">
        </div>

        <div class="mb-4">
          <label class="civic-label" for="password">Kata Sandi</label>
          <input id="password" class="civic-input" name="password" type="password" required placeholder="••••••••">
        </div>

        <button type="submit" class="btn-civic btn-civic-primary w-100 py-2">
          Masuk ke Akun
        </button>
      </form>

      <div class="pt-4 mt-4 border-top text-center small text-muted" style="border-color: var(--color-border-subtle) !important;">
        Belum terdaftar sebagai warga? <a href="/register" class="fw-semibold text-decoration-none" style="color: var(--color-accent);">Daftar di sini</a>
      </div>
    </div>
  </div>
</div>
@endsection
