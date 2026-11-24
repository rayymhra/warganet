{{-- Hallmark · macrostructure: Civic Resident Enrollment Ledger · theme: Nusantara Civic · genre: editorial --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-4">
  <div class="col-md-8 col-lg-6">
    <div class="civic-card p-4 p-md-5">
      <div class="civic-section-header text-center mb-4">
        <span class="civic-eyebrow">REGISTRASI WARGA</span>
        <h1 class="h4 mb-1">Pendaftaran Akun Warga</h1>
        <p class="text-muted small mb-0">Lengkapi data diri untuk berpartisipasi dalam pelaporan dan koordinasi lingkungan.</p>
      </div>

      <form method="post" action="/register">
        @csrf
        <div class="mb-3">
          <label class="civic-label" for="name">Nama Lengkap Sesuai KTP</label>
          <input id="name" class="civic-input" name="name" value="{{ old('name') }}" required placeholder="Contoh: Budi Santoso">
        </div>

        <div class="mb-3">
          <label class="civic-label" for="email">Alamat Email Aktif</label>
          <input id="email" class="civic-input" name="email" type="email" value="{{ old('email') }}" required placeholder="budi@email.com">
          <div class="civic-helper">Email digunakan untuk pemberitahuan status verifikasi laporan Anda.</div>
        </div>

        <div class="mb-3">
          <label class="civic-label" for="phone">
            Nomor WhatsApp / HP <span class="text-muted font-normal">(opsional)</span>
          </label>
          <input id="phone" class="civic-input font-monospace" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
          <div class="civic-helper">Untuk konfirmasi langsung oleh pengurus jika diperlukan penanganan darurat.</div>
        </div>

        <div class="row g-3 mb-4">
          <div class="col-sm-6">
            <label class="civic-label" for="password">Kata Sandi</label>
            <input id="password" class="civic-input" name="password" type="password" required placeholder="Minimal 8 karakter">
          </div>
          <div class="col-sm-6">
            <label class="civic-label" for="password_confirmation">Ulangi Kata Sandi</label>
            <input id="password_confirmation" class="civic-input" name="password_confirmation" type="password" required placeholder="Ketik ulang kata sandi">
          </div>
        </div>

        <button type="submit" class="btn-civic btn-civic-primary w-100 py-2">
          Selesaikan Pendaftaran
        </button>
      </form>

      <div class="pt-4 mt-4 border-top text-center small text-muted" style="border-color: var(--color-border-subtle) !important;">
        Sudah memiliki akun warga? <a href="/login" class="fw-semibold text-decoration-none" style="color: var(--color-accent);">Masuk di sini</a>
      </div>
    </div>
  </div>
</div>
@endsection
