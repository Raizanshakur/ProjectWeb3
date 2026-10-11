<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Child extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'gender',
        'birth_date',
        'birth_weight',
        'birth_height',
        'photo',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function growthRecords()
    {
        return $this->hasMany(GrowthRecord::class);
    }

    public function mealRecords()
    {
        return $this->hasMany(MealRecord::class);
    }

    public function foodAnalyses()
    {
        return $this->hasMany(FoodAnalysis::class);
    }

    public function aiChats()
    {
        return $this->hasMany(AiChat::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    /**
     * Relasi ke catatan pertumbuhan terbaru anak berdasarkan tanggal pengukuran.
     */
    public function latestGrowthRecord()
    {
        return $this->hasOne(GrowthRecord::class)->ofMany([
            'measurement_date' => 'max',
            'id' => 'max',
        ]);
    }

    /**
     * Hitung usia anak dalam bulan bulat (integer), mencegah desimal float panjang.
     */
    public function getAgeInMonthsAttribute(): int
    {
        return $this->birth_date ? (int) floor($this->birth_date->diffInMonths(now())) : 0;
    }

    /**
     * Format usia anak yang rapi (misal "2 th 3 bln" atau "5 bulan").
     */
    public function getFormattedAgeAttribute(): string
    {
        if (!$this->birth_date) {
            return '-';
        }

        $age = $this->birth_date->diff(now());

        if ($age->y > 0) {
            return $age->m > 0 ? "{$age->y} th {$age->m} bln" : "{$age->y} tahun";
        }

        return "{$age->m} bulan";
    }
}