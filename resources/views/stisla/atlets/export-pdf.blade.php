<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ __('Atlet') }}</title>

  <link rel="stylesheet" href="{{ asset('assets/css/export-pdf.min.css') }}">
</head>

<body>
  <h1>{{ __('Atlet') }}</h1>
  <h3>{{ __('Total Data:') }} {{ $data->count() }}</h3>
  <table>
    <thead>
      <tr>
        <th>{{ __('#') }}</th>
        <th class="text-center">{{ __('Nama Atlet') }}</th>
        <th class="text-center">{{ __('Tempat Lahir') }}</th>
        <th class="text-center">{{ __('Tanggal Lahir') }}</th>
        <th class="text-center">{{ __('NISN') }}</th>
        <th class="text-center">{{ __('Tingkat Pendidikan') }}</th>
        <th class="text-center">{{ __('Alamat Domisili') }}</th>
        <th class="text-center">{{ __('Cabang Olahraga') }}</th>
        <th class="text-center">{{ __('Nomor Cabor') }}</th>
        <th class="text-center">{{ __('Foto') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($data as $item)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $item->nama }}</td>
          <td>{{ $item->tempatLahir }}</td>
          <td>{{ $item->tanggalLahir }}</td>
          <td>{{ $item->nisn }}</td>
          <td>{{ $item->tingkatPendidikan }}</td>
          <td>{{ $item->alamat }}</td>
          <td>{{ $item->cabor }}</td>
          <td>{{ $item->nomor }}</td>
          <td>{{ $item->foto }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  @if (($isPrint ?? false) === true)
    <script>
      window.print();
    </script>
  @endif

</body>

</html>
