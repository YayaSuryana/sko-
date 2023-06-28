<table>
  <thead>
    <tr>
      <th>{{ __('#') }}</th>
      <th class="text-center">{{ __('Nomor KK') }}</th>
      <th class="text-center">{{ __('NISN') }}</th>
      <th class="text-center">{{ __('Alamat Domisili') }}</th>
      <th class="text-center">{{ __('Kelas') }}</th>
      <th class="text-center">{{ __('Tempat Lahir') }}</th>
      <th class="text-center">{{ __('Tanggal_lahir') }}</th>
      <th class="text-center">{{ __('Golongan Darah') }}</th>
      <th class="text-center">{{ __('Jenis Kelamin') }}</th>
      <th class="text-center">{{ __('Cabor') }}</th>
      <th class="text-center">{{ __('Nomor Cabor 1') }}</th>
      <th class="text-center">{{ __('Nomor Cabor 2') }}</th>
      <th class="text-center">{{ __('Nomor Cabor 3') }}</th>
      <th class="text-center">{{ __('Nomor Cabor 4') }}</th>
      <th class="text-center">{{ __('Tinggi Badan') }}</th>
      <th class="text-center">{{ __('Berat Badan') }}</th>
      <th class="text-center">{{ __('Provinsi') }}</th>
      <th class="text-center">{{ __('Asal Pembinaan') }}</th>
      <th class="text-center">{{ __('Foto') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($data as $item)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->no_kk }}</td>
        <td>{{ $item->nisn }}</td>
        <td>{{ $item->alamat_domisili }}</td>
        <td>{{ $item->kelas }}</td>
        <td>{{ $item->tempat_lahir }}</td>
        <td>{{ $item->tanggal_lahir }}</td>
        <td>{{ $item->gol_darah }}</td>
        <td>{{ $item->jenis_kelamin }}</td>
        <td>{{ $item->cabor }}</td>
        <td>{{ $item->nomor_cabor1 }}</td>
        <td>{{ $item->nomor_cabor2 }}</td>
        <td>{{ $item->nomor_cabor3 }}</td>
        <td>{{ $item->nomor_cabor4 }}</td>
        <td>{{ $item->tinggi_badan }}</td>
        <td>{{ $item->berat_badan }}</td>
        <td>{{ $item->provinsi }}</td>
        <td>{{ $item->asal_pembinaan }}</td>
        <td>{{ $item->foto }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
