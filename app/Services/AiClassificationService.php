<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiClassificationService {
    const CATEGORIES = ['flood', 'fire', 'fallen_tree', 'road_damage', 'power_outage', 'other'];

    /** Returns ['category','confidence','severity'] or null if the AI is unavailable/invalid. Never fabricates. */
    public function classify(string $description, string $location): ?array {
        try {
            $res = Http::timeout((int) env('AI_SERVICE_TIMEOUT', 10))
                ->post(rtrim(env('AI_SERVICE_URL', 'http://127.0.0.1:8000'), '/') . '/api/classify-incident',
                    compact('description', 'location'));
            $d = $res->json();
            if (!$res->successful() || !in_array($d['category'] ?? null, self::CATEGORIES, true)) return null;
            return ['category' => $d['category'],
                    'confidence' => isset($d['confidence']) ? (float) $d['confidence'] : null,
                    'severity' => $d['severity'] ?? null];
        } catch (\Throwable $e) {
            Log::warning('AI classification failed: ' . $e->getMessage());
            return null;
        }
    }
}