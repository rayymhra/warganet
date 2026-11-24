<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{User, Schedule, Announcement, IncidentReport};

class DashboardController extends Controller {
    public function index() {
        return view('admin.dashboard', [
            'stats' => [
                'Residents' => User::where('role', 'resident')->count(),
                'Schedules' => Schedule::count(),
                'Announcements' => Announcement::count(),
                'Pending reports' => IncidentReport::where('verification_status', 'pending')->count(),
                'Verified / active alerts' => IncidentReport::where('verification_status', 'verified')->count(),
            ],
            'latest' => IncidentReport::with('user')->latest()->limit(5)->get(),
        ]);
    }
}