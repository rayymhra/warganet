<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{IncidentReport, IncidentStatusLog, Notification};
use App\Services\ExternalAlertService;
use Illuminate\Http\Request;

class ReportController extends Controller {
    public function index(Request $r) {
        $q = IncidentReport::with('user')->latest();
        if ($r->status) $q->where('verification_status', $r->status);
        return view('admin.reports', ['items' => $q->limit(100)->get()]);
    }
    public function show(IncidentReport $report) {
        return view('admin.report', ['r' => $report->load('user', 'logs')]);
    }
    public function status(Request $req, IncidentReport $report) {
        $d = $req->validate(['status' => 'required|in:verified,rejected,resolved', 'category' => 'nullable|string|max:40', 'notes' => 'nullable|string']);
        $prev = $report->verification_status;
        $report->update(['verification_status' => $d['status'], 'category' => $d['category'] ?: $report->category,
            'reviewed_by' => $req->user()->id, 'reviewed_at' => now()]);
        IncidentStatusLog::create(['incident_report_id' => $report->id, 'admin_id' => $req->user()->id,
            'previous_status' => $prev, 'new_status' => $d['status'], 'notes' => $d['notes'] ?? null]);
        Notification::create(['user_id' => $report->user_id, 'title' => 'Laporan ' . config('warganet.report_status')[$d['status']], 'type' => 'report',
            'message' => "Laporan Anda \"{$report->title}\" sekarang berstatus " . config('warganet.report_status')[$d['status']] . ".", 'related_id' => $report->id]);
        return back()->with('ok', 'Status diperbarui dan dicatat.');
    }
    public function external(ExternalAlertService $ext) { return view('admin.external', ['items' => $ext->latest(20)]); }
}
