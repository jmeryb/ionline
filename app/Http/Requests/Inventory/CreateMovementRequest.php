<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class CreateMovementRequest extends FormRequest
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
            'installation_date'     => 'nullable|date_format:Y-m-d',
            'place_id'              => 'required|exists:cfg_places,id',
            'user_responsible_id'   => 'required|exists:users,id',
            'user_using_id'         => 'nullable|exists:users,id',
        ];
    }
}
