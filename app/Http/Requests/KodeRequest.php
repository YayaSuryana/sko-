<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KodeRequest extends FormRequest
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
				'nama' => ["required"],
				'Keterangan' => ["required"],

            ];
        }
        return [
			'nama' => ["required"],
			'Keterangan' => ["required"],

        ];
    }
}