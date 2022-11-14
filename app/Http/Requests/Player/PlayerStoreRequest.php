<?php

namespace App\Http\Requests\Player;

use Illuminate\Foundation\Http\FormRequest;

class PlayerStoreRequest extends FormRequest
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
            'first_name'    => ['required', 'string', 'max:50'],
            'last_name'     => ['required', 'string', 'max:50'],
            'gender'        => ['required', 'in:male,female'],
            'skill'         => ['required', 'integer', 'min:0', 'max:100'],
            'strength'      => ['required', 'integer', 'min:0', 'max:100'],
            'speed'         => ['required', 'integer', 'min:0', 'max:100'],
            'reaction'      => ['required', 'integer', 'min:0', 'max:100']
        ];
    }
}
