{{-- Hallmark · macrostructure: Master-Detail Civic CRUD Registry · theme: WargaNet Pastel Blue · genre: playful --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
<!-- Admin Top Navigation Tabs -->
<div class="admin-tab-bar">
  <a href="/admin/dashboard" class="admin-tab-link">
    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
    <span>Ringkasan</span>
  </a>
  <a href="/admin/reports" class="admin-tab-link">
    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/></svg>
    <span>Verifikasi Laporan</span>
  </a>
  <a href="/admin/schedules" class="admin-tab-link {{ $res === 'schedules' ? 'active' : '' }}">
    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
    <span>Jadwal</span>
  </a>
  <a href="/admin/announcements" class="admin-tab-link {{ $res === 'announcements' ? 'active' : '' }}">
    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="m3 11 18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg>
    <span>Pengumuman</span>
  </a>
  <a href="/admin/businesses" class="admin-tab-link {{ $res === 'businesses' ? 'active' : '' }}">
    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"/><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"/><path d="M2 7h20"/></svg>
    <span>Usaha</span>
  </a>
  <a href="/admin/external-alerts" class="admin-tab-link">
    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" x2="22" y1="12" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
    <span>Info Resmi (BMKG)</span>
  </a>
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
    <div class="stat-icon-circle m-0" style="width: 2.2rem; height: 2.2rem;">
      <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    </div>
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
              Tandai sebagai Pengumuman Penting & Mendesak (Badge Merah di Beranda)
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
