<?php

namespace App\Http\Controllers;

use App\Exports\CaborExport;
use App\Http\Requests\CaborRequest;
use App\Imports\CaborImport;
use App\Models\Cabor;
use App\Repositories\CaborRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\UserRepository;
use App\Services\EmailService;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Barryvdh\DomPDF\Facade as PDF;

class CaborController extends Controller
{
    /**
     * caborRepository
     *
     * @var CaborRepository
     */
    private CaborRepository $caborRepository;

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
        $this->caborRepository      = new CaborRepository;
        $this->fileService            = new FileService;
        $this->emailService           = new EmailService;
        $this->NotificationRepository = new NotificationRepository;
        $this->UserRepository         = new UserRepository;

        $this->middleware('can:Cabor');
        $this->middleware('can:Cabor Tambah')->only(['create', 'store']);
        $this->middleware('can:Cabor Ubah')->only(['edit', 'update']);
        $this->middleware('can:Cabor Hapus')->only(['destroy']);
        $this->middleware('can:Cabor Ekspor')->only(['json', 'excel', 'csv', 'pdf']);
        $this->middleware('can:Cabor Impor Excel')->only(['importExcel', 'importExcelExample']);
    }

    /**
     * showing data page
     *
     * @return Response
     */
    public function index()
    {
        $user = auth()->user();
        return view('stisla.cabors.index', [
            'data'             => $this->caborRepository->getLatest(),
            'canCreate'        => $user->can('Cabor Tambah'),
            'canUpdate'        => $user->can('Cabor Ubah'),
            'canDelete'        => $user->can('Cabor Hapus'),
            'canImportExcel'   => $user->can('Order Impor Excel') && $this->importable,
            'canExport'        => $user->can('Order Ekspor') && $this->exportable,
            'title'            => __('Cabor'),
            'routeCreate'      => route('cabors.create'),
            'routePdf'         => route('cabors.pdf'),
            'routePrint'       => route('cabors.print'),
            'routeExcel'       => route('cabors.excel'),
            'routeCsv'         => route('cabors.csv'),
            'routeJson'        => route('cabors.json'),
            'routeImportExcel' => route('cabors.import-excel'),
            'excelExampleLink' => route('cabors.import-excel-example'),
        ]);
    }

    /**
     * showing add new data form page
     *
     * @return Response
     */
    public function create()
    {
        return view('stisla.cabors.form', [
            'title'         => __('Cabor'),
            'fullTitle'     => __('Tambah Cabor'),
            'routeIndex'    => route('cabors.index'),
            'action'        => route('cabors.store')
        ]);
    }

    /**
     * save new data to db
     *
     * @param CaborRequest $request
     * @return Response
     */
    public function store(CaborRequest $request)
    {
        $data = $request->only([
			'nama',
        ]);

        // gunakan jika ada file
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->methodName($request->file('file'));
        // }

        $result = $this->caborRepository->create($data);

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

        logCreate("Cabor", $result);

        $successMessage = successMessageCreate("Cabor");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * showing edit page
     *
     * @param Cabor $cabor
     * @return Response
     */
    public function edit(Cabor $cabor)
    {
        return view('stisla.cabors.form', [
            'd'             => $cabor,
            'title'         => __('Cabor'),
            'fullTitle'     => __('Ubah Cabor'),
            'routeIndex'    => route('cabors.index'),
            'action'        => route('cabors.update', [$cabor->id])
        ]);
    }

    /**
     * update data to db
     *
     * @param CaborRequest $request
     * @param Cabor $cabor
     * @return Response
     */
    public function update(CaborRequest $request, Cabor $cabor)
    {
        $data = $request->only([
			'nama',
        ]);

        // gunakan jika ada file
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->methodName($request->file('file'));
        // }

        $newData = $this->caborRepository->update($data, $cabor->id);

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

        logUpdate("Cabor", $cabor, $newData);

        $successMessage = successMessageUpdate("Cabor");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * delete user from db
     *
     * @param Cabor $cabor
     * @return Response
     */
    public function destroy(Cabor $cabor)
    {
        // delete file from storage if exists
        // $this->fileService->methodName($cabor);

        // use this if you want to create notification data
        // $title = 'Notify Title';
        // $content = 'lorem ipsum dolor sit amet';
        // $userId = 2;
        // $notificationType = 'transaksi masuk';
        // $icon = 'bell'; // font awesome
        // $bgColor = 'primary'; // primary, danger, success, warning
        // $this->NotificationRepository->createNotif($title,  $content, $userId,  $notificationType, $icon, $bgColor);

        // gunakan jika mau kirim email
        // $this->emailService->methodName($cabor);

        $this->caborRepository->delete($cabor->id);
        logDelete("Cabor", $cabor);

        $successMessage = successMessageDelete("Cabor");
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

        $data = $this->caborRepository->getLatest();
        return Excel::download(new CaborExport($data), 'cabors.xlsx');
    }

    /**
     * import excel file to db
     *
     * @param \App\Http\Requests\ImportExcelRequest $request
     * @return Response
     */
    public function importExcel(\App\Http\Requests\ImportExcelRequest $request)
    {
        Excel::import(new CaborImport, $request->file('import_file'));
        $successMessage = successMessageImportExcel("Cabor");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * download export data as json
     *
     * @return Response
     */
    public function json()
    {
        $data = $this->caborRepository->getLatest();
        return $this->fileService->downloadJson($data, 'cabors.json');
    }

    /**
     * download export data as xlsx
     *
     * @return Response
     */
    public function excel()
    {
        $data = $this->caborRepository->getLatest();
        return (new CaborExport($data))->download('cabors.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * download export data as csv
     *
     * @return Response
     */
    public function csv()
    {
        $data = $this->caborRepository->getLatest();
        return (new CaborExport($data))->download('cabors.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * download export data as pdf
     *
     * @return Response
     */
    public function pdf()
    {
        $data = $this->caborRepository->getLatest();
        return PDF::setPaper('Letter', 'landscape')
            ->loadView('stisla.cabors.export-pdf', [
                'data'    => $data,
                'isPrint' => false
            ])
            ->download('cabors.pdf');
    }

    /**
     * export data to print html
     *
     * @return Response
     */
    public function exportPrint()
    {
        $data = $this->caborRepository->getLatest();
        return view('stisla.cabors.export-pdf', [
            'data'    => $data,
            'isPrint' => true
        ]);
    }
}
