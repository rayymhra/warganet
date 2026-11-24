<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ExternalAlert extends Model {
    protected $guarded = []; protected $casts = ["published_at"=>"datetime","fetched_at"=>"datetime"];
    public function isStale(): bool { return $this->fetched_at->lt(now()->subHour()); }
}
