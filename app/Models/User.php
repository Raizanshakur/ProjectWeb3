<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'role',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ── Role Helpers ─────────────────────────────────────

    public function isParent(): bool
    {
        return $this->role === 'parent';
    }

    public function isDoctor(): bool
    {
        return $this->role === 'doctor';
    }

    // ── Relationships ────────────────────────────────────

    public function doctor(): HasOne
    {
        return $this->hasOne(Doctor::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(Child::class);
    }

    public function consultations(): HasMany
    {
        return $this->hasMany(Consultation::class);
    }

    public function foodAnalyses(): HasMany
    {
        return $this->hasMany(FoodAnalysis::class);
    }

    public function aiChats(): HasMany
    {
        return $this->hasMany(AiChat::class);
    }
}
