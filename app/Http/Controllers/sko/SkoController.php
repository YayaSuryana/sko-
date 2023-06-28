<?php

namespace App\Http\Controllers\sko;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profileatlet;
use App\Models\Kode;
use App\Models\Cabor;

class SkoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $user = auth()->user();
      return view('stisla.profileatlets.sko', [
          // 'data'             => $this->profileatletRepository->getLatest(),
          'data'             => Profileatlet::search()->where('asal_pembinaan',7)->paginate(15),
          'canCreate'        => $user->can('Profileatlet Tambah'),
          'canUpdate'        => $user->can('Profileatlet Ubah'),
          'canDelete'        => $user->can('Profileatlet Hapus'),
          'canImportExcel'   => $user->can('Order Impor Excel') && $this->importable,
          'canExport'        => $user->can('Order Ekspor') && $this->exportable,
          'title'            => __('Atlet SKO'),
          'kode'             => Kode::all(),
          'cabor'            => Cabor::all(),
          'routeCreate'      => route('profileatlets.create'),
          'routePdf'         => route('profileatlets.pdf'),
          'routePrint'       => route('profileatlets.print'),
          'routeExcel'       => route('profileatlets.excel'),
          'routeCsv'         => route('profileatlets.csv'),
          'routeJson'        => route('profileatlets.json'),
          'routeImportExcel' => route('profileatlets.import-excel'),
          'excelExampleLink' => route('profileatlets.import-excel-example'),
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
