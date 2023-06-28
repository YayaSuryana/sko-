@extends($data->count() > 0 ? 'stisla.layouts.app-table' : 'stisla.layouts.app')

@section('title')
  {{ $title }}
@endsection

@section('content')
  @include('stisla.includes.breadcrumbs.breadcrumb-table')

  <div class="section-body">

    {{-- <h2 class="section-title">{{ $title }}</h2>
    <p class="section-lead">{{ __('Data Berikut Merupakan Detail Atlet ') }}.</p> --}}

    <div class="row">
      <div class="col-12">
        @if ($data->count() > 0)
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="card-header bg-primary text-white">
                            Biodata
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <tr>
                                    <td colspan="2" class="text-center">
                                        @if ($data->foto)
                                            <img src="{{asset('avatar/'.$data->foto)}}" class="rounded-circle img-thumbnail text-center" width="140px">
                                        @else
                                            <figure class="avatar mr-2 bg-success text-white" data-initial="{{ \App\Helpers\StringHelper::acronym(Auth::user()->name, 2) }}"></figure>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-center">
                                        <h5 class="mt-3">{{$data->nama}}</h5>
                                        <p class="text-muted">
                                            {{$cabor->nama}}<br>
                                           {{$data->nomor_cabor1}}
                                        </p>
                                        <p class="text-muted">Asal Pembinaan : {{$asal_pembinaan->nama}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tempat Lahir</td>
                                    <td>{{$data->tempat_lahir}}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Lahir </td>
                                    <td>{{$data->tanggal_lahir}}</td>
                                </tr>
                                <tr>
                                    <td>Golongan Darah</td>
                                    <td>{{$data->gol_darah}}</td>
                                </tr>
                                <tr>
                                  <td>Tinggi Badan</td>
                                  <td>{{$data->tinggi_badan}}</td>
                                </tr>
                                <tr>
                                  <td>Berat Badan</td>
                                  <td>{{$data->berat_badan}}</td>
                                </tr>
                                <tr>
                                    <td>Kelas </td>
                                    <td>{{$data->kelas}}</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>{{$data->alamat_domisili}}</td>
                                </tr>
                                <tr>
                                    <td>NISN </td>
                                    <td>{{$data->nisn}}</td>
                                </tr>
                                <tr>
                                  <td>NO KK</td>
                                  <td>{{$data->no_kk}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-footer bg-primary">

                        </div>
                    </div>
                    <div class="col-md-7">
                      <div class="card-header">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#prestasi" role="tab" aria-controls="home" aria-selected="true">Prestasi</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Fisik</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Skill</a>
                          </li>
                        </ul>
                      </div>
                      <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                          <div class="tab-pane fade show active" id="prestasi" role="tabpanel" aria-labelledby="home-tab">
                            <table class="table table-hover table-striped">
                              <tr>
                                <th>No</th>
                                <th>Master Event</th>
                                <th>Event</th>
                                <th>Medali</th>
                                <th>Tahun</th>
                              </tr>
                              @php
                                  $no = 1;
                              @endphp
                            </table>
                          </div>
                          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
                          <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        @else
          @include('stisla.includes.others.empty-state', ['title' => 'Data ' . $title, 'icon' => 'fa-solid fa-person', 'link' => $routeCreate])
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
  {{-- @if ($canImportExcel)
    @include('stisla.includes.modals.modal-import-excel', ['formAction' => $routeImportExcel, 'downloadLink' => $excelExampleLink])
  @endif --}}
@endpush
