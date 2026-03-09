<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // Cases filed by this citizen
    public function cases()
    {
        return $this->hasMany(\App\Models\DivorceCase::class);
    }

    // Cases assigned to this judge
    public function assignedCases()
    {
        return $this->hasMany(\App\Models\DivorceCase::class, 'judge_id');
    }

    public function notifications()
{
    return $this->hasMany(\App\Models\Notification::class)->latest();
}

public function unreadNotifications()
{
    return $this->hasMany(\App\Models\Notification::class)->where('is_read', false)->latest();
}
}

