<?php

namespace App\Http\Controllers;

use App\Exports\EventExport;
use App\Http\Requests\EventRequest;
use App\Imports\EventImport;
use App\Models\Event;
use App\Models\Masterevent;
use App\Repositories\EventRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\UserRepository;
use App\Services\EmailService;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Barryvdh\DomPDF\Facade as PDF;

class EventController extends Controller
{
    /**
     * eventRepository
     *
     * @var EventRepository
     */
    private EventRepository $eventRepository;

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
        $this->eventRepository      = new EventRepository;
        $this->fileService            = new FileService;
        $this->emailService           = new EmailService;
        $this->NotificationRepository = new NotificationRepository;
        $this->UserRepository         = new UserRepository;

        $this->middleware('can:Event');
        $this->middleware('can:Event Tambah')->only(['create', 'store']);
        $this->middleware('can:Event Ubah')->only(['edit', 'update']);
        $this->middleware('can:Event Hapus')->only(['destroy']);
        $this->middleware('can:Event Ekspor')->only(['json', 'excel', 'csv', 'pdf']);
        $this->middleware('can:Event Impor Excel')->only(['importExcel', 'importExcelExample']);
    }

    /**
     * showing data page
     *
     * @return Response
     */
    public function index()
    {
        $user = auth()->user();
        return view('stisla.events.index', [
            'data'             => $this->eventRepository->getLatest(),
            'canCreate'        => $user->can('Event Tambah'),
            'canUpdate'        => $user->can('Event Ubah'),
            'canDelete'        => $user->can('Event Hapus'),
            'canImportExcel'   => $user->can('Order Impor Excel') && $this->importable,
            'canExport'        => $user->can('Order Ekspor') && $this->exportable,
            'title'            => __('Event'),
            'collection'       => Masterevent::all(),
            'routeCreate'      => route('events.create'),
            'routePdf'         => route('events.pdf'),
            'routePrint'       => route('events.print'),
            'routeExcel'       => route('events.excel'),
            'routeCsv'         => route('events.csv'),
            'routeJson'        => route('events.json'),
            'routeImportExcel' => route('events.import-excel'),
            'excelExampleLink' => route('events.import-excel-example'),
        ]);
    }

    /**
     * showing add new data form page
     *
     * @return Response
     */
    public function create()
    {
        return view('stisla.events.form', [
            'title'         => __('Event'),
            'fullTitle'     => __('Tambah Event'),
            'collections'   => Masterevent::all(),
            'routeIndex'    => route('events.index'),
            'action'        => route('events.store')
        ]);
    }

    /**
     * save new data to db
     *
     * @param EventRequest $request
     * @return Response
     */
    public function store(EventRequest $request)
    {
        $data = $request->only([
			'masterevent_id',
			'nama',
        ]);

        // gunakan jika ada file
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->methodName($request->file('file'));
        // }

        $result = $this->eventRepository->create($data);

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

        logCreate("Event", $result);

        $successMessage = successMessageCreate("Event");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * showing edit page
     *
     * @param Event $event
     * @return Response
     */
    public function edit(Event $event)
    {
        return view('stisla.events.form', [
            'd'             => $event,
            'title'         => __('Event'),
            'fullTitle'     => __('Ubah Event'),
            'routeIndex'    => route('events.index'),
            'action'        => route('events.update', [$event->id])
        ]);
    }

    /**
     * update data to db
     *
     * @param EventRequest $request
     * @param Event $event
     * @return Response
     */
    public function update(EventRequest $request, Event $event)
    {
        $data = $request->only([
			'masterevent_id',
			'nama',
        ]);

        // gunakan jika ada file
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->methodName($request->file('file'));
        // }

        $newData = $this->eventRepository->update($data, $event->id);

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

        logUpdate("Event", $event, $newData);

        $successMessage = successMessageUpdate("Event");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * delete user from db
     *
     * @param Event $event
     * @return Response
     */
    public function destroy(Event $event)
    {
        // delete file from storage if exists
        // $this->fileService->methodName($event);

        // use this if you want to create notification data
        // $title = 'Notify Title';
        // $content = 'lorem ipsum dolor sit amet';
        // $userId = 2;
        // $notificationType = 'transaksi masuk';
        // $icon = 'bell'; // font awesome
        // $bgColor = 'primary'; // primary, danger, success, warning
        // $this->NotificationRepository->createNotif($title,  $content, $userId,  $notificationType, $icon, $bgColor);

        // gunakan jika mau kirim email
        // $this->emailService->methodName($event);

        $this->eventRepository->delete($event->id);
        logDelete("Event", $event);

        $successMessage = successMessageDelete("Event");
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

        $data = $this->eventRepository->getLatest();
        return Excel::download(new EventExport($data), 'events.xlsx');
    }

    /**
     * import excel file to db
     *
     * @param \App\Http\Requests\ImportExcelRequest $request
     * @return Response
     */
    public function importExcel(\App\Http\Requests\ImportExcelRequest $request)
    {
        Excel::import(new EventImport, $request->file('import_file'));
        $successMessage = successMessageImportExcel("Event");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * download export data as json
     *
     * @return Response
     */
    public function json()
    {
        $data = $this->eventRepository->getLatest();
        return $this->fileService->downloadJson($data, 'events.json');
    }

    /**
     * download export data as xlsx
     *
     * @return Response
     */
    public function excel()
    {
        $data = $this->eventRepository->getLatest();
        return (new EventExport($data))->download('events.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * download export data as csv
     *
     * @return Response
     */
    public function csv()
    {
        $data = $this->eventRepository->getLatest();
        return (new EventExport($data))->download('events.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * download export data as pdf
     *
     * @return Response
     */
    public function pdf()
    {
        $data = $this->eventRepository->getLatest();
        return PDF::setPaper('Letter', 'landscape')
            ->loadView('stisla.events.export-pdf', [
                'data'    => $data,
                'isPrint' => false
            ])
            ->download('events.pdf');
    }

    /**
     * export data to print html
     *
     * @return Response
     */
    public function exportPrint()
    {
        $data = $this->eventRepository->getLatest();
        return view('stisla.events.export-pdf', [
            'data'    => $data,
            'isPrint' => true
        ]);
    }
}
