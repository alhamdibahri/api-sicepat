<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'waybill_number',
        'kodeasal',
        'kodetujuan',
        'service',
        'weight',
        'partner',
        'sender',
        'sender_address',
        'receiver_address',
        'receiver_name',
        'realprice',
        'totalprice',
        'POD_receiver',
        'POD_receiver_time',
        'send_date',
        'perwakilan',
        'pop_sigesit_img_path',
        'pod_sigesit_img_path',
        'pod_sign_img_path',
        'pod_img_path',
        'manifested_img_path',
    ];

    public function tracking_details(){
        return $this->hasMany(TrackingDetail::class, 'tracking_id');
    }
}
