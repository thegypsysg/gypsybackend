<option value="">Select City</option>
@foreach($cities->cities as $city)
    <option value="{{ $city->city_name }}">{{ $city->city_name }}</option>
@endforeach