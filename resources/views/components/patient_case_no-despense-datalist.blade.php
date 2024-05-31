@foreach ($patients as $pat)
    <option value="{{ $pat->case_no }}">{{ $pat->first_name . ' ' . $pat->mid_name . ' ' . $pat->last_name }}</option>
@endforeach
