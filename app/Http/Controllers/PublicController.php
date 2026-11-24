<?php
namespace App\Http\Controllers;
use App\Models\{Schedule, Announcement, IncidentReport, Business};
use App\Services\ExternalAlertService;
use Illuminate\Http\Request;

class PublicController extends Controller {
    public function home() {
        return view('home', [
            'schedules' => Schedule::where('status', 'published')->whereDate('date', '>=', today())->orderBy('date')->limit(3)->get(),
            'announcements' => Announcement::where('status', 'published')->latest('published_at')->limit(3)->get(),
            'alerts' => IncidentReport::where('verification_status', 'verified')->latest()->limit(3)->get(),
            'businesses' => Business::where('status', 'published')->limit(3)->get(),
        ]);
    }

    public function schedules(Request $r) {
        $q = Schedule::whereDate('date', '>=', today());
        if ($r->q) $q->where(fn ($x) => $x->where('title', 'like', "%{$r->q}%")->orWhere('location', 'like', "%{$r->q}%"));
        if ($r->category) $q->where('category', $r->category);
        return view('schedules', [
            'items' => $q->orderBy('date')->orderBy('start_time')->limit(50)->get(),
            'cats' => Schedule::distinct()->pluck('category'),
        ]);
    }

    public function announcements(Request $r) {
        $q = Announcement::where('status', 'published');
        if ($r->q) $q->where(fn ($x) => $x->where('title', 'like', "%{$r->q}%")->orWhere('content', 'like', "%{$r->q}%"));
        return view('announcements', ['items' => $q->orderByDesc('is_important')->latest('published_at')->limit(50)->get()]);
    }

    public function alerts(ExternalAlertService $ext) {
        return view('alerts', [
            'community' => IncidentReport::where('verification_status', 'verified')->latest()->limit(50)->get(),
            'external' => $ext->latest(),
        ]);
    }

    public function businesses(Request $r) {
        $q = Business::where('status', 'published');
        if ($r->q) $q->where(fn ($x) => $x->where('name', 'like', "%{$r->q}%")->orWhere('description', 'like', "%{$r->q}%"));
        if ($r->category) $q->where('category', $r->category);
        return view('businesses', ['items' => $q->limit(50)->get(), 'cats' => Business::distinct()->pluck('category')]);
    }
}