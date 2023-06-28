<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ __('Prestasi') }}</title>

  <link rel="stylesheet" href="{{ asset('assets/css/export-pdf.min.css') }}">
</head>

<body>
  <h1>{{ __('Prestasi') }}</h1>
  <h3>{{ __('Total Data:') }} {{ $data->count() }}</h3>
  <table>
    <thead>
      <tr>
        <th>{{ __('#') }}</th>
        <th class="text-center">{{ __('Nama Atlet') }}</th>
        <th class="text-center">{{ __('Master Event') }}</th>
        <th class="text-center">{{ __('Nama Event') }}</th>
        <th class="text-center">{{ __('Medali') }}</th>
        <th class="text-center">{{ __('Tahun') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($data as $item)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $item->atlet_id }}</td>
          <td>{{ $item->masterevent_id }}</td>
          <td>{{ $item->event_id }}</td>
          <td>{{ $item->medali }}</td>
          <td>{{ $item->tahun }}</td>
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
