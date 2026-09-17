<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'specialization',
        'str_number',
        'phone',
        'email',
        'photo',
        'practice_days',
        'start_time',
        'end_time',
        'is_available',
        'bio',
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }
}