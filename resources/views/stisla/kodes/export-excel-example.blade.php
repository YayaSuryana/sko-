<table>
  <thead>
    <tr>
      <th>{{ __('#') }}</th>
      <th class="text-center">{{ __('Nama Kode') }}</th>
      <th class="text-center">{{ __('Keterangan') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($data as $item)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->nama }}</td>
        <td>{{ $item->Keterangan }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
