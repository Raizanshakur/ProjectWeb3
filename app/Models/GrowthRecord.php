<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrowthRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'measurement_date',
        'weight',
        'height',
        'head_circumference',
        'nutrition_status',
        'notes',
    ];

    protected $casts = [
        'measurement_date' => 'date',
        'weight' => 'decimal:2',
        'height' => 'decimal:2',
        'head_circumference' => 'decimal:2',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    /**
     * Usia anak dalam bulan bulat saat pengukuran dilakukan.
     */
    public function getAgeAtMeasurementInMonthsAttribute(): int
    {
        if (!$this->child || !$this->child->birth_date || !$this->measurement_date) {
            return 0;
        }

        if ($this->measurement_date->lt($this->child->birth_date)) {
            return 0;
        }

        return (int) floor($this->child->birth_date->diffInMonths($this->measurement_date));
    }

    /**
     * Format teks usia anak saat pengukuran (misal "1 th 2 bln" atau "8 bulan").
     */
    public function getAgeAtMeasurementFormattedAttribute(): string
    {
        if (!$this->child || !$this->child->birth_date || !$this->measurement_date) {
            return '-';
        }

        if ($this->measurement_date->lt($this->child->birth_date)) {
            return '-';
        }

        $diff = $this->child->birth_date->diff($this->measurement_date);

        if ($diff->y > 0) {
            return $diff->m > 0 ? "{$diff->y} th {$diff->m} bln" : "{$diff->y} tahun";
        }

        if ($diff->m > 0) {
            return "{$diff->m} bulan";
        }

        if ($diff->d > 0) {
            return "{$diff->d} hari";
        }

        return "0 bulan";
    }
}