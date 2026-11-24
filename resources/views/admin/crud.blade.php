{{-- Hallmark · macrostructure: Master-Detail Civic CRUD Registry · theme: Nusantara Civic · genre: editorial --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
<div class="civic-section-header mb-4">
  <span class="civic-eyebrow">PENGELOLAAN DATA</span>
  <h1 class="h3 mb-1">Kelola {{ $title }}</h1>
  <p class="text-muted small mb-0">Pembaruan berkala direktori dan konten resmi rukun warga.</p>
</div>

<!-- Creation / Entry Form -->
<div class="civic-card p-4 p-md-5 mb-5">
  <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom" style="border-color: var(--color-border-subtle) !important;">
    <span class="font-monospace fw-bold" style="color: var(--color-accent); font-size: 1.1rem;">+</span>
    <h2 class="h5 fw-bold mb-0">Tambah {{ $title }} Baru</h2>
  </div>

  <form method="post" action="/admin/{{ $res }}">
    @csrf
    <div class="row g-3">
      @foreach($fields as $name => [$label, $rule, $type])
        <div class="col-md-6">
          <label class="civic-label" for="{{ $name }}">{{ $label }}</label>
          @if($type === 'textarea')
            <textarea id="{{ $name }}" name="{{ $name }}" class="civic-textarea" rows="3" @required(str_contains($rule, 'required'))>{{ old($name) }}</textarea>
          @else
            <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" class="civic-input" value="{{ old($name) }}" @required(str_contains($rule, 'required'))>
          @endif
        </div>
      @endforeach

      <div class="col-md-6">
        <label class="civic-label" for="category">Kategori</label>
        <select id="category" name="category" class="civic-select" required>
          <option value="">— Pilih Kategori —</option>
          @foreach($cats as $c)
            <option value="{{ $c }}" @selected(old('category') == $c)>{{ $c }}</option>
          @endforeach
        </select>
      </div>

      <div class="col-md-6">
        <label class="civic-label" for="status">Status Publikasi</label>
        <select id="status" name="status" class="civic-select">
          @foreach($statuses as $k => $v)
            <option value="{{ $k }}">{{ $v }}</option>
          @endforeach
        </select>
      </div>

      @if($res === 'announcements')
        <div class="col-12">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_important" value="1" id="is_important">
            <label class="form-check-label fw-semibold" for="is_important">
              ⭐ Tandai sebagai Maklumat Penting & Mendesak (Muncul mencolok di beranda)
            </label>
          </div>
        </div>
      @endif
    </div>

    <div class="mt-4 pt-3 border-top d-flex justify-content-end" style="border-color: var(--color-border-subtle) !important;">
      <button type="submit" class="btn-civic btn-civic-primary py-2 px-4">
        Simpan {{ $title }}
      </button>
    </div>
  </form>
</div>

<!-- Existing Records Table -->
<div class="civic-section-header mb-2">
  <span class="civic-eyebrow">DAFTAR ARSIP</span>
  <h2 class="h5 mb-0">Data Terdaftar ({{ count($rows) }})</h2>
</div>

<div class="civic-table-wrapper">
  <table class="civic-table">
    <thead>
      <tr>
        <th>Nama / Judul</th>
        <th>Kategori</th>
        <th>Status</th>
        <th class="text-end">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($rows as $r)
        <tr>
          <td>
            <div class="fw-semibold text-dark">{{ $r->title ?? $r->name }}</div>
          </td>
          <td>
            <span class="civic-badge civic-badge-accent">{{ $r->category }}</span>
          </td>
          <td>
            <span class="civic-badge civic-badge-neutral">{{ $statuses[$r->status] ?? $r->status }}</span>
          </td>
          <td class="text-end">
            <form method="post" action="/admin/{{ $res }}/{{ $r->id }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn-civic btn-civic-urgent btn-civic-sm">
                Hapus
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="4" class="text-center py-5 text-muted">
            Belum ada arsip data yang tersimpan.
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
