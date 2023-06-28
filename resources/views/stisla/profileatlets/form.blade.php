@extends('stisla.layouts.app')

@section('title')
  {{ $fullTitle }}
@endsection

@section('content')
  @include('stisla.includes.breadcrumbs.breadcrumb-form')

  <div class="section-body">

    <h2 class="section-title">{{ $fullTitle }}</h2>
    <p class="section-lead">{{ __('Merupakan halaman yang menampilkan form ' . $title) }}.</p>

    {{-- gunakan jika ingin menampilkan sesuatu informasi --}}
    {{-- <div class="alert alert-info alert-has-icon">
      <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
      <div class="alert-body">
        <div class="alert-title">{{ __('Informasi') }}</div>
        This is a info alert.
      </div>
    </div> --}}

    <div class="row">
      <div class="col-12">

        <div class="card">
          <div class="card-header">
            <h4><i class="fa fa-fa-solid fa-person-running"></i> {{ $fullTitle }}</h4>
          </div>
          <div class="card-body">
            <form action="{{ $action }}" method="POST" enctype="multipart/form-data">

              @isset($d)
                @method('PUT')
              @endisset

              <div class="row">
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'text', 'id'=>'nama', 'name'=>'nama', 'label'=>__('Nama Lengkap')])
                </div>
				<div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'text', 'id'=>'no_kk', 'name'=>'no_kk', 'label'=>__('Nomor KK')])
                </div>

				<div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'text', 'id'=>'nisn', 'name'=>'nisn', 'label'=>__('NISN')])
                </div>

				<div class="col-md-6">
                  @include('stisla.includes.forms.editors.textarea', ['required'=>true, 'type'=>'textarea', 'id'=>'alamat_domisili', 'name'=>'alamat_domisili', 'label'=>__('Alamat Domisili')])
                </div>

				<div class="col-md-6">
                  @include('stisla.includes.forms.selects.profileatlets.kelas', ['required'=>true, 'type'=>'text', 'id'=>'kelas', 'name'=>'kelas', 'label'=>__('Kelas')])
                </div>

				<div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'text', 'id'=>'tempat_lahir', 'name'=>'tempat_lahir', 'label'=>__('Tempat Lahir')])
                </div>

				<div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'date', 'id'=>'tanggal_lahir', 'name'=>'tanggal_lahir', 'label'=>__('Tanggal_lahir')])
                </div>

				<div class="col-md-6">
                  @include('stisla.includes.forms.selects.profileatlets.golongandarah', ['required'=>true, 'id'=>'gol_darah', 'name'=>'gol_darah', 'label'=>__('Golongan Darah'), 'options'=>[], 'multiple'=>false])
                </div>

				<div class="col-md-6">
                  @include('stisla.includes.forms.selects.jenis_kelamin', ['required'=>true, 'id'=>'jenis_kelamin', 'name'=>'jenis_kelamin', 'label'=>__('Jenis Kelamin'), 'options'=>[], 'multiple'=>false])
                </div>

				<div class="col-md-6">
                  @include('stisla.includes.forms.selects.profileatlets.select2cabor', ['required'=>true, 'id'=>'cabor', 'name'=>'cabor', 'label'=>__('Cabor'), 'options'=>[], 'multiple'=>false])
                </div>

				<div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'text', 'id'=>'nomor_cabor1', 'name'=>'nomor_cabor1', 'label'=>__('Nomor Cabor 1')])
                </div>

				<div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'text', 'id'=>'nomor_cabor2', 'name'=>'nomor_cabor2', 'label'=>__('Nomor Cabor 2')])
                </div>

				<div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'text', 'id'=>'nomor_cabor3', 'name'=>'nomor_cabor3', 'label'=>__('Nomor Cabor 3')])
                </div>

				<div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'text', 'id'=>'nomor_cabor4', 'name'=>'nomor_cabor4', 'label'=>__('Nomor Cabor 4')])
                </div>

				<div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'number', 'id'=>'tinggi_badan', 'name'=>'tinggi_badan', 'label'=>__('Tinggi Badan')])
                </div>

				<div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'number', 'id'=>'berat_badan', 'name'=>'berat_badan', 'label'=>__('Berat Badan')])
                </div>

				<div class="col-md-6">
                  @include('stisla.includes.forms.selects.provinsi', ['required'=>true, 'type'=>'text', 'id'=>'provinsi', 'name'=>'provinsi', 'label'=>__('Provinsi')])
                </div>

				<div class="col-md-6">
                  @include('stisla.includes.forms.selects.profileatlets.pembinaan', ['required'=>true, 'type'=>'text', 'id'=>'asal_pembinaan', 'name'=>'asal_pembinaan', 'label'=>__('Asal Pembinaan')])
                </div>

				<div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input-avatar', ['required'=>true, 'type'=>'text', 'id'=>'foto', 'name'=>'foto', 'label'=>__('Foto')])
                </div>



                <div class="col-md-12">
                  <br>

                  @csrf

                  @include('stisla.includes.forms.buttons.btn-save')
                  @include('stisla.includes.forms.buttons.btn-reset')
                </div>
              </div>
            </form>
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
