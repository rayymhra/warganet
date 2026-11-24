<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class IncidentReport extends Model {
    protected $guarded = [];
    protected $casts = ['occurred_at' => 'datetime', 'reviewed_at' => 'datetime'];
    public function user() { return $this->belongsTo(User::class); }
    public function reviewer() { return $this->belongsTo(User::class, 'reviewed_by'); }
    public function logs() { return $this->hasMany(IncidentStatusLog::class); }
}
