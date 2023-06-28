<table>
  <thead>
    <tr>
      <th>{{ __('#') }}</th>
      <th class="text-center">{{ __('Master Event') }}</th>
      <th class="text-center">{{ __('Nama Event') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($data as $item)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->masterevent_id }}</td>
        <td>{{ $item->nama }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
