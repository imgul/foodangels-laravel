<?php

namespace App\Http\Requests;

use App\Models\MenuItemType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuItemTypeRequest extends FormRequest
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
            'name'   => ['required', 'string', 'max:255'],
            'status' => ['required', 'numeric'],

        ];
    }

    public function attributes()
    {
        return [
            'name'   => trans('validation.attributes.name'),
            'status' => trans('validation.attributes.status'),
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->MenuItemTypeNameUniqueCheck()) {
                $validator->errors()->add('name', 'The Menu item type  name already exists.');
            }

        });
    }

    private function MenuItemTypeNameUniqueCheck()
    {
        $id                          = $this->menu_items_type;

        $queryArray['name']          = request('name');

        $units = MenuItemType::where($queryArray)->where('id', '!=', $id)->first();

        if (blank($units)) {
            return false;
        }
        return true;
    }

}
