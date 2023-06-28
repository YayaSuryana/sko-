@extends($data->count() > 0 ? 'stisla.layouts.app-table' : 'stisla.layouts.app')

@section('title')
  {{ $title }}
@endsection

@section('content')
  @include('stisla.includes.breadcrumbs.breadcrumb-table')

  <div class="section-body">

    <h2 class="section-title">{{ $title }}</h2>
    <p class="section-lead">{{ __('Merupakan halaman yang menampilkan kumpulan data ' . $title) }}.</p>

    <div class="row">
      <div class="col-12">

        {{-- gunakan jika ingin menampilkan sesuatu informasi --}}
        {{-- <div class="alert alert-info alert-has-icon">
          <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
          <div class="alert-body">
            <div class="alert-title">{{ __('Informasi') }}</div>
            This is a info alert.
          </div>
        </div> --}}

        {{-- gunakan jika mau ada filter --}}

        <div class="card">
          <div class="card-header">
            <h4><i class="fa fa-fa-solid fa-person-running"></i> {!! __('Aksi Ekspor <small>(Server Side)</small>') !!}</h4>
            <div class="card-header-action">
              @include('stisla.includes.forms.buttons.btn-pdf-download', ['link' => $routePdf])
              @include('stisla.includes.forms.buttons.btn-excel-download', ['link' => $routeExcel])
              @include('stisla.includes.forms.buttons.btn-csv-download', ['link' => $routeCsv])
              @include('stisla.includes.forms.buttons.btn-print', ['link' => $routePrint])
              @include('stisla.includes.forms.buttons.btn-json-download', ['link' => $routeJson])
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h4><i class="fa fa-filter"></i> Filter Data</h4>
            <div class="card-header-action">
            </div>
          </div>
          <div class="card-body">
            <form action="{{route('sko.index')}}" method="get">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" autofocus name="search" placeholder="Cari Nama atau NISN Disini" value="{{request('search')}}">
                    <button class="btn btn-info btn-sm" style="width:70px" type="submit" id="button-addon2">
                        <em class="fas fa-search"></em>
                    </button>
                </div>
            </form>
            <!-- <form action="">
              @csrf
              <div class="row">
                <div class="col-md-3">
                  @include('stisla.includes.forms.inputs.input', [
                      'type' => 'text',
                      'id' => 'filter_text',
                      'required' => false,
                      'label' => __('Pilih Text'),
                      'value' => request('filter_text'),
                  ])
                </div>
                <div class="col-md-3">
                  @include('stisla.includes.forms.inputs.input', [
                      'type' => 'date',
                      'id' => 'filter_date',
                      'required' => true,
                      'label' => __('Pilih Date'),
                      'value' => request('filter_date', date('Y-m-d')),
                  ])
                </div>
                <div class="col-md-3">
                  @include('stisla.includes.forms.selects.select2', [
                      'id' => 'filter_dropdown',
                      'name' => 'filter_dropdown',
                      'label' => __('Pilih Select2'),
                      'options' => $dropdownOptions ?? [],
                      'selected' => request('filter_dropdown'),
                      'with_all' => true,
                  ])
                </div>
              </div>
              <button class="btn btn-primary icon"><i class="fa fa-search"></i> Cari Data</button>
            </form> -->
          </div>
        </div>
        @if ($data->count() > 0)
          <!-- @if ($canExport) -->

          <!-- @endif -->

          <div class="card">
            <div class="card-header">
              <h4><i class="fa fa-users"></i> {{ $title }}</h4>

              <div class="card-header-action">
                @if ($canImportExcel)
                  @include('stisla.includes.forms.buttons.btn-import-excel')
                @endif

                @if ($canCreate)
                  @include('stisla.includes.forms.buttons.btn-add', ['link' => $routeCreate])
                @endif
              </div>

            </div>
            <div class="card-body">
              <div class="table-responsive">

                @if ($canExport)
                  <h6 class="text-primary">{!! __('Aksi Ekspor <small>(Client Side)</small>') !!}</h6>
                @endif

                <table class="table table-striped table-hovered" id=""  @if ($canExport) data-export="true" data-title="{{ $title }}" @endif>
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th class="text-center">{{__('Nama')}}</th>
                      <!-- <th class="text-center">{{ __('Nomor KK') }}</th> -->
                      <th class="text-center">{{ __('NISN') }}</th>
                      <!-- <th class="text-center">{{ __('Alamat Domisili') }}</th> -->
                      <!-- <th class="text-center">{{ __('Kelas') }}</th> -->
                      <!-- <th class="text-center">{{ __('Tempat Lahir') }}</th> -->
                      <!-- <th class="text-center">{{ __('Tanggal_lahir') }}</th> -->
                      <!-- <th class="text-center">{{ __('Golongan Darah') }}</th> -->
                      <th class="text-center">{{ __('Jenis Kelamin') }}</th>
                      <th class="text-center">{{ __('Cabor') }}</th>
                      <th class="text-center">{{ __('Nomor Cabor 1') }}</th>
                      <!-- <th class="text-center">{{ __('Nomor Cabor 2') }}</th>
                      <th class="text-center">{{ __('Nomor Cabor 3') }}</th>
                      <th class="text-center">{{ __('Nomor Cabor 4') }}</th> -->
                      <!-- <th class="text-center">{{ __('Tinggi Badan') }}</th> -->
                      <!-- <th class="text-center">{{ __('Berat Badan') }}</th> -->
                      <!-- <th class="text-center">{{ __('Provinsi') }}</th> -->
                      <!-- <th class="text-center">{{ __('Asal Pembinaan') }}</th> -->
                      <!-- <th class="text-center">{{ __('Foto') }}</th> -->
                      <th>{{ __('Aksi') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($data as $item)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                          <a href="{{route('detail.atlet', $item->id)}}">{{$item->nama}}</a>
                        </td>
                        <!-- <td>{{ $item->no_kk }}</td> -->
                        <td>{{ $item->nisn }}</td>
                        <!-- <td>{{ $item->alamat_domisili }}</td> -->
                        <!-- <td>{{ $item->kelas }}</td> -->
                        <!-- <td>{{ $item->tempat_lahir }}</td> -->
                        <!-- <td>{{ $item->tanggal_lahir }}</td> -->
                        <!-- <td>{{ $item->gol_darah }}</td> -->
                        <td>
                          @foreach ($kode->where('id', $item->jenis_kelamin) as $code)
                            {{$code -> nama}}
                          @endforeach
                        </td>
                        <td>
                          @foreach ($cabor->where('id', $item->cabor) as $code)
                            {{$code -> nama}}
                          @endforeach
                        </td>
                        <td>{{ $item->nomor_cabor1 }}</td>
                        <!-- <td>{{ $item->nomor_cabor2 }}</td>
                        <td>{{ $item->nomor_cabor3 }}</td>
                        <td>{{ $item->nomor_cabor4 }}</td>
                        <td>{{ $item->tinggi_badan }}</td>
                        <td>{{ $item->berat_badan }}</td> -->
                        <!-- <td>{{ $item->provinsi }}</td> -->
                        <!-- <td>{{ $item->asal_pembinaan }}</td> -->
                        <!-- <td>
                          <img src="{{$item->foto}}" alt="test">
                        </td> -->
                        <td>
                          @if ($canUpdate)
                            @include('stisla.includes.forms.buttons.btn-edit', ['link' => route('profileatlets.edit', [$item->id])])
                          @endif
                          @if ($canDelete)
                            @include('stisla.includes.forms.buttons.btn-delete', ['link' => route('profileatlets.destroy', [$item->id])])
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="text-center ml-auto">
                {{$data->links()}}
              </div>
            </div>
          </div>
        @else
          @include('stisla.includes.others.empty-state', ['title' => 'Data ' . $title, 'icon' => 'fa-solid fa-person-running', 'link' => $routeCreate])
        @endif
      </div>

    </div>
  </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush

@push('scripts')
  <script>

  </script>
@endpush

@push('modals')
  @if ($canImportExcel)
    @include('stisla.includes.modals.modal-import-excel', ['formAction' => $routeImportExcel, 'downloadLink' => $excelExampleLink])
  @endif
@endpush
