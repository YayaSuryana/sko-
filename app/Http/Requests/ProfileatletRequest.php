<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileatletRequest extends FormRequest
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
				'no_kk' => ["required"],
				'nisn' => ["required"],
				'alamat_domisili' => ["required"],
				'kelas' => ["required"],
				'tempat_lahir' => ["required"],
				'tanggal_lahir' => ["required"],
				'gol_darah' => ["required"],
				'jenis_kelamin' => ["required"],
				'cabor' => ["required"],
				'nomor_cabor1' => ["required"],
				'nomor_cabor2' => ["required"],
				'nomor_cabor3' => ["required"],
				'nomor_cabor4' => ["required"],
				'tinggi_badan' => ["required"],
				'berat_badan' => ["required"],
				'provinsi' => ["required"],
				'asal_pembinaan' => ["required"],
				'foto' => ["required","file","image","mimes:png,jpeg,jpg"],

            ];
        }
        return [
			'nama' => ["required"],
			'no_kk' => ["required"],
			'nisn' => ["required"],
			'alamat_domisili' => ["required"],
			'kelas' => ["required"],
			'tempat_lahir' => ["required"],
			'tanggal_lahir' => ["required"],
			'gol_darah' => ["required"],
			'jenis_kelamin' => ["required"],
			'cabor' => ["required"],
			'nomor_cabor1' => ["required"],
			'nomor_cabor2' => ["required"],
			'nomor_cabor3' => ["required"],
			'nomor_cabor4' => ["required"],
			'tinggi_badan' => ["required"],
			'berat_badan' => ["required"],
			'provinsi' => ["required"],
			'asal_pembinaan' => ["required"],
			'foto' => ["required","file","image","mimes:png,jpeg,jpg"],

        ];
    }
}
