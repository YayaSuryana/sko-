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
