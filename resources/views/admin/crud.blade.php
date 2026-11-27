{{-- Hallmark · macrostructure: Master-Detail Civic CRUD Registry · theme: WargaNet Pastel Blue · genre: playful --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
<!-- Admin Top Navigation Tabs -->
<div class="admin-tab-bar">
  <a href="/admin/dashboard" class="admin-tab-link">🏠 Ringkasan</a>
  <a href="/admin/reports" class="admin-tab-link">📋 Verifikasi Laporan</a>
  <a href="/admin/schedules" class="admin-tab-link {{ $res === 'schedules' ? 'active' : '' }}">📅 Jadwal</a>
  <a href="/admin/announcements" class="admin-tab-link {{ $res === 'announcements' ? 'active' : '' }}">📢 Pengumuman</a>
  <a href="/admin/businesses" class="admin-tab-link {{ $res === 'businesses' ? 'active' : '' }}">🏪 Usaha</a>
  <a href="/admin/external-alerts" class="admin-tab-link">🌐 Info Resmi (BMKG)</a>
</div>

<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
  <div>
    <h1 class="h4 fw-bold mb-1">Kelola {{ $title }}</h1>
    <div class="small text-muted">Tambah, perbarui, atau hapus data resmi rukun warga</div>
  </div>
</div>

<!-- Entry Form -->
<div class="app-card mb-4 p-4">
  <div class="d-flex align-items-center gap-2 mb-3">
    <div class="stat-icon-circle m-0" style="width: 2.2rem; height: 2.2rem; font-size: 1rem;">➕</div>
    <h2 class="h6 fw-bold mb-0">Tambah {{ $title }} Baru</h2>
  </div>

  <form method="post" action="/admin/{{ $res }}">
    @csrf
    <div class="row g-3">
      @foreach($fields as $name => [$label, $rule, $type])
        <div class="col-md-6">
          <label class="form-label fw-bold small text-dark" for="{{ $name }}">{{ $label }}</label>
          @if($type === 'textarea')
            <textarea id="{{ $name }}" name="{{ $name }}" class="form-textarea-pill" rows="3" @required(str_contains($rule, 'required'))>{{ old($name) }}</textarea>
          @else
            <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" class="form-control-pill" value="{{ old($name) }}" @required(str_contains($rule, 'required'))>
          @endif
        </div>
      @endforeach

      <div class="col-md-6">
        <label class="form-label fw-bold small text-dark" for="category">Kategori</label>
        <select id="category" name="category" class="form-select-pill" required>
          <option value="">— Pilih Kategori —</option>
          @foreach($cats as $c)
            <option value="{{ $c }}" @selected(old('category') == $c)>{{ $c }}</option>
          @endforeach
        </select>
      </div>

      <div class="col-md-6">
        <label class="form-label fw-bold small text-dark" for="status">Status</label>
        <select id="status" name="status" class="form-select-pill">
          @foreach($statuses as $k => $v)
            <option value="{{ $k }}">{{ $v }}</option>
          @endforeach
        </select>
      </div>

      @if($res === 'announcements')
        <div class="col-12">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_important" value="1" id="is_important">
            <label class="form-check-label fw-bold small text-dark" for="is_important">
              ⭐ Tandai sebagai Pengumuman Penting & Mendesak (Badge Merah di Beranda)
            </label>
          </div>
        </div>
      @endif
    </div>

    <div class="mt-4 pt-3 border-top text-end" style="border-color: var(--color-border-card) !important;">
      <button type="submit" class="btn-pill btn-pill-primary px-4 py-2">
        Simpan {{ $title }}
      </button>
    </div>
  </form>
</div>

<!-- Existing Records Table -->
<div class="app-card p-0 overflow-hidden">
  <div class="p-3 border-bottom" style="border-color: var(--color-border-card);">
    <h3 class="h6 fw-bold mb-0">Daftar {{ $title }} Terdaftar ({{ count($rows) }})</h3>
  </div>

  <div class="table-responsive">
    <table class="table align-middle mb-0" style="font-size: 0.885rem;">
      <thead style="background: var(--color-surface-subtle); border-bottom: 1px solid var(--color-border-card);">
        <tr>
          <th class="ps-3 py-3 fw-bold text-muted small">NAMA / JUDUL</th>
          <th class="py-3 fw-bold text-muted small">KATEGORI</th>
          <th class="py-3 fw-bold text-muted small">STATUS</th>
          <th class="pe-3 py-3 text-end fw-bold text-muted small">TINDAKAN</th>
        </tr>
      </thead>
      <tbody>
        @forelse($rows as $r)
          <tr style="border-bottom: 1px solid var(--color-border-subtle);">
            <td class="ps-3 py-3">
              <div class="fw-bold text-dark">{{ $r->title ?? $r->name }}</div>
            </td>
            <td class="py-3">
              <span class="badge-pill badge-pill-blue">{{ $r->category }}</span>
            </td>
            <td class="py-3">
              <span class="badge-pill badge-pill-green">{{ $statuses[$r->status] ?? $r->status }}</span>
            </td>
            <td class="pe-3 py-3 text-end">
              <form method="post" action="/admin/{{ $res }}/{{ $r->id }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-pill btn-pill-danger btn-pill-sm">
                  Hapus
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="text-center py-5 text-muted">
              Belum ada data {{ $title }} yang tersimpan.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
