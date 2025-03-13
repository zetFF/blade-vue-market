<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhyChooseUs extends Model
{
    use HasFactory;

    protected $table = 'why_choose_us';

    protected $fillable = [
        'icon',
        'title',
        'description',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}
