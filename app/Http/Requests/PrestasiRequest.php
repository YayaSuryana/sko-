<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrestasiRequest extends FormRequest
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
        if ($this->isMethod('put')) {
            return [
				'atlet_id' => ["required"],
				'masterevent_id' => ["required"],
				'event_id' => ["required"],
				'medali' => ["required"],
				'tahun' => ["required"],

            ];
        }
        return [
			'atlet_id' => ["required"],
			'masterevent_id' => ["required"],
			'event_id' => ["required"],
			'medali' => ["required"],
			'tahun' => ["required"],

        ];
    }
}
