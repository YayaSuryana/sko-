<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profileatlet;
use App\Models\Kode;
use App\Models\Cabor;

class ShowController extends Controller
{
    public function show($id)
    {
      $data = Profileatlet::find($id);
      $cabor = Cabor::find($data->cabor);
      $golonganDarah = Kode::find($data->gol_darah);
      $provinsi = Kode::find($data->provinsi);
      $asal_pembinaan = Kode::find($data->asal_pembinaan);
      return view('stisla.profileatlets.show',[
        'title'            => __('Detail Atlet'),
      ], compact('data','cabor','golonganDarah','provinsi','asal_pembinaan'));
    }
}
