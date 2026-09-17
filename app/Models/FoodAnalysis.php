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
    ];

    protected $casts = [
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
}