<option value="">Select Town</option>
@forelse($towns->towns as $town)
    <option value="{{ $town->town_id }}">{{ $town->town_name }}</option>
@empty
    <option disabled>No records</option>
@endforelse