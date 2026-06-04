<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Application;
use App\Models\User;

class Lowongan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'company', 'location', 'type', 'seniority', 'salary_range', 'lama_kerja', 'description', 'requirements', 'is_featured'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_lowongans', 'lowongan_id', 'user_id')
            ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
