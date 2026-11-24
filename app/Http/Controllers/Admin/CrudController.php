<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Schedule, Announcement, Business};
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/** One controller for schedules, announcements and businesses. */
class CrudController extends Controller {
    const R = [
        'schedules' => [Schedule::class, [
            'title' => 'required|max:150', 'category' => 'required|max:60', 'description' => 'nullable',
            'date' => 'required|date', 'start_time' => 'required', 'end_time' => 'nullable',
            'location' => 'required|max:255', 'status' => 'required|in:published,cancelled']],
        'announcements' => [Announcement::class, [
            'title' => 'required|max:150', 'category' => 'required|max:60', 'content' => 'required',
            'status' => 'required|in:draft,published']],
        'businesses' => [Business::class, [
            'name' => 'required|max:150', 'category' => 'required|max:60', 'description' => 'required',
            'address' => 'required', 'phone' => 'nullable|max:30', 'operating_hours' => 'nullable',
            'status' => 'required|in:published,unpublished']],
    ];

    private function cfg(string $res) { abort_unless(isset(self::R[$res]), 404); return self::R[$res]; }

    public function index(string $res) {
        [$model, $rules] = $this->cfg($res);
        return view('admin.crud', ['res' => $res, 'fields' => array_keys($rules), 'rows' => $model::latest()->limit(100)->get()]);
    }

    public function store(Request $r, string $res) {
        [$model, $rules] = $this->cfg($res);
        $d = $r->validate($rules);
        $d['created_by'] = $r->user()->id;
        if ($res === 'announcements') {
            $d['slug'] = Str::slug($d['title']) . '-' . Str::random(5);
            $d['is_important'] = $r->boolean('is_important');
            $d['published_at'] = $d['status'] === 'published' ? now() : null;
        }
        $model::create($d);
        return back()->with('ok', 'Saved.');
    }

    public function destroy(string $res, int $id) {
        $this->cfg($res)[0]::findOrFail($id)->delete();
        return back()->with('ok', 'Deleted.');
    }
}