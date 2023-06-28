<?php

namespace App\Http\Controllers\pplp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profileatlet;

class PplpStatistikController extends Controller
{
    public function statistik()
    {
        return view('stisla.profileatlets.pplp.statistik',[
          'title'         => __('Statistik Atlet PPLP'),
          'laki'     => Profileatlet::where('jenis_kelamin',4)->where('asal_pembinaan',6)->count(),
          'perempuan'     => Profileatlet::where('jenis_kelamin',5)->where('asal_pembinaan',6)->count(),
        ]);
    }
}
