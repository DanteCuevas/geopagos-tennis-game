<?php

namespace App\Http\Requests\Tournament;

use Illuminate\Foundation\Http\FormRequest;

class TournamentIndexRequest extends FormRequest
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
            'date_start'    => ['date_format:Y-m-d'],
            'date_end'      => ['date_format:Y-m-d'],
            'gender'        => ['in:male,female'],
            'winner_id'     => ['integer', 'integer', 'exists:players,id'],
            'winner_name'   => ['string', 'max:50']
        ];
    }

    public function messages()
    {
        return [
            'gender.in'     => 'The selected gender only accept [male, female]',
            'winner_id.exists'     => 'The selected winner id is invalid player id.'
        ];
    }

}
