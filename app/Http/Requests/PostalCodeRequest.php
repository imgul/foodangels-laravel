<?php

namespace App\Http\Requests;

use App\Models\BranchPostalCode;
use App\Models\RestaurantPostalCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostalCodeRequest extends FormRequest
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

            'postal_code'     => ['required', 'string'],
            'restaurant_id'       => ['required', 'numeric'],
            'delivery_charge' => ['required', 'numeric'],
            'delivery_time'   => ['required', 'string'],
            'min_order'       => ['required', 'numeric'],
            'max_order'       => ['required', 'numeric'],

        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $postalCode = RestaurantPostalCode::where(['postal_code' => request('postal_code'), 'restaurant_id' => request('restaurant_id')])->first();
            if (!blank($postalCode)) {
                if($postalCode->id != $this->id){
                    $validator->errors()->add('postal_code', 'A postal code already exists with this restaurant ID and postal code.');
                }
            }
        });
    }
}
