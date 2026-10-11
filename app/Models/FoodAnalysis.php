<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodAnalysis extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'child_id',
        'food_name',
        'food_image',
        'calories',
        'protein',
        'carbohydrates',
        'fat',
        'fiber',
        'ai_analysis',
        'recommendation',
        'status',
        'model_used',
        'is_food',
        'portion_description',
        'visible_ingredients',
        'uncertainty_note',
        'error_message',
        'analyzed_at',
    ];

    protected $casts = [
        'calories' => 'decimal:2',
        'protein' => 'decimal:2',
        'carbohydrates' => 'decimal:2',
        'fat' => 'decimal:2',
        'fiber' => 'decimal:2',
        'is_food' => 'boolean',
        'visible_ingredients' => 'array',
        'analyzed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function mealRecord()
    {
        return $this->hasOne(MealRecord::class, 'food_analysis_id');
    }
}