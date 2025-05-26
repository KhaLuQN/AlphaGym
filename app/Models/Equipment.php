<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $fillable = [
        'name',
        'img',
        'purchase_date',
        'status',
        'location',
        'notes',
    ];

    protected $dates = [
        'purchase_date',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'purchase_date' => 'date:Y-m-d',
    ];
}
