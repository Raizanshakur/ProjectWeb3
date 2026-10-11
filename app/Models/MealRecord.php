<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'child_id',
        'food_analysis_id',
        'food_name',
        'meal_type',
        'portion_text',
        'consumed_at',
        'calories',
        'protein',
        'carbohydrates',
        'fat',
        'fiber',
        'source',
        'notes',
    ];

    protected $casts = [
        'consumed_at' => 'datetime',
        'calories' => 'decimal:2',
        'protein' => 'decimal:2',
        'carbohydrates' => 'decimal:2',
        'fat' => 'decimal:2',
        'fiber' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function foodAnalysis()
    {
        return $this->belongsTo(FoodAnalysis::class);
    }
}
