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
            <h4><i class="fa fa-fa-solid fa-person"></i> {{ $fullTitle }}</h4>
          </div>
          <div class="card-body">
            <form action="{{ $action }}" method="POST" enctype="multipart/form-data">

              @isset($d)
                @method('PUT')
              @endisset

              <div class="row">
				<div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'text', 'id'=>'nama', 'name'=>'nama', 'label'=>__('Nama Atlet')])
                </div>

				<div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'text', 'id'=>'tempatLahir', 'name'=>'tempatLahir', 'label'=>__('Tempat Lahir')])
                </div>

				<div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'date', 'id'=>'tanggalLahir', 'name'=>'tanggalLahir', 'label'=>__('Tanggal Lahir')])
                </div>

				<div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'text', 'id'=>'nisn', 'name'=>'nisn', 'label'=>__('NISN')])
                </div>

				<div class="col-md-6">
                  @include('stisla.includes.forms.selects.atlet.select2pendidikan', ['required'=>true, 'id'=>'tingkatPendidikan', 'name'=>'tingkatPendidikan', 'label'=>__('Tingkat Pendidikan'), 'options'=>[], 'multiple'=>false])
                </div>

				<div class="col-md-6">
                  @include('stisla.includes.forms.editors.textarea', ['required'=>true, 'type'=>'textarea', 'id'=>'alamat', 'name'=>'alamat', 'label'=>__('Alamat Domisili')])
                </div>

				<div class="col-md-6">
                  @include('stisla.includes.forms.selects.atlet.select2cabor', ['required'=>true, 'id'=>'cabor', 'name'=>'cabor', 'label'=>__('Cabang Olahraga'), 'options'=>[], 'multiple'=>false])
                </div>

				<div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', ['required'=>true, 'id'=>'nomor', 'name'=>'nomor', 'label'=>__('Nomor Cabor'), 'options'=>[], 'multiple'=>false])
                </div>

				<div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input-avatar', ['required'=>false, 'type'=>'text', 'id'=>'foto', 'name'=>'foto', 'label'=>__('Foto')])
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
