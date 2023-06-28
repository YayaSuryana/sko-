<?php

namespace App\Http\Controllers;

use App\Exports\ProfileatletExport;
use App\Http\Requests\ProfileatletRequest;
use App\Imports\ProfileatletImport;
use App\Models\Profileatlet;
use App\Models\Cabor;
use App\Models\Kode;
use Carbon\Carbon;
use Illuminate\Support\Str;
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

class ProfileatletController extends Controller
{
    /**
     * profileatletRepository
     *
     * @var ProfileatletRepository
     */
    private ProfileatletRepository $profileatletRepository;

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
        $this->profileatletRepository      = new ProfileatletRepository;
        $this->fileService            = new FileService;
        $this->emailService           = new EmailService;
        $this->NotificationRepository = new NotificationRepository;
        $this->UserRepository         = new UserRepository;

        $this->middleware('can:Profileatlet');
        $this->middleware('can:Profileatlet Tambah')->only(['create', 'store']);
        $this->middleware('can:Profileatlet Ubah')->only(['edit', 'update']);
        $this->middleware('can:Profileatlet Hapus')->only(['destroy']);
        $this->middleware('can:Profileatlet Ekspor')->only(['json', 'excel', 'csv', 'pdf']);
        $this->middleware('can:Profileatlet Impor Excel')->only(['importExcel', 'importExcelExample']);
    }

    /**
     * showing data page
     *
     * @return Response
     */
    public function index()
    {
        $user = auth()->user();
        return view('stisla.profileatlets.index', [
            'data'             => $this->profileatletRepository->getLatest(),
            'canCreate'        => $user->can('Profileatlet Tambah'),
            'canUpdate'        => $user->can('Profileatlet Ubah'),
            'canDelete'        => $user->can('Profileatlet Hapus'),
            'canImportExcel'   => $user->can('Order Impor Excel') && $this->importable,
            'canExport'        => $user->can('Order Ekspor') && $this->exportable,
            'title'            => __('Profileatlet'),
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
     * showing add new data form page
     *
     * @return Response
     */
    public function create()
    {
        return view('stisla.profileatlets.form', [
            'title'         => __('Profileatlet'),
            'fullTitle'     => __('Tambah Profileatlet'),
            'cabor'         => Cabor::all(),
            'darah'         => Kode::where('keterangan','golongan darah')->get(),
            'provinsi'      => Kode::where('keterangan','provinsi')->get(),
            'jk'            => Kode::where('keterangan','jk')->get(),
            'kelas'         => Kode::where('keterangan','kelas')->get(),
            'pembinaan'     => Kode::where('keterangan','asal pembinaan')->get(),
            'routeIndex'    => route('profileatlets.index'),
            'action'        => route('profileatlets.store')
        ]);
    }

    /**
     * save new data to db
     *
     * @param ProfileatletRequest $request
     * @return Response
     */
    public function store(ProfileatletRequest $request)
    {
        $data = $request->only([
      'nama',
			'no_kk',
			'nisn',
			'alamat_domisili',
			'kelas',
			'tempat_lahir',
			'tanggal_lahir',
			'gol_darah',
			'jenis_kelamin',
			'cabor',
			'nomor_cabor1',
			'nomor_cabor2',
			'nomor_cabor3',
			'nomor_cabor4',
			'tinggi_badan',
			'berat_badan',
			'provinsi',
			'asal_pembinaan',
			'foto',
        ]);

        // gunakan jika ada file
        // if ($request->hasFile('foto')) {
        //     $data['foto'] = $this->fileService->methodName($request->file('foto'));
        // }
        $image  = $request->file('foto');
        $slug   = Str::slug($request->nama);

        if(isset($image)){
            $currentDate    = Carbon::now()->toDateString();
            $imageName      = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if(!file_exists('avatar')){
                mkdir('avatar', 0777, true);
            }
            $image->move('avatar', $imageName);
        }else{
            $image = 'default.jpg';
        }

        $result = new Profileatlet();
        $result->nama = $request->nama;
        $result->no_kk = $request->no_kk;
        $result->nisn = $request->nisn;
        $result->alamat_domisili = $request->alamat_domisili;
  			$result->kelas = $request->kelas;
  			$result->tempat_lahir = $request->tempat_lahir;
  			$result->tanggal_lahir = $request->tanggal_lahir;
  			$result->gol_darah = $request->gol_darah;
  			$result->jenis_kelamin = $request->jenis_kelamin;
  			$result->cabor = $request->cabor;
  			$result->nomor_cabor1 = $request->nomor_cabor1;
  			$result->nomor_cabor2 = $request->nomor_cabor2;
  			$result->nomor_cabor3 = $request->nomor_cabor3;
  			$result->nomor_cabor4 = $request->nomor_cabor4;
  			$result->tinggi_badan = $request->tinggi_badan;
  			$result->berat_badan  = $request->berat_badan;
  			$result->provinsi     = $request->provinsi;
  			$result->asal_pembinaan = $request->asal_pembinaan;
  			$result->foto = $imageName;
        $result->save();
        // $result = $this->profileatletRepository->create($data);

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

        logCreate("Profileatlet", $result);

        $successMessage = successMessageCreate("Profileatlet");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * showing edit page
     *
     * @param Profileatlet $profileatlet
     * @return Response
     */
    public function edit(Profileatlet $profileatlet)
    {
        return view('stisla.profileatlets.form', [
            'd'             => $profileatlet,
            'title'         => __('Profileatlet'),
            'fullTitle'     => __('Ubah Profileatlet'),
            'cabor'         => Cabor::all(),
            'darah'         => Kode::where('keterangan','golongan darah')->get(),
            'provinsi'      => Kode::where('keterangan','provinsi')->get(),
            'jk'            => Kode::where('keterangan','jk')->get(),
            'kelas'         => Kode::where('keterangan','kelas')->get(),
            'pembinaan'     => Kode::where('keterangan','asal pembinaan')->get(),
            'routeIndex'    => route('profileatlets.index'),
            'action'        => route('profileatlets.update', [$profileatlet->id])
        ]);
    }

    /**
     * update data to db
     *
     * @param ProfileatletRequest $request
     * @param Profileatlet $profileatlet
     * @return Response
     */
    public function update(ProfileatletRequest $request, Profileatlet $profileatlet)
    {
        $data = $request->only([
            'nama',
      			'no_kk',
      			'nisn',
      			'alamat_domisili',
      			'kelas',
      			'tempat_lahir',
      			'tanggal_lahir',
      			'gol_darah',
      			'jenis_kelamin',
      			'cabor',
      			'nomor_cabor1',
      			'nomor_cabor2',
      			'nomor_cabor3',
      			'nomor_cabor4',
      			'tinggi_badan',
      			'berat_badan',
      			'provinsi',
      			'asal_pembinaan',
      			'foto',
        ]);

        // gunakan jika ada file
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->methodName($request->file('file'));
        // }

        // $newData = $this->profileatletRepository->update($data, $profileatlet->id);
        $image  = $request->file('foto');
        $slug   = Str::slug($request->nama);
        $result = Profileatlet::find($profileatlet->id);
        if(isset($image)){
            $currentDate    = Carbon::now()->toDateString();
            $imageName      = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if(!file_exists('avatar')){
                mkdir('avatar', 0077, true);
            }
            unlink('avatar/'.$result->foto);
            $image->move('avatar/', $imageName);
        }else{
            $imageName = $result->foto;
        }
        $result->nama = $request->nama;
        $result->no_kk = $request->no_kk;
        $result->nisn = $request->nisn;
        $result->alamat_domisili = $request->alamat_domisili;
  			$result->kelas = $request->kelas;
  			$result->tempat_lahir = $request->tempat_lahir;
  			$result->tanggal_lahir = $request->tanggal_lahir;
  			$result->gol_darah = $request->gol_darah;
  			$result->jenis_kelamin = $request->jenis_kelamin;
  			$result->cabor = $request->cabor;
  			$result->nomor_cabor1 = $request->nomor_cabor1;
  			$result->nomor_cabor2 = $request->nomor_cabor2;
  			$result->nomor_cabor3 = $request->nomor_cabor3;
  			$result->nomor_cabor4 = $request->nomor_cabor4;
  			$result->tinggi_badan = $request->tinggi_badan;
  			$result->berat_badan  = $request->berat_badan;
  			$result->provinsi     = $request->provinsi;
  			$result->asal_pembinaan = $request->asal_pembinaan;
  			$result->foto = $imageName;
        $result->save();

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

        logUpdate("Profileatlet", $profileatlet, $result);

        $successMessage = successMessageUpdate("Profileatlet");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * delete user from db
     *
     * @param Profileatlet $profileatlet
     * @return Response
     */
    public function destroy(Profileatlet $profileatlet)
    {
        // delete file from storage if exists
        // $this->fileService->methodName($profileatlet);

        // use this if you want to create notification data
        // $title = 'Notify Title';
        // $content = 'lorem ipsum dolor sit amet';
        // $userId = 2;
        // $notificationType = 'transaksi masuk';
        // $icon = 'bell'; // font awesome
        // $bgColor = 'primary'; // primary, danger, success, warning
        // $this->NotificationRepository->createNotif($title,  $content, $userId,  $notificationType, $icon, $bgColor);

        // gunakan jika mau kirim email
        // $this->emailService->methodName($profileatlet);

        $profileatlet = Profileatlet::findOrFail($profileatlet->id);
        if(file_exists('avatar/'.$profileatlet->foto)){
            unlink('avatar/'.$profileatlet->foto);
        }
        $profileatlet->delete();

        // $this->profileatletRepository->delete($profileatlet->id);
        logDelete("Profileatlet", $profileatlet);

        $successMessage = successMessageDelete("Profileatlet");
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

        $data = $this->profileatletRepository->getLatest();
        return Excel::download(new ProfileatletExport($data), 'profileatlets.xlsx');
    }

    /**
     * import excel file to db
     *
     * @param \App\Http\Requests\ImportExcelRequest $request
     * @return Response
     */
    public function importExcel(\App\Http\Requests\ImportExcelRequest $request)
    {
        Excel::import(new ProfileatletImport, $request->file('import_file'));
        $successMessage = successMessageImportExcel("Profileatlet");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * download export data as json
     *
     * @return Response
     */
    public function json()
    {
        $data = $this->profileatletRepository->getLatest();
        return $this->fileService->downloadJson($data, 'profileatlets.json');
    }

    /**
     * download export data as xlsx
     *
     * @return Response
     */
    public function excel()
    {
        $data = $this->profileatletRepository->getLatest();
        return (new ProfileatletExport($data))->download('profileatlets.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * download export data as csv
     *
     * @return Response
     */
    public function csv()
    {
        $data = $this->profileatletRepository->getLatest();
        return (new ProfileatletExport($data))->download('profileatlets.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * download export data as pdf
     *
     * @return Response
     */
    public function pdf()
    {
        $data = $this->profileatletRepository->getLatest();
        return PDF::setPaper('Letter', 'landscape')
            ->loadView('stisla.profileatlets.export-pdf', [
                'data'    => $data,
                'isPrint' => false
            ])
            ->download('profileatlets.pdf');
    }

    /**
     * export data to print html
     *
     * @return Response
     */
    public function exportPrint()
    {
        $data = $this->profileatletRepository->getLatest();
        return view('stisla.profileatlets.export-pdf', [
            'data'    => $data,
            'isPrint' => true
        ]);
    }
}
