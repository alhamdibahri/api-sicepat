<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_id',
        'date_time',
        'status',
        'city'
    ];

    public function tracking(){
        return $this->belongsTo(Tracking::class, 'tracking_id');
    }
}
