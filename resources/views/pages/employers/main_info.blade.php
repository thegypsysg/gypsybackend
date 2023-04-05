@extends('layouts.backend')
@section('content')
    <section class="content-header">
      <h1>Main Info</h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('employers.index') }}"><i class="fa fa-dashboard"></i> Manage Employers</a></li>
        <li class="active">Main Info</li>
      </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                <div class="box-body pb-2">                    
                    <form action="{{ route('employers.update', $employer->employer_id) }}" method="POST">
                    @method('PATCH')                       
                        @csrf
                        <div class="">
                            
                            <div class="col-lg-6 mb-2"> 
                                @csrf
                                <label for="">Employer Name</label>
                                <input type="text" name="employer_name" class="form-control" value="{{ @$employer->employer_name }}" placeholder="Enter employer Name">
                                @if($errors->has('employer_name'))
                                <small class="text-danger">{{ $errors->first('employer_name') }}</small>
                                @endif
                            </div>

                            <div class="col-lg-6 p-0 mb-2">
                                <label for="">Employer Type</label>
                                <select name="hs_id" class="select2 form-control">
                                    <option value="">Select Type</option>
                                    @foreach($types as $type)
                                    <option value="{{ $type->hs_id }}" {{ @$employer->hs_id == $type->hs_id ? 'selected' : ''}}>{{ $type->settings_name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('hs_id'))
                                <small class="text-danger">{{ $errors->first('hs_id') }}</small>
                                @endif
                            </div>
                        
                            <div class="col-lg-3 mb-2">
                                <label for="">Country</label>
                                <select name="country_id" class="select2 form-control" id="country_id">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                    <option value="{{ $country->country_id }}" {{ @$employer->country_id == $country->country_id ? 'selected' : ''}}>{{ $country->country_name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('country_id'))
                                <small class="text-danger">{{ $errors->first('country_id') }}</small>
                                @endif
                            </div>

                            <div class="col-lg-3 p-0 mb-2">
                                <label for="">City</label>
                                <select name="city_id" class="select2 form-control" id="city_id">
                                    <option value="">Select City</option>
                                    @foreach($cities as $city)
                                    <option value="{{ $city->city_id }}" {{ @$employer->city_id == $city->city_id ? 'selected' : ''}}>{{ $city->city_name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('city_id'))
                                <small class="text-danger">{{ $errors->first('city_id') }}</small>
                                @endif
                            </div>
                            
                            <div class="col-lg-3 mb-2">
                                <label for="">Town</label>
                                <select name="town_id" class="select2 form-control" id="town_id">
                                    <option value="">Select Town</option>
                                    @foreach($towns as $town)
                                    <option value="{{ $town->town_id }}" {{ @$employer->town_id == $town->town_id ? 'selected' : ''}}>{{ $town->town_name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('town_id'))
                                <small class="text-danger">{{ $errors->first('town_id') }}</small>
                                @endif
                            </div>

                            <div class="col-lg-3 p-0 mb-2">
                                <label for="">Zone</label>
                                <select name="zone_id" class="select2 form-control">
                                    <option value="">Select Zone</option>
                                    @foreach($zones as $zone)
                                    <option value="{{ $zone->zone_id }}" {{ @$employer->zone_id == $zone->zone_id ? 'selected' : ''}}>{{ $zone->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('zone_id'))
                                <small class="text-danger">{{ $errors->first('zone_id') }}</small>
                                @endif
                            </div>

                            <div class="col-lg-4 mb-2">
                                <label for="">Website</label>
                                <input type="text" name="website" class="form-control" value="{{$employer->website}}" id="">
                                @if($errors->has('website'))
                                <small class="text-danger">{{ $errors->first('website') }}</small>
                                @endif
                            </div>

                            <div class="col-lg-4 p-0 mb-2">
                                <label for="">Telephone</label>
                                <input type="text" name="telephone" class="form-control" value="{{$employer->telephone}}" id="">
                                @if($errors->has('telephone'))
                                <small class="text-danger">{{ $errors->first('telephone') }}</small>
                                @endif
                            </div>
                            
                            <div class="col-lg-4 mb-2">
                                <label for="">Postcode</label>
                                <input type="text" name="postal_code" class="form-control" value="{{$employer->postal_code}}" id="">
                                @if($errors->has('postal_code'))
                                <small class="text-danger">{{ $errors->first('postal_code') }}</small>
                                @endif
                            </div>

                            <div class="col-lg-12 mb-1">
                                <label for="">Address</label>
                                <textarea name="address" id="" class="form-control" rows="5">{!! $employer->address !!}</textarea>                                    
                                @if($errors->has('address'))
                                <small class="text-danger">{{ $errors->first('address') }}</small>
                                @endif
                            </div>

                            <div class="col-lg-2 mt-1 ">
                                <button class="btn btn-block btn-primary">Update</button>
                            </div>
                            
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </section>
@endsection

@section('js')
<script>
    $('#country_id').on('change', function(){
        let country_id = $(this).val();
        $.get('/country/'+country_id).done(function(response){
            $('#city_id').html(response);
        })
        
    })

    $('#city_id').on('change', function(){
        let city_id = $(this).val();
        $.get('/city/'+city_id).done(function(response){
            $('#town_id').html(response);
        })
    })
</script>
@endsection