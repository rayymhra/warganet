<?php
namespace App\Http\Controllers\Resident;
use App\Http\Controllers\Controller;
use App\Models\{IncidentReport, Notification};
use App\Services\AiClassificationService;
use Illuminate\Http\Request;

class ReportController extends Controller {
    public function dashboard(Request $r) {
        $u = $r->user();
        return view('resident.dashboard', [
            'reports' => IncidentReport::where('user_id', $u->id)->latest()->get(),
            'notes' => Notification::where('user_id', $u->id)->latest()->limit(10)->get(),
        ]);
    }

    public function create() { return view('resident.create'); }

    public function store(Request $r, AiClassificationService $ai) {
        $d = $r->validate([
            'title' => 'required|max:150', 'description' => 'required|min:10', 'location' => 'required|max:255',
            'category' => 'nullable|in:' . implode(',', AiClassificationService::CATEGORIES),
            'latitude' => 'nullable|numeric|between:-90,90', 'longitude' => 'nullable|numeric|between:-180,180',
            'occurred_at' => 'nullable|date', 'image' => 'nullable|image|max:2048',
        ]);
        if ($r->hasFile('image')) $d['image_path'] = $r->file('image')->store('incidents', 'public');
        unset($d['image']);
        $d['user_id'] = $r->user()->id;
        $d['verification_status'] = 'pending'; // never auto-published

        if ($res = $ai->classify($d['description'], $d['location'])) { // report is saved even if AI is down
            $d['category'] = $d['category'] ?? $res['category'];
            $d['ai_confidence'] = $res['confidence'];
            $d['ai_severity'] = $res['severity'];
        }
        IncidentReport::create($d);
        return redirect('/resident/dashboard')->with('ok', 'Report submitted. An administrator will review it before it is published.');
    }
}