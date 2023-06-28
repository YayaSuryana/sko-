<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AtletRequest extends FormRequest
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
				'tempatLahir' => ["required"],
				'tanggalLahir' => ["required"],
				'nisn' => ["required"],
				'tingkatPendidikan' => ["required"],
				'alamat' => ["required"],
				'cabor' => ["required"],
				'nomor' => ["required"],
				'foto' => ["file","mimes:png,jpeg,jpg","image"],

            ];
        }
        return [
			'nama' => ["required"],
			'tempatLahir' => ["required"],
			'tanggalLahir' => ["required"],
			'nisn' => ["required"],
			'tingkatPendidikan' => ["required"],
			'alamat' => ["required"],
			'cabor' => ["required"],
			'nomor' => ["required"],
			'foto' => ["required","file","mimes:png,jpeg,jpg","image"],

        ];
    }
}
