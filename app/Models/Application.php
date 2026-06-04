<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'lowongan_id', 'name', 'email', 'cv_path', 'cover_letter', 'status', 'accepted_at'
    ];

    protected $casts = [
        'status_history' => 'array',
        'accepted_at' => 'datetime',
    ];

    public function scopeAcceptedWithinMonths($query, $months = 6)
    {
        $threshold = now()->subMonths($months);

        return $query->where('status', 'accepted')
            ->where(function ($query) use ($threshold) {
                $query->where(function ($q) use ($threshold) {
                    $q->whereNotNull('accepted_at')
                      ->where('accepted_at', '>=', $threshold);
                })->orWhere(function ($q) use ($threshold) {
                    $q->whereNull('accepted_at')
                      ->where('updated_at', '>=', $threshold);
                });
            });
    }

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addHistory(string $status, $by = null)
    {
        $history = $this->status_history ?? [];
        $history[] = [
            'status' => $status,
            'at' => now()->toDateTimeString(),
            'by' => $by,
        ];
        $this->status_history = $history;
        $this->save();
    }
}
