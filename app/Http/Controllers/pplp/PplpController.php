<?php

namespace App\Http\Controllers\pplp;

use App\Http\Controllers\Controller;
use App\Exports\ProfileatletExport;
use App\Http\Requests\ProfileatletRequest;
use App\Imports\ProfileatletImport;
use App\Models\Profileatlet;
use App\Models\Cabor;
use App\Models\Kode;
use App\Repositories\ProfileatletRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\UserRepository;
use App\Services\EmailService;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Barryvdh\DomPDF\Facade as PDF;

class PplpController extends Controller
{

  /**
   * exportable
   *
   * @var bool
   */
  private bool $exportable = false;

  /**
   * importable
   *
   * @var bool
   */
  private bool $importable = false;

  /**
   * constructor method
   *
   * @return void
   */
  // public function __construct()
  // {
  //     $this->profileatletRepository      = new ProfileatletRepository;
  //     $this->fileService            = new FileService;
  //     $this->emailService           = new EmailService;
  //     $this->NotificationRepository = new NotificationRepository;
  //     $this->UserRepository         = new UserRepository;
  //
  //     $this->middleware('can:Profileatlet');
  //     $this->middleware('can:Profileatlet Tambah')->only(['create', 'store']);
  //     $this->middleware('can:Profileatlet Ubah')->only(['edit', 'update']);
  //     $this->middleware('can:Profileatlet Hapus')->only(['destroy']);
  //     $this->middleware('can:Profileatlet Ekspor')->only(['json', 'excel', 'csv', 'pdf']);
  //     $this->middleware('can:Profileatlet Impor Excel')->only(['importExcel', 'importExcelExample']);
  // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $user = auth()->user();
      return view('stisla.profileatlets.index', [
          // 'data'             => $this->profileatletRepository->getLatest(),
          'data'             => Profileatlet::latest()->search()->where('asal_pembinaan',6)->paginate(15),
          'canCreate'        => $user->can('Profileatlet Tambah'),
          'canUpdate'        => $user->can('Profileatlet Ubah'),
          'canDelete'        => $user->can('Profileatlet Hapus'),
          'canImportExcel'   => $user->can('Order Impor Excel') && $this->importable,
          'canExport'        => $user->can('Order Ekspor') && $this->exportable,
          'title'            => __('Atlet PPLP'),
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
