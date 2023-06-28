<?php

namespace App\Http\Controllers\sko;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profileatlet;

class SkoStatistikController extends Controller
{
  public function statistik()
  {
      return view('stisla.profileatlets.sko.statistik',[
        'title'         => __('Statistik Atlet SKO'),
        'laki'          => Profileatlet::where('jenis_kelamin',4)->where('asal_pembinaan',7)->count(),
        'perempuan'     => Profileatlet::where('jenis_kelamin',5)->where('asal_pembinaan',7)->count(),
      ]);
  }
}
