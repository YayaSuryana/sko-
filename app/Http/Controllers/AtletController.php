<?php

namespace App\Http\Controllers;

use App\Exports\AtletExport;
use App\Http\Requests\AtletRequest;
use App\Imports\AtletImport;
use App\Models\Atlet;
use App\Repositories\AtletRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\UserRepository;
use App\Services\EmailService;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Barryvdh\DomPDF\Facade as PDF;

// MY IMPORT
use App\Models\Cabor;
use App\Models\Prestasi;
use App\Models\Masterevent;
use App\Models\Event;

class AtletController extends Controller
{
    /**
     * atletRepository
     *
     * @var AtletRepository
     */
    private AtletRepository $atletRepository;

    /**
     * NotificationRepository
     *
     * @var NotificationRepository
     */
    private NotificationRepository $NotificationRepository;

    /**
     * UserRepository
     *
     * @var UserRepository
     */
    private UserRepository $UserRepository;

    /**
     * file service
     *
     * @var FileService
     */
    private FileService $fileService;

    /**
     * email service
     *
     * @var FileService
     */
    private EmailService $emailService;
    
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
    public function __construct()
    {
        $this->atletRepository      = new AtletRepository;
        $this->fileService            = new FileService;
        $this->emailService           = new EmailService;
        $this->NotificationRepository = new NotificationRepository;
        $this->UserRepository         = new UserRepository;

        $this->middleware('can:Atlet');
        $this->middleware('can:Atlet Tambah')->only(['create', 'store']);
        $this->middleware('can:Atlet Ubah')->only(['edit', 'update']);
        $this->middleware('can:Atlet Hapus')->only(['destroy']);
        $this->middleware('can:Atlet Ekspor')->only(['json', 'excel', 'csv', 'pdf']);
        $this->middleware('can:Atlet Impor Excel')->only(['importExcel', 'importExcelExample']);
    }

    /**
     * showing data page
     *
     * @return Response
     */
    public function index()
    {
        $user = auth()->user();
        return view('stisla.atlets.index', [
            'data'             => $this->atletRepository->getLatest(),
            'canCreate'        => $user->can('Atlet Tambah'),
            'canUpdate'        => $user->can('Atlet Ubah'),
            'canDelete'        => $user->can('Atlet Hapus'),
            'canImportExcel'   => $user->can('Order Impor Excel') && $this->importable,
            'canExport'        => $user->can('Order Ekspor') && $this->exportable,
            'title'            => __('Atlet'),
            'cabor'            => Cabor::all(),
            'routeCreate'      => route('atlets.create'),
            'routePdf'         => route('atlets.pdf'),
            'routePrint'       => route('atlets.print'),
            'routeExcel'       => route('atlets.excel'),
            'routeCsv'         => route('atlets.csv'),
            'routeJson'        => route('atlets.json'),
            'routeImportExcel' => route('atlets.import-excel'),
            'excelExampleLink' => route('atlets.import-excel-example'),
        ]);
    }

    /**
     * showing add new data form page
     *
     * @return Response
     */
    public function create()
    {
        return view('stisla.atlets.form', [
            'title'         => __('Atlet'),
            'fullTitle'     => __('Tambah Atlet'),
            'collections'   => Cabor::all(),
            'routeIndex'    => route('atlets.index'),
            'action'        => route('atlets.store')
        ],);
    }

    /**
     * save new data to db
     *
     * @param AtletRequest $request
     * @return Response
     */
    public function store(AtletRequest $request)
    {
        $data = $request->only([
			'nama',
			'tempatLahir',
			'tanggalLahir',
			'nisn',
			'tingkatPendidikan',
			'alamat',
			'cabor',
			'nomor',
			'foto',
        ]);

        // gunakan jika ada file
        if ($request->hasFile('foto')) {
            $data['foto'] = $this->fileService->uploadFoto($request->file('foto'));
        }

        $result = $this->atletRepository->create($data);

        // use this if you want to create notification data
        // $title = 'Notify Title';
        // $content = 'lorem ipsum dolor sit amet';
        // $userId = 2;
        // $notificationType = 'transaksi masuk';
        // $icon = 'bell'; // font awesome
        // $bgColor = 'primary'; // primary, danger, success, warning
        // $this->NotificationRepository->createNotif($title,  $content, $userId,  $notificationType, $icon, $bgColor);

        // gunakan jika mau kirim email
        // $this->emailService->methodName($result);

        logCreate("Atlet", $result);

        $successMessage = successMessageCreate("Atlet");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * showing edit page
     *
     * @param Atlet $atlet
     * @return Response
     */
    public function edit(Atlet $atlet)
    {
        return view('stisla.atlets.form', [
            'd'             => $atlet,
            'title'         => __('Atlet'),
            'fullTitle'     => __('Ubah Atlet'),
            'routeIndex'    => route('atlets.index'),
            'collections'   =>  Cabor::all(),
            'action'        => route('atlets.update', [$atlet->id])
        ]);
    }

    /**
     * update data to db
     *
     * @param AtletRequest $request
     * @param Atlet $atlet
     * @return Response
     */
    public function update(AtletRequest $request, Atlet $atlet)
    {
        $data = $request->only([
			'nama',
			'tempatLahir',
			'tanggalLahir',
			'nisn',
			'tingkatPendidikan',
			'alamat',
			'cabor',
			'nomor',
			'foto',
        ]);
        
        // gunakan jika ada file
        if ($request->hasFile('foto')) {
            $data['foto'] = $this->fileService->uploadFoto($request->file('foto'));
        }

        $newData = $this->atletRepository->update($data, $atlet->id);

        // use this if you want to create notification data
        // $title = 'Notify Title';
        // $content = 'lorem ipsum dolor sit amet';
        // $userId = 2;
        // $notificationType = 'transaksi masuk';
        // $icon = 'bell'; // font awesome
        // $bgColor = 'primary'; // primary, danger, success, warning
        // $this->NotificationRepository->createNotif($title,  $content, $userId,  $notificationType, $icon, $bgColor);

        // gunakan jika mau kirim email
        // $this->emailService->methodName($newData);

        logUpdate("Atlet", $atlet, $newData);

        $successMessage = successMessageUpdate("Atlet");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    public function show($id)
    {
        $data       = Atlet::find($id);
        $cabor      = Cabor::find($data->cabor);
        $prestasi   = Prestasi::where('atlet_id', $data->id)->get();
        // dd($data->cabors('nama'));
        return view('stisla.atlets.show', [
            'title'         => __('Detail Atlet'),
            'fullTitle'     => __('Detail Atlet'),
            'master'            => Masterevent::all(),
            'event'            => event::all(),
        ],compact('data','cabor','prestasi'));
    }

    /**
     * delete user from db
     *
     * @param Atlet $atlet
     * @return Response
     */
    public function destroy(Atlet $atlet)
    {
        // delete file from storage if exists
        $this->fileService->deleteFoto($atlet);

        // use this if you want to create notification data
        // $title = 'Notify Title';
        // $content = 'lorem ipsum dolor sit amet';
        // $userId = 2;
        // $notificationType = 'transaksi masuk';
        // $icon = 'bell'; // font awesome
        // $bgColor = 'primary'; // primary, danger, success, warning
        // $this->NotificationRepository->createNotif($title,  $content, $userId,  $notificationType, $icon, $bgColor);

        // gunakan jika mau kirim email
        // $this->emailService->uploadFoto($atlet);

        $this->atletRepository->delete($atlet->id);
        logDelete("Atlet", $atlet);

        $successMessage = successMessageDelete("Atlet");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * download import example
     *
     * @return BinaryFileResponse
     */
    public function importExcelExample(): BinaryFileResponse
    {
        // bisa gunakan file excel langsung sebagai contoh
        // $filepath = public_path('example.xlsx');
        // return response()->download($filepath);

        $data = $this->atletRepository->getLatest();
        return Excel::download(new AtletExport($data), 'atlets.xlsx');
    }

    /**
     * import excel file to db
     *
     * @param \App\Http\Requests\ImportExcelRequest $request
     * @return Response
     */
    public function importExcel(\App\Http\Requests\ImportExcelRequest $request)
    {
        Excel::import(new AtletImport, $request->file('import_file'));
        $successMessage = successMessageImportExcel("Atlet");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * download export data as json
     *
     * @return Response
     */
    public function json()
    {
        $data = $this->atletRepository->getLatest();
        return $this->fileService->downloadJson($data, 'atlets.json');
    }

    /**
     * download export data as xlsx
     *
     * @return Response
     */
    public function excel()
    {
        $data = $this->atletRepository->getLatest();
        return (new AtletExport($data))->download('atlets.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * download export data as csv
     *
     * @return Response
     */
    public function csv()
    {
        $data = $this->atletRepository->getLatest();
        return (new AtletExport($data))->download('atlets.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * download export data as pdf
     *
     * @return Response
     */
    public function pdf()
    {
        $data = $this->atletRepository->getLatest();
        return PDF::setPaper('Letter', 'landscape')
            ->loadView('stisla.atlets.export-pdf', [
                'data'    => $data,
                'isPrint' => false
            ])
            ->download('atlets.pdf');
    }

    /**
     * export data to print html
     *
     * @return Response
     */
    public function exportPrint()
    {
        $data = $this->atletRepository->getLatest();
        return view('stisla.atlets.export-pdf', [
            'data'    => $data,
            'isPrint' => true
        ]);
    }
}
