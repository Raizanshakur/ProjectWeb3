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
}