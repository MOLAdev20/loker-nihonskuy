@foreach ($advancedFilterState as $filterName => $filterValue)
  @if (is_array($filterValue))
    @foreach ($filterValue as $filterItem)
      <input type="hidden" name="{{ $filterName }}[]" value="{{ $filterItem }}">
    @endforeach
  @elseif ($filterValue !== '')
    <input type="hidden" name="{{ $filterName }}" value="{{ $filterValue }}">
  @endif
@endforeach
