@php
  $name = $name ?? $id;
  $oldValue = old($name);
  $isMultiple = $multiple ?? ($isMultiple ?? false);
  $isRequired = $required ?? ($isRequired ?? false);
  // $pembinaan = $options;

  $dname = $d[$name] ?? false;
  if ($isMultiple) {
      $selectedArray = is_array($dname) ? $dname : ($dname ? [$dname] : []);
      $selected = $oldValue ?? ($selected ?? $selectedArray);
  } else {
      $selected = $oldValue ?? ($selected ?? ($dname ?? false));
  }

@endphp

<div class="form-group">
  <label @isset($id) for="{{ $id }}" @endisset>
    {{ $label }}
    @if ($isRequired)
      <span class="text-danger">*</span>
    @endif
  </label>
  <select @if ($isRequired) required @endif @if ($isMultiple) multiple @endif name="{{ $isMultiple ? $name . '[]' : $name }}" id="{{ $id }}"
    class="form-control select2">
    @if ($with_all ?? false)
      <option value="" @if ($selected == '' || $selected == null) selected @endif>{{ __('Semua') }}</option>
    @endif
    @if ($isMultiple)
      @foreach ($pembinaan as $option)
        <option @if (in_array($option->id, $selected)) selected @endif value="{{ $option->id }}">{{ $option->nama }}</option>
      @endforeach
    @else
      @foreach ($pembinaan as $option)
        <option @if ($selected == $option->id) selected @endif value="{{ $option->id }}">{{ $option->nama }}</option>
      @endforeach
    @endif
  </select>
</div>

@if (!defined('SELECT2_IMPORT'))
  @php
    define('SELECT2_IMPORT', true);
  @endphp

  @push('js')
    <script src="{{ asset('stisla/node_modules/select2/dist/js/select2.full.min.js') }}"></script>
  @endpush

  @push('css')
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/select2/dist/css/select2.min.css') }}">
  @endpush

  @push('scripts')
    <script>
      $(function() {

      });
    </script>
  @endpush
@endif
