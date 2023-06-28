<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profileatlet extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'profileatlets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'nama',
		'no_kk',
		'nisn',
		'alamat_domisili',
		'kelas',
		'tempat_lahir',
		'tanggal_lahir',
		'gol_darah',
		'jenis_kelamin',
		'cabor',
		'nomor_cabor1',
		'nomor_cabor2',
		'nomor_cabor3',
		'nomor_cabor4',
		'tinggi_badan',
		'berat_badan',
		'provinsi',
		'asal_pembinaan',
		'foto',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * some columns model type
     *
     * @var array
     */
    const TYPES = [
	];

    /**
     * Default with relationship
     *
     * @var array
     */
    protected $with = [];

    public function scopeSearch($query)
    {
        return $query->where('nama','like','%'.request('search').'%')->Orwhere('nisn','like','%'.request('search').'%');
    }
}
