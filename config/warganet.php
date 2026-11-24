<?php

return [
    'schedule_categories' => ['Kebersihan', 'Kesehatan', 'Rapat Warga', 'Kegiatan Warga', 'Ronda / Keamanan', 'Lainnya'],
    'announcement_categories' => ['Umum', 'Kegiatan Warga', 'Kesehatan', 'Keamanan', 'Iuran & Keuangan', 'Lainnya'],
    'business_categories' => ['Makanan & Minuman', 'Warung & Sembako', 'Jasa & Perbaikan', 'Kesehatan', 'Pendidikan', 'Lainnya'],
    // kunci = kode yang dipakai AI (jangan diubah), nilai = tulisan untuk warga
    'incident' => ['flood' => 'Banjir', 'fire' => 'Kebakaran', 'fallen_tree' => 'Pohon Tumbang',
                   'road_damage' => 'Jalan Rusak', 'power_outage' => 'Listrik Padam', 'other' => 'Lainnya'],
    'report_status' => ['pending' => 'Menunggu diperiksa', 'verified' => 'Terverifikasi', 'rejected' => 'Ditolak', 'resolved' => 'Selesai'],
];
