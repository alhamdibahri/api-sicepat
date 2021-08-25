<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageList extends Model
{
    use HasFactory;

    protected $fillable = [
        'pickup_id',
        'receipt_number',
        'origin_code',
        'delivery_type',
        'parcel_content',
        'parcel_category',
        'parcel_qty',
        'parcel_uom',
        'parcel_value',
        'total_weight',
        'shipper_name',
        'shipper_address',
        'shipper_province',
        'shipper_city',
        'shipper_district',
        'shipper_zip',
        'shipper_phone',
        'shipper_longitude',
        'shipper_latitude',
        'recipient_title',
        'recipient_name',
        'recipient_address',
        'recipient_province',
        'recipient_city',
        'recipient_district',
        'recipient_zip',
        'recipient_phone',
        'recipient_longitude',
        'recipient_latitude',
        'destination_code',
    ];

    public function pickup(){
        return $this->belongsTo(Pickup::class, 'pickup_id');
    }

    public static function boot() {
        parent::boot();

        static::deleted(function($pickup) {
            if($pickup->where('pickup_id', $pickup->pickup_id)->count() == 0) {
                $pickup->pickup()->delete();
            }
        });
    }
}
