<table>
  <thead>
    <tr>
      <th>{{ __('#') }}</th>
      <th class="text-center">{{ __('Tempat') }}</th>
      <th class="text-center">{{ __('Tanggal') }}</th>
      <th class="text-center">{{ __('NISN') }}</th>
      <th class="text-center">{{ __('Tingkat Pendidikan') }}</th>
      <th class="text-center">{{ __('Alamat Domisili') }}</th>
      <th class="text-center">{{ __('Cabang Olahraga') }}</th>
      <th class="text-center">{{ __('Nomor Cabor') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($data as $item)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->tempat }}</td>
        <td>{{ $item->tanggal }}</td>
        <td>{{ $item->nisn }}</td>
        <td>{{ $item->tingkatPendidikan }}</td>
        <td>{{ $item->domisili }}</td>
        <td>{{ $item->cabor }}</td>
        <td>{{ $item->nomorCabor }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
