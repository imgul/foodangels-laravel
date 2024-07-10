<?php

namespace App\Http\Requests;

use App\Models\Coupon;
use App\Models\Discount;
use App\Enums\DiscountType;
use Illuminate\Foundation\Http\FormRequest;

class PromoRequest extends FormRequest
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

            'name'          => ['required', 'string'],
            'amount'        => ['required', 'numeric'],
            'restaurant_id' => ['nullable', 'numeric'],
            'status'        => ['required', 'numeric'],
            'from_date'     => ['required', 'date'],
            'to_date'       => ['required', 'date'],

        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (request('amount') > 99) {
                $validator->errors()->add('amount', 'Amount can\'t be greater than 99.');
            }
            if($this->checkToDate() == true ){
                $validator->errors()->add('to_date', 'To date can\'t be older than now.');
            }
            if(strtotime(request('to_date')) < strtotime(request('from_date'))){
                $validator->errors()->add('to_date', 'To date can\'t be older than From date.');
            }
        });
    }

    public function checkToDate(){
        $today =strtotime(date('Y/m/d h:i:s'));
        if (strtotime(request('to_date')) < $today) {
            return true;
        }
    }

}
