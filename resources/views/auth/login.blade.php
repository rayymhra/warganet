{{-- Hallmark · macrostructure: Focused Civic Access Card · theme: WargaNet Pastel Blue · genre: playful --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-4">
  <div class="col-md-7 col-lg-5">
    <div class="app-card p-4 p-md-5 text-center">
      
      <!-- Mascot Greeting with Fallback -->
      <img src="{{ asset('images/cat-waving.png') }}" 
           onerror="this.onerror=null;this.src='{{ asset('images/cat-peeking.png') }}';" 
           alt="Mascot WargaNet" 
           style="height: 80px; width: auto; margin-bottom: 0.75rem;">

      <h1 class="h4 fw-bold mb-1 text-dark">Masuk ke WargaNet</h1>
      <p class="small text-muted mb-4">Masuk untuk menyampaikan laporan dan memantau lingkungan.</p>

      <form method="post" action="/login" class="text-start">
        @csrf
        <div class="mb-3">
          <label class="form-label fw-bold small text-dark" for="email">Alamat Email</label>
          <input id="email" class="form-control-pill" name="email" type="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
        </div>

        <div class="mb-4">
          <label class="form-label fw-bold small text-dark" for="password">Kata Sandi</label>
          <input id="password" class="form-control-pill" name="password" type="password" required placeholder="••••••••">
        </div>

        <button type="submit" class="btn-pill btn-pill-primary w-100 py-2">
          Masuk ke Akun
        </button>
      </form>

      <div class="pt-3 mt-4 border-top text-center small text-muted" style="border-color: var(--color-border-card) !important;">
        Belum punya akun warga? <a href="/register" class="fw-bold text-decoration-none" style="color: var(--color-accent);">Daftar di sini</a>
      </div>
    </div>
  </div>
</div>
@endsection
