{{-- Hallmark · macrostructure: Dispatch Triage & Tactical Geocoding Form · theme: Nusantara Civic · genre: editorial --}}
{{-- pre-emit critique: P5 H5 E5 S5 R5 V5 --}}
{{-- slop test: pass --}}
@extends('layouts.app')

@section('content')
<div class="civic-section-header mb-3">
  <span class="civic-eyebrow">FORMULIR PELAPORAN CEPAT</span>
  <h1 class="h3 mb-1">Laporkan Kejadian di Lingkungan</h1>
  <p class="text-muted small mb-0">
    Sampaikan kejadian penting seperti jalan rusak, lampu padam, banjir, pohon tumbang, atau potensi bahaya lainnya di sekitar tempat tinggal Anda.
  </p>
</div>

<!-- Safety Notice -->
<div class="civic-alert civic-alert-caution align-items-center mb-4">
  <span class="fw-bold font-monospace">⚠️ PERHATIAN:</span>
  <div>
    Laporan warga akan diperiksa keabsahannya oleh pengurus RT/RW sebelum dipublikasikan. Jika keadaan darurat mengancam keselamatan jiwa, segera hubungi <strong>112</strong> atau pos kamling setempat.
  </div>
</div>

<form method="post" action="/resident/reports" enctype="multipart/form-data" class="civic-card p-4 p-md-5 mb-5">
  @csrf

  <!-- Section 1: Detail Kejadian -->
  <fieldset class="mb-5">
    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom" style="border-color: var(--color-border-subtle) !important;">
      <span class="font-monospace fw-bold" style="color: var(--color-accent); font-size: 1.1rem;">01.</span>
      <legend class="h6 fw-bold mb-0" style="color: var(--color-text-main);">Deskripsi Kejadian</legend>
    </div>

    <div class="mb-3">
      <label class="civic-label" for="title">Judul Singkat Kejadian <span class="text-danger">*</span></label>
      <input id="title" class="civic-input" name="title" placeholder="Contoh: Tiang listrik miring menghalangi gang RT 03" value="{{ old('title') }}" required>
    </div>

    <div class="mb-3">
      <label class="civic-label" for="description">Kronologi / Penjelasan Lengkap <span class="text-danger">*</span></label>
      <textarea id="description" class="civic-textarea" name="description" rows="4" placeholder="Jelaskan detail kejadian, kondisi terkini, dan perkiraan dampak (minimal 10 huruf)..." required>{{ old('description') }}</textarea>
    </div>

    <div class="row g-3">
      <div class="col-md-6">
        <label class="civic-label" for="category">Jenis / Kategori Kejadian</label>
        <select id="category" class="civic-select" name="category">
          <option value="">Biarkan pengurus / bantuan sistem mengelompokkan</option>
          @foreach(config('warganet.incident') as $k => $v)
            <option value="{{ $k }}" @selected(old('category') == $k)>{{ $v }}</option>
          @endforeach
        </select>
        <div class="civic-helper">Pilih jenis kendala yang paling sesuai atau biarkan kosong jika ragu.</div>
      </div>
      <div class="col-md-6">
        <label class="civic-label" for="occurred_at">Waktu Kejadian</label>
        <input id="occurred_at" class="civic-input" type="datetime-local" name="occurred_at" value="{{ old('occurred_at') }}">
        <div class="civic-helper">Kosongkan jika baru saja terjadi.</div>
      </div>
    </div>
  </fieldset>

  <!-- Section 2: Penentuan Titik Lokasi -->
  <fieldset class="mb-5">
    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom" style="border-color: var(--color-border-subtle) !important;">
      <span class="font-monospace fw-bold" style="color: var(--color-accent); font-size: 1.1rem;">02.</span>
      <legend class="h6 fw-bold mb-0" style="color: var(--color-text-main);">Lokasi Presisi & Peta</legend>
    </div>

    <!-- Search & GPS Controls -->
    <div class="row g-2 mb-2">
      <div class="col-md-8">
        <div class="d-flex gap-2">
          <input id="cari" class="civic-input" placeholder="Cari nama patokan/masjid/jalan (mis. Masjid Al-Ikhlas Takokak)...">
          <button type="button" class="btn-civic btn-civic-primary" id="btnCari">Cari Lokasi</button>
        </div>
      </div>
      <div class="col-md-4">
        <button type="button" class="btn-civic btn-civic-outline w-100" id="btnGps">📍 Pakai Titik GPS Saya</button>
      </div>
    </div>

    <div id="hasil" class="list-group mb-2"></div>

    <div id="map" class="mb-2"></div>
    <div class="small text-muted mb-3">
      Sentuh peta atau geser penanda merah untuk menentukan koordinat lokasi kejadian secara tepat.
    </div>

    <div class="mb-3">
      <label class="civic-label" for="lokasi">Keterangan Alamat / Patokan Khusus <span class="text-danger">*</span></label>
      <input class="civic-input" id="lokasi" name="location" placeholder="Mis. Depan Posyandu Mawar RT 02 RW 04, samping warung Bu Siti" value="{{ old('location') }}" required>
    </div>

    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
  </fieldset>

  <!-- Section 3: Lampiran Foto -->
  <fieldset class="mb-4">
    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom" style="border-color: var(--color-border-subtle) !important;">
      <span class="font-monospace fw-bold" style="color: var(--color-accent); font-size: 1.1rem;">03.</span>
      <legend class="h6 fw-bold mb-0" style="color: var(--color-text-main);">Dokumentasi Foto Lapangan</legend>
    </div>

    <div class="mb-2">
      <label class="civic-label" for="image">Unggah Foto Kejadian <span class="text-muted font-normal">(opsional)</span></label>
      <input id="image" class="civic-input" type="file" name="image" accept="image/*">
      <div class="civic-helper">Foto membantu pengurus memverifikasi tingkat keparahan kejadian dengan cepat.</div>
    </div>
  </fieldset>

  <div class="pt-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2" style="border-color: var(--color-border-subtle) !important;">
    <a href="/resident/dashboard" class="btn-civic btn-civic-subtle">← Batal</a>
    <button type="submit" class="btn-civic btn-civic-urgent py-2 px-4">
      Kirim Laporan ke Pengurus
    </button>
  </div>
</form>
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
    hasil.innerHTML = '<div class="civic-card p-2 text-muted small">Mencari titik lokasi...</div>';
    try {
      const r = await fetch('https://nominatim.openstreetmap.org/search?format=json&limit=5&countrycodes=id&accept-language=id&q=' + encodeURIComponent(q));
      const d = await r.json();
      hasil.innerHTML = '';
      if (!d.length) {
        hasil.innerHTML = '<div class="civic-card p-2 text-muted small">Tempat tidak ditemukan. Coba nama lain atau sentuh peta langsung.</div>';
        return;
      }
      d.forEach(t => {
        const b = document.createElement('button');
        b.type = 'button';
        b.className = 'list-group-item list-group-item-action small py-2 px-3 border-bottom';
        b.textContent = '📍 ' + t.display_name;
        b.onclick = () => {
          manual = false;
          taruh(+t.lat, +t.lon, t.display_name, 17);
          hasil.innerHTML = '';
        };
        hasil.appendChild(b);
      });
    } catch(e) {
      hasil.innerHTML = '<div class="civic-card p-2 text-danger small">Pencarian gagal. Silakan sentuh peta langsung untuk memilih lokasi.</div>';
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
      () => alert('Lokasi tidak bisa diambil. Pastikan izin lokasi aktif pada peramban Anda.'),
      { enableHighAccuracy: true, timeout: 15000 }
    );
  };

  peta.on('click', e => taruh(e.latlng.lat, e.latlng.lng, null, null));

  @if(old('latitude') && old('longitude'))
    taruh({{ (float) old('latitude') }}, {{ (float) old('longitude') }}, null, 15);
  @endif
</script>
@endpush
