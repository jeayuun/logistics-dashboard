<?php
// app/Models/AlertLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlertLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'warehouse_lat',
        'warehouse_lng',
        'delivery_lat',
        'delivery_lng',
        'radius',
        'distance',
        'within_range',
        'route_distance',
        'duration',  
    ];
}