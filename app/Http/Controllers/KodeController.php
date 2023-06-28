<?php

namespace App\Http\Controllers;

use App\Exports\KodeExport;
use App\Http\Requests\KodeRequest;
use App\Imports\KodeImport;
use App\Models\Kode;
use App\Repositories\KodeRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\UserRepository;
use App\Services\EmailService;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Barryvdh\DomPDF\Facade as PDF;

class KodeController extends Controller
{
    /**
     * kodeRepository
     *
     * @var KodeRepository
     */
    private KodeRepository $kodeRepository;

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
        $this->kodeRepository      = new KodeRepository;
        $this->fileService            = new FileService;
        $this->emailService           = new EmailService;
        $this->NotificationRepository = new NotificationRepository;
        $this->UserRepository         = new UserRepository;

        $this->middleware('can:Kode');
        $this->middleware('can:Kode Tambah')->only(['create', 'store']);
        $this->middleware('can:Kode Ubah')->only(['edit', 'update']);
        $this->middleware('can:Kode Hapus')->only(['destroy']);
        $this->middleware('can:Kode Ekspor')->only(['json', 'excel', 'csv', 'pdf']);
        $this->middleware('can:Kode Impor Excel')->only(['importExcel', 'importExcelExample']);
    }

    /**
     * showing data page
     *
     * @return Response
     */
    public function index()
    {
        $user = auth()->user();
        return view('stisla.kodes.index', [
            'data'             => $this->kodeRepository->getLatest(),
            'canCreate'        => $user->can('Kode Tambah'),
            'canUpdate'        => $user->can('Kode Ubah'),
            'canDelete'        => $user->can('Kode Hapus'),
            'canImportExcel'   => $user->can('Order Impor Excel') && $this->importable,
            'canExport'        => $user->can('Order Ekspor') && $this->exportable,
            'title'            => __('Kode'),
            'routeCreate'      => route('kodes.create'),
            'routePdf'         => route('kodes.pdf'),
            'routePrint'       => route('kodes.print'),
            'routeExcel'       => route('kodes.excel'),
            'routeCsv'         => route('kodes.csv'),
            'routeJson'        => route('kodes.json'),
            'routeImportExcel' => route('kodes.import-excel'),
            'excelExampleLink' => route('kodes.import-excel-example'),
        ]);
    }

    /**
     * showing add new data form page
     *
     * @return Response
     */
    public function create()
    {
        return view('stisla.kodes.form', [
            'title'         => __('Kode'),
            'fullTitle'     => __('Tambah Kode'),
            'routeIndex'    => route('kodes.index'),
            'action'        => route('kodes.store')
        ]);
    }

    /**
     * save new data to db
     *
     * @param KodeRequest $request
     * @return Response
     */
    public function store(KodeRequest $request)
    {
        $data = $request->only([
			'nama',
			'Keterangan',
        ]);

        // gunakan jika ada file
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->methodName($request->file('file'));
        // }

        $result = $this->kodeRepository->create($data);

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

        logCreate("Kode", $result);

        $successMessage = successMessageCreate("Kode");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * showing edit page
     *
     * @param Kode $kode
     * @return Response
     */
    public function edit(Kode $kode)
    {
        return view('stisla.kodes.form', [
            'd'             => $kode,
            'title'         => __('Kode'),
            'fullTitle'     => __('Ubah Kode'),
            'routeIndex'    => route('kodes.index'),
            'action'        => route('kodes.update', [$kode->id])
        ]);
    }

    /**
     * update data to db
     *
     * @param KodeRequest $request
     * @param Kode $kode
     * @return Response
     */
    public function update(KodeRequest $request, Kode $kode)
    {
        $data = $request->only([
			'nama',
			'Keterangan',
        ]);

        // gunakan jika ada file
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->methodName($request->file('file'));
        // }

        $newData = $this->kodeRepository->update($data, $kode->id);

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

        logUpdate("Kode", $kode, $newData);

        $successMessage = successMessageUpdate("Kode");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * delete user from db
     *
     * @param Kode $kode
     * @return Response
     */
    public function destroy(Kode $kode)
    {
        // delete file from storage if exists
        // $this->fileService->methodName($kode);

        // use this if you want to create notification data
        // $title = 'Notify Title';
        // $content = 'lorem ipsum dolor sit amet';
        // $userId = 2;
        // $notificationType = 'transaksi masuk';
        // $icon = 'bell'; // font awesome
        // $bgColor = 'primary'; // primary, danger, success, warning
        // $this->NotificationRepository->createNotif($title,  $content, $userId,  $notificationType, $icon, $bgColor);

        // gunakan jika mau kirim email
        // $this->emailService->methodName($kode);

        $this->kodeRepository->delete($kode->id);
        logDelete("Kode", $kode);

        $successMessage = successMessageDelete("Kode");
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

        $data = $this->kodeRepository->getLatest();
        return Excel::download(new KodeExport($data), 'kodes.xlsx');
    }

    /**
     * import excel file to db
     *
     * @param \App\Http\Requests\ImportExcelRequest $request
     * @return Response
     */
    public function importExcel(\App\Http\Requests\ImportExcelRequest $request)
    {
        Excel::import(new KodeImport, $request->file('import_file'));
        $successMessage = successMessageImportExcel("Kode");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * download export data as json
     *
     * @return Response
     */
    public function json()
    {
        $data = $this->kodeRepository->getLatest();
        return $this->fileService->downloadJson($data, 'kodes.json');
    }

    /**
     * download export data as xlsx
     *
     * @return Response
     */
    public function excel()
    {
        $data = $this->kodeRepository->getLatest();
        return (new KodeExport($data))->download('kodes.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * download export data as csv
     *
     * @return Response
     */
    public function csv()
    {
        $data = $this->kodeRepository->getLatest();
        return (new KodeExport($data))->download('kodes.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * download export data as pdf
     *
     * @return Response
     */
    public function pdf()
    {
        $data = $this->kodeRepository->getLatest();
        return PDF::setPaper('Letter', 'landscape')
            ->loadView('stisla.kodes.export-pdf', [
                'data'    => $data,
                'isPrint' => false
            ])
            ->download('kodes.pdf');
    }

    /**
     * export data to print html
     *
     * @return Response
     */
    public function exportPrint()
    {
        $data = $this->kodeRepository->getLatest();
        return view('stisla.kodes.export-pdf', [
            'data'    => $data,
            'isPrint' => true
        ]);
    }
}
