<?php

namespace App\Http\Controllers;

use App\Exports\PrestasiExport;
use App\Http\Requests\PrestasiRequest;
use App\Imports\PrestasiImport;
use App\Models\Prestasi;
use App\Models\Event;
use App\Models\Atlet;
use App\Models\Masterevent;
use App\Repositories\PrestasiRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\UserRepository;
use App\Services\EmailService;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Barryvdh\DomPDF\Facade as PDF;

class PrestasiController extends Controller
{
    /**
     * prestasiRepository
     *
     * @var PrestasiRepository
     */
    private PrestasiRepository $prestasiRepository;

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
        $this->prestasiRepository      = new PrestasiRepository;
        $this->fileService            = new FileService;
        $this->emailService           = new EmailService;
        $this->NotificationRepository = new NotificationRepository;
        $this->UserRepository         = new UserRepository;

        $this->middleware('can:Prestasi');
        $this->middleware('can:Prestasi Tambah')->only(['create', 'store']);
        $this->middleware('can:Prestasi Ubah')->only(['edit', 'update']);
        $this->middleware('can:Prestasi Hapus')->only(['destroy']);
        $this->middleware('can:Prestasi Ekspor')->only(['json', 'excel', 'csv', 'pdf']);
        $this->middleware('can:Prestasi Impor Excel')->only(['importExcel', 'importExcelExample']);
    }

    /**
     * showing data page
     *
     * @return Response
     */
    public function index()
    {
        $user = auth()->user();
        return view('stisla.prestasis.index', [
            'data'             => $this->prestasiRepository->getLatest(),
            'canCreate'        => $user->can('Prestasi Tambah'),
            'canUpdate'        => $user->can('Prestasi Ubah'),
            'canDelete'        => $user->can('Prestasi Hapus'),
            'canImportExcel'   => $user->can('Order Impor Excel') && $this->importable,
            'canExport'        => $user->can('Order Ekspor') && $this->exportable,
            'title'            => __('Prestasi'),
            'routeCreate'      => route('prestasis.create'),
            'routePdf'         => route('prestasis.pdf'),
            'routePrint'       => route('prestasis.print'),
            'routeExcel'       => route('prestasis.excel'),
            'routeCsv'         => route('prestasis.csv'),
            'routeJson'        => route('prestasis.json'),
            'routeImportExcel' => route('prestasis.import-excel'),
            'excelExampleLink' => route('prestasis.import-excel-example'),
        ]);
    }

    /**
     * showing add new data form page
     *
     * @return Response
     */
    public function create()
    {
        return view('stisla.prestasis.form', [
            'title'             => __('Prestasi'),
            'fullTitle'         => __('Tambah Prestasi'),
            'collectionsAtlet'  => Atlet::all(),
            'collectionsMaster' => Masterevent::all(),
            'collectionsEvent'  => Event::all(),
            'routeIndex'        => route('prestasis.index'),
            'action'            => route('prestasis.store')
        ]);
    }

    /**
     * save new data to db
     *
     * @param PrestasiRequest $request
     * @return Response
     */
    public function store(PrestasiRequest $request)
    {
        $data = $request->only([
			'atlet_id',
			'masterevent_id',
			'event_id',
			'medali',
			'tahun',
        ]);

        // gunakan jika ada file
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->methodName($request->file('file'));
        // }

        $result = $this->prestasiRepository->create($data);

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

        logCreate("Prestasi", $result);

        $successMessage = successMessageCreate("Prestasi");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * showing edit page
     *
     * @param Prestasi $prestasi
     * @return Response
     */
    public function edit(Prestasi $prestasi)
    {
        return view('stisla.prestasis.form', [
            'd'             => $prestasi,
            'title'         => __('Prestasi'),
            'fullTitle'     => __('Ubah Prestasi'),
            'routeIndex'    => route('prestasis.index'),
            'action'        => route('prestasis.update', [$prestasi->id])
        ]);
    }

    /**
     * update data to db
     *
     * @param PrestasiRequest $request
     * @param Prestasi $prestasi
     * @return Response
     */
    public function update(PrestasiRequest $request, Prestasi $prestasi)
    {
        $data = $request->only([
			'atlet_id',
			'masterevent_id',
			'event_id',
			'medali',
			'tahun',
        ]);

        // gunakan jika ada file
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->methodName($request->file('file'));
        // }

        $newData = $this->prestasiRepository->update($data, $prestasi->id);

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

        logUpdate("Prestasi", $prestasi, $newData);

        $successMessage = successMessageUpdate("Prestasi");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * delete user from db
     *
     * @param Prestasi $prestasi
     * @return Response
     */
    public function destroy(Prestasi $prestasi)
    {
        // delete file from storage if exists
        // $this->fileService->methodName($prestasi);

        // use this if you want to create notification data
        // $title = 'Notify Title';
        // $content = 'lorem ipsum dolor sit amet';
        // $userId = 2;
        // $notificationType = 'transaksi masuk';
        // $icon = 'bell'; // font awesome
        // $bgColor = 'primary'; // primary, danger, success, warning
        // $this->NotificationRepository->createNotif($title,  $content, $userId,  $notificationType, $icon, $bgColor);

        // gunakan jika mau kirim email
        // $this->emailService->methodName($prestasi);

        $this->prestasiRepository->delete($prestasi->id);
        logDelete("Prestasi", $prestasi);

        $successMessage = successMessageDelete("Prestasi");
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

        $data = $this->prestasiRepository->getLatest();
        return Excel::download(new PrestasiExport($data), 'prestasis.xlsx');
    }

    /**
     * import excel file to db
     *
     * @param \App\Http\Requests\ImportExcelRequest $request
     * @return Response
     */
    public function importExcel(\App\Http\Requests\ImportExcelRequest $request)
    {
        Excel::import(new PrestasiImport, $request->file('import_file'));
        $successMessage = successMessageImportExcel("Prestasi");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * download export data as json
     *
     * @return Response
     */
    public function json()
    {
        $data = $this->prestasiRepository->getLatest();
        return $this->fileService->downloadJson($data, 'prestasis.json');
    }

    /**
     * download export data as xlsx
     *
     * @return Response
     */
    public function excel()
    {
        $data = $this->prestasiRepository->getLatest();
        return (new PrestasiExport($data))->download('prestasis.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * download export data as csv
     *
     * @return Response
     */
    public function csv()
    {
        $data = $this->prestasiRepository->getLatest();
        return (new PrestasiExport($data))->download('prestasis.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * download export data as pdf
     *
     * @return Response
     */
    public function pdf()
    {
        $data = $this->prestasiRepository->getLatest();
        return PDF::setPaper('Letter', 'landscape')
            ->loadView('stisla.prestasis.export-pdf', [
                'data'    => $data,
                'isPrint' => false
            ])
            ->download('prestasis.pdf');
    }

    /**
     * export data to print html
     *
     * @return Response
     */
    public function exportPrint()
    {
        $data = $this->prestasiRepository->getLatest();
        return view('stisla.prestasis.export-pdf', [
            'data'    => $data,
            'isPrint' => true
        ]);
    }
}
