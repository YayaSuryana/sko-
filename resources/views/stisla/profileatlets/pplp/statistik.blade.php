@extends('stisla.layouts.app')

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
        <div class="card">
            <div class="card-body">
                <div class="row">
                  <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                      <div class="card-icon bg-danger">
                        <!-- <i class="fas fa-users"></i> -->
                        <i class="fas fa-mars"></i>
                      </div>
                      <div class="card-wrap">
                        <div class="card-header">
                          <h4>Laki - Lki</h4>
                        </div>
                        <div class="card-body">
                          {{$laki}}
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                      <div class="card-icon bg-danger">
                        <i class="fas fa-venus"></i>
                      </div>
                      <div class="card-wrap">
                        <div class="card-header">
                          <h4>Perempuan</h4>
                        </div>
                        <div class="card-body">
                          {{$perempuan}}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
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
