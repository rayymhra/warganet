<?php
namespace App\Services;
use App\Models\ExternalAlert;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/** BMKG latest-earthquake feed. VERIFY endpoint, coverage and usage terms with BMKG before relying on it. */
class ExternalAlertService {
    const URL = 'https://data.bmkg.go.id/DataMKG/TEWS/autogempa.json';

    public function latest(int $n = 5) {
        $last = ExternalAlert::latest('fetched_at')->first();
        if (!$last || $last->fetched_at->lt(now()->subMinutes(15))) $this->refresh();
        return ExternalAlert::latest('published_at')->limit($n)->get();
    }

    public function refresh(): bool {
        try {
            $res = Http::timeout(8)->get(self::URL);
            $g = $res->json('Infogempa.gempa');
            if (!$res->successful() || !$g || empty($g['DateTime'])) return false;
            ExternalAlert::updateOrCreate(['external_id' => 'bmkg-' . $g['DateTime']], [
                'source_name' => 'BMKG', 'title' => "Gempa M{$g['Magnitude']} - {$g['Wilayah']}",
                'description' => "Kedalaman {$g['Kedalaman']}, potensi: {$g['Potensi']}. Dirasakan: " . ($g['Dirasakan'] ?? '-'),
                'category' => 'earthquake', 'location' => $g['Wilayah'], 'source_url' => 'https://www.bmkg.go.id',
                'published_at' => $g['DateTime'], 'fetched_at' => now(), 'status' => 'active']);
            return true;
        } catch (\Throwable $e) {
            Log::warning('BMKG fetch failed: ' . $e->getMessage());
            return false; // last stored data stays visible with its own timestamp
        }
    }
}
