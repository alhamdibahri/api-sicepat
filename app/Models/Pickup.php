<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pickup extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_number',
        'pickup_request_date',
        'pickup_merchant_name',
        'pickup_address',
        'pickup_city',
        'pickup_merchant_phone',
    ];

    public function package_list(){
        return $this->hasMany(PackageList::class, 'pickup_id');
    }
}
