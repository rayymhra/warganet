{{-- Hallmark · macrostructure: Incident Reporting Form · theme: WargaNet Pastel Blue · genre: playful --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
<!-- Back navigation & Title -->
<div class="d-flex align-items-center gap-2 mb-3">
  <a href="/resident/dashboard" class="btn-pill btn-pill-outline btn-pill-sm">
    ← Kembali
  </a>
  <h1 class="h4 fw-bold mb-0">Kirim Laporan Kejadian</h1>
</div>

<div class="app-card p-4 mb-4">
  <div class="d-flex align-items-center gap-2 mb-3">
    <div class="stat-icon-circle m-0" style="width: 2.2rem; height: 2.2rem;">
      <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
    </div>
    <div>
      <h2 class="h6 fw-bold mb-0">Formulir Pelaporan Warga</h2>
      <div class="small text-muted">Laporan akan dianalisis sistem dan diverifikasi pengurus sebelum dipublikasikan.</div>
    </div>
  </div>

  <form method="post" action="/resident/reports" enctype="multipart/form-data">
    @csrf

    <div class="row g-4 mb-4">
      <!-- Left Column: Photo Upload Box with SVG -->
      <div class="col-lg-5">
        <label class="form-label fw-bold small text-dark">Unggah Foto Dokumentasi (Opsional)</label>
        <div class="p-4 rounded text-center d-flex flex-column align-items-center justify-content-center" style="border: 2px dashed #93c5fd; background: #f8fbff; min-height: 220px; cursor: pointer;">
          <div class="stat-icon-circle mb-2" style="background: #dbeafe; color: var(--color-accent);">
            <svg class="svg-icon svg-icon-lg" viewBox="0 0 24 24"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>
          </div>
          <div class="fw-semibold small text-dark mb-1">Unggah Foto (Opsional)</div>
          <div class="small text-muted mb-3" style="font-size: 0.75rem;">Format gambar JPG, PNG atau foto kamera</div>
          <input type="file" name="image" id="image" class="form-control form-control-sm" accept="image/*" style="max-width: 240px;">
        </div>
      </div>

      <!-- Right Column: Form Details -->
      <div class="col-lg-7">
        <div class="mb-3">
          <label class="form-label fw-bold small text-dark" for="category">Kategori Laporan</label>
          <select id="category" name="category" class="form-select-pill">
            <option value="">Pilih Kategori (atau biarkan AI menganalisis)</option>
            @foreach(config('warganet.incident') as $k => $v)
              <option value="{{ $k }}" @selected(old('category') == $k)>{{ $v }}</option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold small text-dark" for="title">Judul Laporan Kejadian <span class="text-danger">*</span></label>
          <input id="title" name="title" class="form-control-pill" placeholder="Mis. Pohon Tumbang Menutup Jalan" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold small text-dark" for="description">Deskripsi Kejadian <span class="text-danger">*</span></label>
          <textarea id="description" name="description" class="form-textarea-pill" rows="4" placeholder="Ceritakan kejadian dengan jelas (minimal 10 huruf)..." required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold small text-dark" for="occurred_at">Waktu Kejadian (Opsional)</label>
          <input id="occurred_at" type="datetime-local" name="occurred_at" class="form-control-pill" value="{{ old('occurred_at') }}">
        </div>
      </div>
    </div>

    <!-- Geolocation & Map -->
    <div class="pt-3 border-top mb-4" style="border-color: var(--color-border-card);">
      <label class="form-label fw-bold small text-dark">Titik Lokasi Kejadian</label>

      <div class="row g-2 mb-2">
        <div class="col-md-8">
          <div class="d-flex gap-2">
            <input id="cari" class="form-control-pill" placeholder="Ketik nama patokan/tempat (mis. Masjid Al-Ikhlas)...">
            <button type="button" class="btn-pill btn-pill-primary" id="btnCari">
              <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
              <span>Cari</span>
            </button>
          </div>
        </div>
        <div class="col-md-4">
          <button type="button" class="btn-pill btn-pill-outline w-100" id="btnGps">
            <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
            <span>Pakai Lokasi Saya</span>
          </button>
        </div>
      </div>

      <div id="hasil" class="list-group mb-2"></div>

      <div id="map" class="mb-2"></div>
      <small class="text-muted d-block mb-3">Sentuh peta atau geser penanda untuk menentukan titik yang akurat.</small>

      <div class="mb-3">
        <label class="form-label fw-bold small text-dark" for="lokasi">Keterangan Alamat / RT / RW <span class="text-danger">*</span></label>
        <input class="form-control-pill" id="lokasi" name="location" placeholder="Contoh: RT 03 RW 02, depan pos kamling" value="{{ old('location') }}" required>
      </div>

      <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
      <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
    </div>

    <!-- Submit Action Button -->
    <div class="text-end">
      <button type="submit" class="btn-pill btn-pill-primary px-4 py-2" style="font-size: 0.95rem;">
        <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
        <span>Kirim Laporan</span>
      </button>
    </div>
  </form>
</div>
@endsection

@push('js')
<script>
  const peta = L.map('map').setView([-6.9, 107.0], 12);
  let pin = null, manual = false;

  L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
  }).addTo(peta);

  const lokasi = document.getElementById('lokasi');
  const hasil = document.getElementById('hasil');

  lokasi.addEventListener('input', () => manual = true);

  function taruh(lat, lng, nama, zoom) {
    if (pin) {
      pin.setLatLng([lat, lng]);
    } else {
      pin = L.marker([lat, lng], { draggable: true }).addTo(peta);
      pin.on('dragend', () => {
        const p = pin.getLatLng();
        taruh(p.lat, p.lng, null, null);
      });
    }
    if (zoom) peta.setView([lat, lng], zoom);
    document.getElementById('latitude').value = lat.toFixed(7);
    document.getElementById('longitude').value = lng.toFixed(7);

    if (nama && !manual) {
      lokasi.value = nama;
    } else if (!nama) {
      balik(lat, lng);
    }
  }

  function balik(lat, lng) {
    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&accept-language=id&lat=${lat}&lon=${lng}`)
      .then(r => r.json())
      .then(d => {
        if (d.display_name && !manual) {
          lokasi.value = d.display_name;
        }
      })
      .catch(() => {});
  }

  async function cari() {
    const q = document.getElementById('cari').value.trim();
    if (!q) return;
    hasil.innerHTML = '<div class="list-group-item small">Mencari lokasi...</div>';
    try {
      const r = await fetch('https://nominatim.openstreetmap.org/search?format=json&limit=5&countrycodes=id&accept-language=id&q=' + encodeURIComponent(q));
      const d = await r.json();
      hasil.innerHTML = '';
      if (!d.length) {
        hasil.innerHTML = '<div class="list-group-item small">Tempat tidak ditemukan. Sentuh peta langsung untuk memilih titik.</div>';
        return;
      }
      d.forEach(t => {
        const b = document.createElement('button');
        b.type = 'button';
        b.className = 'list-group-item list-group-item-action small py-2 px-3';
        b.textContent = t.display_name;
        b.onclick = () => {
          manual = false;
          taruh(+t.lat, +t.lon, t.display_name, 17);
          hasil.innerHTML = '';
        };
        hasil.appendChild(b);
      });
    } catch(e) {
      hasil.innerHTML = '<div class="list-group-item small text-danger">Pencarian gagal. Sentuh peta untuk memilih titik.</div>';
    }
  }

  document.getElementById('btnCari').onclick = cari;
  document.getElementById('cari').addEventListener('keydown', e => {
    if (e.key === 'Enter') {
      e.preventDefault();
      cari();
    }
  });

  document.getElementById('btnGps').onclick = () => {
    if (!navigator.geolocation) {
      alert('Perangkat Anda tidak mendukung fitur lokasi otomatis.');
      return;
    }
    navigator.geolocation.getCurrentPosition(
      p => {
        manual = false;
        taruh(p.coords.latitude, p.coords.longitude, null, 17);
      },
      () => alert('Lokasi tidak dapat diambil. Pastikan izin lokasi aktif pada browser.'),
      { enableHighAccuracy: true, timeout: 15000 }
    );
  };

  peta.on('click', e => taruh(e.latlng.lat, e.latlng.lng, null, null));

  @if(old('latitude') && old('longitude'))
    taruh({{ (float) old('latitude') }}, {{ (float) old('longitude') }}, null, 15);
  @endif
</script>
@endpush
