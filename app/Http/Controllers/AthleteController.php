<?php

namespace App\Http\Controllers;

use App\Exports\AthleteExport;
use App\Http\Requests\AthleteRequest;
use App\Imports\AthleteImport;
use App\Models\Athlete;
use App\Repositories\AthleteRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\UserRepository;
use App\Services\EmailService;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Barryvdh\DomPDF\Facade as PDF;

class AthleteController extends Controller
{
    /**
     * athleteRepository
     *
     * @var AthleteRepository
     */
    private AthleteRepository $athleteRepository;

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
        $this->athleteRepository      = new AthleteRepository;
        $this->fileService            = new FileService;
        $this->emailService           = new EmailService;
        $this->NotificationRepository = new NotificationRepository;
        $this->UserRepository         = new UserRepository;

        $this->middleware('can:Athlete');
        $this->middleware('can:Athlete Tambah')->only(['create', 'store']);
        $this->middleware('can:Athlete Ubah')->only(['edit', 'update']);
        $this->middleware('can:Athlete Hapus')->only(['destroy']);
        $this->middleware('can:Athlete Ekspor')->only(['json', 'excel', 'csv', 'pdf']);
        $this->middleware('can:Athlete Impor Excel')->only(['importExcel', 'importExcelExample']);
    }

    /**
     * showing data page
     *
     * @return Response
     */
    public function index()
    {
        $user = auth()->user();
        return view('stisla.athletes.index', [
            'data'             => $this->athleteRepository->getLatest(),
            'canCreate'        => $user->can('Athlete Tambah'),
            'canUpdate'        => $user->can('Athlete Ubah'),
            'canDelete'        => $user->can('Athlete Hapus'),
            'canImportExcel'   => $user->can('Order Impor Excel') && $this->importable,
            'canExport'        => $user->can('Order Ekspor') && $this->exportable,
            'title'            => __('Athlete'),
            'routeCreate'      => route('athletes.create'),
            'routePdf'         => route('athletes.pdf'),
            'routePrint'       => route('athletes.print'),
            'routeExcel'       => route('athletes.excel'),
            'routeCsv'         => route('athletes.csv'),
            'routeJson'        => route('athletes.json'),
            'routeImportExcel' => route('athletes.import-excel'),
            'excelExampleLink' => route('athletes.import-excel-example'),
        ]);
    }

    /**
     * showing add new data form page
     *
     * @return Response
     */
    public function create()
    {
        return view('stisla.athletes.form', [
            'title'         => __('Athlete'),
            'fullTitle'     => __('Tambah Athlete'),
            'routeIndex'    => route('athletes.index'),
            'action'        => route('athletes.store')
        ]);
    }

    /**
     * save new data to db
     *
     * @param AthleteRequest $request
     * @return Response
     */
    public function store(AthleteRequest $request)
    {
        $data = $request->only([
			'tempat',
			'tanggal',
			'nisn',
			'tingkatPendidikan',
			'domisili',
			'cabor',
			'nomorCabor',
        ]);

        // gunakan jika ada file
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->methodName($request->file('file'));
        // }

        $result = $this->athleteRepository->create($data);

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

        logCreate("Athlete", $result);

        $successMessage = successMessageCreate("Athlete");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * showing edit page
     *
     * @param Athlete $athlete
     * @return Response
     */
    public function edit(Athlete $athlete)
    {
        return view('stisla.athletes.form', [
            'd'             => $athlete,
            'title'         => __('Athlete'),
            'fullTitle'     => __('Ubah Athlete'),
            'routeIndex'    => route('athletes.index'),
            'action'        => route('athletes.update', [$athlete->id])
        ]);
    }

    /**
     * update data to db
     *
     * @param AthleteRequest $request
     * @param Athlete $athlete
     * @return Response
     */
    public function update(AthleteRequest $request, Athlete $athlete)
    {
        $data = $request->only([
			'tempat',
			'tanggal',
			'nisn',
			'tingkatPendidikan',
			'domisili',
			'cabor',
			'nomorCabor',
        ]);

        // gunakan jika ada file
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->methodName($request->file('file'));
        // }

        $newData = $this->athleteRepository->update($data, $athlete->id);

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

        logUpdate("Athlete", $athlete, $newData);

        $successMessage = successMessageUpdate("Athlete");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * delete user from db
     *
     * @param Athlete $athlete
     * @return Response
     */
    public function destroy(Athlete $athlete)
    {
        // delete file from storage if exists
        // $this->fileService->methodName($athlete);

        // use this if you want to create notification data
        // $title = 'Notify Title';
        // $content = 'lorem ipsum dolor sit amet';
        // $userId = 2;
        // $notificationType = 'transaksi masuk';
        // $icon = 'bell'; // font awesome
        // $bgColor = 'primary'; // primary, danger, success, warning
        // $this->NotificationRepository->createNotif($title,  $content, $userId,  $notificationType, $icon, $bgColor);

        // gunakan jika mau kirim email
        // $this->emailService->methodName($athlete);

        $this->athleteRepository->delete($athlete->id);
        logDelete("Athlete", $athlete);

        $successMessage = successMessageDelete("Athlete");
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

        $data = $this->athleteRepository->getLatest();
        return Excel::download(new AthleteExport($data), 'athletes.xlsx');
    }

    /**
     * import excel file to db
     *
     * @param \App\Http\Requests\ImportExcelRequest $request
     * @return Response
     */
    public function importExcel(\App\Http\Requests\ImportExcelRequest $request)
    {
        Excel::import(new AthleteImport, $request->file('import_file'));
        $successMessage = successMessageImportExcel("Athlete");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * download export data as json
     *
     * @return Response
     */
    public function json()
    {
        $data = $this->athleteRepository->getLatest();
        return $this->fileService->downloadJson($data, 'athletes.json');
    }

    /**
     * download export data as xlsx
     *
     * @return Response
     */
    public function excel()
    {
        $data = $this->athleteRepository->getLatest();
        return (new AthleteExport($data))->download('athletes.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * download export data as csv
     *
     * @return Response
     */
    public function csv()
    {
        $data = $this->athleteRepository->getLatest();
        return (new AthleteExport($data))->download('athletes.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * download export data as pdf
     *
     * @return Response
     */
    public function pdf()
    {
        $data = $this->athleteRepository->getLatest();
        return PDF::setPaper('Letter', 'landscape')
            ->loadView('stisla.athletes.export-pdf', [
                'data'    => $data,
                'isPrint' => false
            ])
            ->download('athletes.pdf');
    }

    /**
     * export data to print html
     *
     * @return Response
     */
    public function exportPrint()
    {
        $data = $this->athleteRepository->getLatest();
        return view('stisla.athletes.export-pdf', [
            'data'    => $data,
            'isPrint' => true
        ]);
    }
}
