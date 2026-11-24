@extends('layouts.app') @section('content')
<h3>📢 Buat Laporan Kejadian</h3>
<div class="alert alert-warning">Laporan akan diperiksa admin dulu sebelum tampil ke warga. Jika ada bahaya langsung, <b>hubungi 112</b>.</div>
<form method="post" action="/resident/reports" enctype="multipart/form-data" class="card p-4">@csrf
<label class="form-label fw-semibold">1. Apa yang terjadi?</label>
<input class="form-control mb-2" name="title" placeholder="Contoh: Pohon tumbang menutup jalan" value="{{ old('title') }}" required>
<textarea class="form-control mb-3" name="description" rows="4" placeholder="Ceritakan kejadiannya dengan jelas (minimal 10 huruf)" required>{{ old('description') }}</textarea>

<div class="row g-3 mb-3">
<div class="col-md-6"><label class="form-label fw-semibold">Jenis kejadian</label>
<select class="form-select" name="category"><option value="">Tidak tahu / biar dibantu AI</option>
@foreach(config('warganet.incident') as $k => $v)<option value="{{ $k }}" @selected(old('category')==$k)>{{ $v }}</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label fw-semibold">Kapan kejadiannya?</label><input class="form-control" type="datetime-local" name="occurred_at" value="{{ old('occurred_at') }}"></div></div>

<label class="form-label fw-semibold">2. Di mana lokasinya?</label>
<div class="input-group mb-2"><input id="cari" class="form-control" placeholder="Ketik nama tempat, lalu tekan Cari (mis. Masjid Al-Ikhlas Takokak)">
<button type="button" class="btn btn-primary" id="btnCari">🔍 Cari</button></div>
<button type="button" class="btn btn-outline-primary mb-2" id="btnGps">📍 Pakai lokasi saya sekarang</button>
<div id="hasil" class="list-group mb-2"></div>
<div id="map" class="mb-2"></div>
<small class="text-muted d-block mb-2">Anda juga bisa menyentuh peta, atau menggeser penanda, untuk memilih titik yang tepat.</small>
<input class="form-control mb-3" id="lokasi" name="location" placeholder="Keterangan lokasi (mis. RT 02 RW 03, depan warung)" value="{{ old('location') }}" required>
<input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}"><input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">

<label class="form-label fw-semibold">3. Foto <span class="text-muted">(boleh dikosongkan)</span></label>
<input class="form-control mb-3" type="file" name="image" accept="image/*">
<button class="btn btn-danger btn-lg">Kirim Laporan</button></form>@endsection
@push('js')<script>
const peta=L.map('map').setView([-6.9,107.0],12);let pin=null,manual=false;
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png',{attribution:'© OpenStreetMap'}).addTo(peta);
const lokasi=document.getElementById('lokasi'),hasil=document.getElementById('hasil');
lokasi.addEventListener('input',()=>manual=true);
function taruh(lat,lng,nama,zoom){
  if(pin){pin.setLatLng([lat,lng]);}else{pin=L.marker([lat,lng],{draggable:true}).addTo(peta);
    pin.on('dragend',()=>{const p=pin.getLatLng();taruh(p.lat,p.lng,null,null);});}
  if(zoom)peta.setView([lat,lng],zoom);
  document.getElementById('latitude').value=lat.toFixed(7);document.getElementById('longitude').value=lng.toFixed(7);
  if(nama&&!manual)lokasi.value=nama; else if(!nama)balik(lat,lng);
}
function balik(lat,lng){ // titik -> nama tempat
  fetch(`https://nominatim.openstreetmap.org/reverse?format=json&accept-language=id&lat=${lat}&lon=${lng}`)
   .then(r=>r.json()).then(d=>{if(d.display_name&&!manual)lokasi.value=d.display_name;}).catch(()=>{});
}
async function cari(){
  const q=document.getElementById('cari').value.trim();if(!q)return;
  hasil.innerHTML='<div class="list-group-item">Mencari...</div>';
  try{
    const r=await fetch('https://nominatim.openstreetmap.org/search?format=json&limit=5&countrycodes=id&accept-language=id&q='+encodeURIComponent(q));
    const d=await r.json();hasil.innerHTML='';
    if(!d.length){hasil.innerHTML='<div class="list-group-item">Tempat tidak ditemukan. Coba nama lain, atau sentuh peta.</div>';return;}
    d.forEach(t=>{const b=document.createElement('button');b.type='button';b.className='list-group-item list-group-item-action';
      b.textContent='📍 '+t.display_name;b.onclick=()=>{manual=false;taruh(+t.lat,+t.lon,t.display_name,17);hasil.innerHTML='';};hasil.appendChild(b);});
  }catch(e){hasil.innerHTML='<div class="list-group-item text-danger">Pencarian gagal. Sentuh peta untuk memilih lokasi.</div>';}
}
document.getElementById('btnCari').onclick=cari;
document.getElementById('cari').addEventListener('keydown',e=>{if(e.key==='Enter'){e.preventDefault();cari();}});
document.getElementById('btnGps').onclick=()=>{
  if(!navigator.geolocation){alert('Perangkat Anda tidak mendukung lokasi.');return;}
  navigator.geolocation.getCurrentPosition(p=>{manual=false;taruh(p.coords.latitude,p.coords.longitude,null,17);},
    ()=>alert('Lokasi tidak bisa diambil. Pastikan izin lokasi aktif, atau pilih lewat peta/pencarian.'),{enableHighAccuracy:true,timeout:15000});
};
peta.on('click',e=>taruh(e.latlng.lat,e.latlng.lng,null,null));
@if(old('latitude') && old('longitude')) taruh({{ (float) old('latitude') }},{{ (float) old('longitude') }},null,15); @endif
</script>@endpush
