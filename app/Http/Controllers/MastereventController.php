<?php

namespace App\Http\Controllers;

use App\Exports\MastereventExport;
use App\Http\Requests\MastereventRequest;
use App\Imports\MastereventImport;
use App\Models\Masterevent;
use App\Repositories\MastereventRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\UserRepository;
use App\Services\EmailService;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Barryvdh\DomPDF\Facade as PDF;

class MastereventController extends Controller
{
    /**
     * mastereventRepository
     *
     * @var MastereventRepository
     */
    private MastereventRepository $mastereventRepository;

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
        $this->mastereventRepository      = new MastereventRepository;
        $this->fileService            = new FileService;
        $this->emailService           = new EmailService;
        $this->NotificationRepository = new NotificationRepository;
        $this->UserRepository         = new UserRepository;

        $this->middleware('can:MasterEvent');
        $this->middleware('can:MasterEvent Tambah')->only(['create', 'store']);
        $this->middleware('can:MasterEvent Ubah')->only(['edit', 'update']);
        $this->middleware('can:MasterEvent Hapus')->only(['destroy']);
        $this->middleware('can:MasterEvent Ekspor')->only(['json', 'excel', 'csv', 'pdf']);
        $this->middleware('can:MasterEvent Impor Excel')->only(['importExcel', 'importExcelExample']);
    }

    /**
     * showing data page
     *
     * @return Response
     */
    public function index()
    {
        $user = auth()->user();
        return view('stisla.masterevents.index', [
            'data'             => $this->mastereventRepository->getLatest(),
            'canCreate'        => $user->can('MasterEvent Tambah'),
            'canUpdate'        => $user->can('MasterEvent Ubah'),
            'canDelete'        => $user->can('MasterEvent Hapus'),
            'canImportExcel'   => $user->can('Order Impor Excel') && $this->importable,
            'canExport'        => $user->can('Order Ekspor') && $this->exportable,
            'title'            => __('MasterEvent'),
            'routeCreate'      => route('masterevents.create'),
            'routePdf'         => route('masterevents.pdf'),
            'routePrint'       => route('masterevents.print'),
            'routeExcel'       => route('masterevents.excel'),
            'routeCsv'         => route('masterevents.csv'),
            'routeJson'        => route('masterevents.json'),
            'routeImportExcel' => route('masterevents.import-excel'),
            'excelExampleLink' => route('masterevents.import-excel-example'),
        ]);
    }

    /**
     * showing add new data form page
     *
     * @return Response
     */
    public function create()
    {
        return view('stisla.masterevents.form', [
            'title'         => __('MasterEvent'),
            'fullTitle'     => __('Tambah MasterEvent'),
            'routeIndex'    => route('masterevents.index'),
            'action'        => route('masterevents.store')
        ]);
    }

    /**
     * save new data to db
     *
     * @param MastereventRequest $request
     * @return Response
     */
    public function store(MastereventRequest $request)
    {
        $data = $request->only([
			'nama',
        ]);

        // gunakan jika ada file
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->methodName($request->file('file'));
        // }

        $result = $this->mastereventRepository->create($data);

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

        logCreate("MasterEvent", $result);

        $successMessage = successMessageCreate("MasterEvent");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * showing edit page
     *
     * @param Masterevent $masterevent
     * @return Response
     */
    public function edit(Masterevent $masterevent)
    {
        return view('stisla.masterevents.form', [
            'd'             => $masterevent,
            'title'         => __('MasterEvent'),
            'fullTitle'     => __('Ubah MasterEvent'),
            'routeIndex'    => route('masterevents.index'),
            'action'        => route('masterevents.update', [$masterevent->id])
        ]);
    }

    /**
     * update data to db
     *
     * @param MastereventRequest $request
     * @param Masterevent $masterevent
     * @return Response
     */
    public function update(MastereventRequest $request, Masterevent $masterevent)
    {
        $data = $request->only([
			'nama',
        ]);

        // gunakan jika ada file
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->methodName($request->file('file'));
        // }

        $newData = $this->mastereventRepository->update($data, $masterevent->id);

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

        logUpdate("MasterEvent", $masterevent, $newData);

        $successMessage = successMessageUpdate("MasterEvent");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * delete user from db
     *
     * @param Masterevent $masterevent
     * @return Response
     */
    public function destroy(Masterevent $masterevent)
    {
        // delete file from storage if exists
        // $this->fileService->methodName($masterevent);

        // use this if you want to create notification data
        // $title = 'Notify Title';
        // $content = 'lorem ipsum dolor sit amet';
        // $userId = 2;
        // $notificationType = 'transaksi masuk';
        // $icon = 'bell'; // font awesome
        // $bgColor = 'primary'; // primary, danger, success, warning
        // $this->NotificationRepository->createNotif($title,  $content, $userId,  $notificationType, $icon, $bgColor);

        // gunakan jika mau kirim email
        // $this->emailService->methodName($masterevent);

        $this->mastereventRepository->delete($masterevent->id);
        logDelete("MasterEvent", $masterevent);

        $successMessage = successMessageDelete("MasterEvent");
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

        $data = $this->mastereventRepository->getLatest();
        return Excel::download(new MastereventExport($data), 'masterevents.xlsx');
    }

    /**
     * import excel file to db
     *
     * @param \App\Http\Requests\ImportExcelRequest $request
     * @return Response
     */
    public function importExcel(\App\Http\Requests\ImportExcelRequest $request)
    {
        Excel::import(new MastereventImport, $request->file('import_file'));
        $successMessage = successMessageImportExcel("MasterEvent");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * download export data as json
     *
     * @return Response
     */
    public function json()
    {
        $data = $this->mastereventRepository->getLatest();
        return $this->fileService->downloadJson($data, 'masterevents.json');
    }

    /**
     * download export data as xlsx
     *
     * @return Response
     */
    public function excel()
    {
        $data = $this->mastereventRepository->getLatest();
        return (new MastereventExport($data))->download('masterevents.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * download export data as csv
     *
     * @return Response
     */
    public function csv()
    {
        $data = $this->mastereventRepository->getLatest();
        return (new MastereventExport($data))->download('masterevents.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * download export data as pdf
     *
     * @return Response
     */
    public function pdf()
    {
        $data = $this->mastereventRepository->getLatest();
        return PDF::setPaper('Letter', 'landscape')
            ->loadView('stisla.masterevents.export-pdf', [
                'data'    => $data,
                'isPrint' => false
            ])
            ->download('masterevents.pdf');
    }

    /**
     * export data to print html
     *
     * @return Response
     */
    public function exportPrint()
    {
        $data = $this->mastereventRepository->getLatest();
        return view('stisla.masterevents.export-pdf', [
            'data'    => $data,
            'isPrint' => true
        ]);
    }
}
