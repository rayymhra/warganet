<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Schedule, Announcement, Business};
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CrudController extends Controller {
    // field => [label, aturan validasi, tipe input]
    private function cfg(string $res): array {
        $all = [
            'schedules' => ['model' => Schedule::class, 'title' => 'Jadwal', 'cats' => 'schedule_categories',
                'status' => ['published' => 'Terbit', 'cancelled' => 'Dibatalkan'],
                'fields' => ['title' => ['Judul kegiatan', 'required|max:150', 'text'], 'description' => ['Keterangan', 'nullable', 'textarea'],
                    'date' => ['Tanggal', 'required|date', 'date'], 'start_time' => ['Jam mulai', 'required', 'time'],
                    'end_time' => ['Jam selesai (boleh kosong)', 'nullable', 'time'], 'location' => ['Tempat', 'required|max:255', 'text']]],
            'announcements' => ['model' => Announcement::class, 'title' => 'Pengumuman', 'cats' => 'announcement_categories',
                'status' => ['published' => 'Terbit', 'draft' => 'Draf (belum tampil)'],
                'fields' => ['title' => ['Judul pengumuman', 'required|max:150', 'text'], 'content' => ['Isi pengumuman', 'required', 'textarea']]],
            'businesses' => ['model' => Business::class, 'title' => 'Usaha Warga', 'cats' => 'business_categories',
                'status' => ['published' => 'Tampil', 'unpublished' => 'Disembunyikan'],
                'fields' => ['name' => ['Nama usaha', 'required|max:150', 'text'], 'description' => ['Deskripsi usaha', 'required', 'textarea'],
                    'address' => ['Alamat', 'required', 'textarea'], 'phone' => ['No. WhatsApp / telepon', 'nullable|max:30', 'text'],
                    'operating_hours' => ['Jam buka', 'nullable', 'text']]],
        ];
        abort_unless(isset($all[$res]), 404);
        return $all[$res];
    }

    private function rules(array $c): array {
        $r = array_map(fn ($f) => $f[1], $c['fields']);
        $r['category'] = 'required|in:' . implode(',', config('warganet.' . $c['cats']));
        $r['status'] = 'required|in:' . implode(',', array_keys($c['status']));
        return $r;
    }

    public function index(string $res) {
        $c = $this->cfg($res);
        return view('admin.crud', ['res' => $res, 'title' => $c['title'], 'fields' => $c['fields'],
            'cats' => config('warganet.' . $c['cats']), 'statuses' => $c['status'], 'rows' => $c['model']::latest()->limit(100)->get()]);
    }

    public function store(Request $r, string $res) {
        $c = $this->cfg($res);
        $d = $r->validate($this->rules($c));
        $d['created_by'] = $r->user()->id;
        if ($res === 'announcements') {
            $d['slug'] = Str::slug($d['title']) . '-' . Str::random(5);
            $d['is_important'] = $r->boolean('is_important');
            $d['published_at'] = $d['status'] === 'published' ? now() : null;
        }
        $c['model']::create($d);
        return back()->with('ok', 'Berhasil disimpan.');
    }

    public function destroy(string $res, int $id) {
        $this->cfg($res)['model']::findOrFail($id)->delete();
        return back()->with('ok', 'Berhasil dihapus.');
    }
}
