<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PickupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reference_number' => 'required',
            'pickup_request_date' => 'required',
            'pickup_merchant_name' => 'required',
            'pickup_address' => 'required',
            'pickup_city' => 'required',
            'pickup_merchant_phone' => 'required',
            'PackageList' => 'required',
            'PackageList.*.receipt_number' => 'required',
            'PackageList.*.origin_code' => 'required',
            'PackageList.*.delivery_type' => 'required',
            'PackageList.*.parcel_category' => 'required',
            'PackageList.*.parcel_content' => 'required',
            'PackageList.*.parcel_qty' => 'required',
            'PackageList.*.parcel_uom' => 'required',
            'PackageList.*.parcel_value' => 'required',
            'PackageList.*.total_weight' => 'required',
            'PackageList.*.shipper_name' => 'required',
            'PackageList.*.shipper_address' => 'required',
            'PackageList.*.shipper_province' => 'required',
            'PackageList.*.shipper_city' => 'required',
            'PackageList.*.shipper_district' => 'required',
            'PackageList.*.shipper_zip' => 'required',
            'PackageList.*.shipper_phone' => 'required',
            'PackageList.*.recipient_title' => 'required',
            'PackageList.*.recipient_name' => 'required',
            'PackageList.*.recipient_address' => 'required',
            'PackageList.*.recipient_province' => 'required',
            'PackageList.*.recipient_city' => 'required',
            'PackageList.*.recipient_district' => 'required',
            'PackageList.*.recipient_zip' => 'required',
            'PackageList.*.recipient_phone' => 'required',
            'PackageList.*.destination_code' => 'required',
            'PackageList.*.recipient_longitude' => 'required',
            'PackageList.*.recipient_latitude' => 'required',
            'PackageList.*.shipper_longitude' => 'required',
            'PackageList.*.shipper_latitude' => 'required'
        ];
    }
}
