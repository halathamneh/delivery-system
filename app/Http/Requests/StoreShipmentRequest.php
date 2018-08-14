<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreShipmentRequest extends FormRequest
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
            'shipment_client.type' => 'required',
            'shipment_client.account_number' => 'required_if:shipment_client.type,client',
            'shipment_client.name' => 'required_if:shipment_client.type,guest',
            'shipment_client.phone_number' => 'required_if:shipment_client.type,guest',
            'waybill' => 'required|integer',
            'delivery_date' => 'required',
            'courier' => 'required',
            'consignee_name' => 'required',
            'phone_number' => 'required',
            'address_from_zones' => 'required',
            'service_type' => [
                Rule::in(['nextday', 'sameday']),
            ],
            'delivery_cost_lodger' => [
                Rule::in(['client', 'courier']),
            ],
        ];
    }
}