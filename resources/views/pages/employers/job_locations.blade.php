@extends('layouts.backend')
@section('content')
    <section class="content-header">
      <h1>{{ $employer->employer_name }}
        <small>Job Locations</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('employers.index') }}"><i class="fa fa-dashboard"></i> Manage Employers</a></li>
        <li class="active">Job Locations</li>
      </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body pb-2">                    
                        @if(!isset($employerJobLocation))
                        <form action="{{ route('employer-job-locations.store') }}" method="POST">
                        @else
                        <form action="{{ route('employer-job-locations.update', $employerJobLocation->ejl_id) }}" method="POST">
                        @method('PATCH')
                        @endif                     
                            @csrf
                                <input type="hidden" name="employer_id" value="{{ $employer->employer_id }}">
                                <div class="col-lg-3 mb-1">
                                    <label for="">Country</label>
                                    <select name="country_id" class="select2 form-control" id="country_id">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                        <option value="{{ $country->country_name }}" {{ @$employerJobLocation->country_id == $country->country_id ? 'selected' : ''}}>{{ $country->country_name }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('country_id'))
                                    <small class="text-danger">{{ $errors->first('country_id') }}</small>
                                    @endif
                                </div>

                                <div class="col-lg-3 mb-1 p-0">
                                    <label for="">City</label>
                                    <select name="city_id" class="select2 form-control" id="city_id">
                                        <option value="">Select City</option>
                                        @foreach($cities as $city)
                                        <option value="{{ $city->city_name }}" {{ @$employerJobLocation->city_id == $city->city_id ? 'selected' : ''}}>{{ $city->city_name }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('city_id'))
                                    <small class="text-danger">{{ $errors->first('city_id') }}</small>
                                    @endif
                                </div>

                                <div class="col-lg-3 mb-1">
                                    <label for="">Town</label>
                                    <select name="town_id" class="select2 form-control" id="town_id">
                                        <option value="">Select Town</option>
                                        @foreach($towns as $town)
                                        <option value="{{ $town->town_name }}" {{ @$employerJobLocation->town_id == $town->town_id ? 'selected' : ''}}>{{ $town->town_name }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('town_id'))
                                    <small class="text-danger">{{ $errors->first('town_id') }}</small>
                                    @endif
                                </div>

                                <div class="col-lg-3 mb-1 pl-0">
                                    <label for="">Zone</label>
                                    <select name="zone_id" class="select2 form-control" id="zone_id">
                                        <option value="">Select Town</option>
                                        @foreach($zones as $zone)
                                        <option value="{{ $zone->name }}" {{ @$employerJobLocation->zone_id == $zone->zone_id ? 'selected' : ''}}>{{ $zone->name }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('zone_id'))
                                    <small class="text-danger">{{ $errors->first('zone_id') }}</small>
                                    @endif
                                </div>

                                <div class="col-lg-2 mt-1 ">
                                    <button class="btn btn-block btn-primary">{{ isset($employerJobLocation) ? 'Update' : 'Add'}}</button>
                                </div>
                        </form>
    
                        <div class="col-lg-12 mt-2">
                            <table id="contacts" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                    <th>Country</th>
                                    <th>City</th>
                                    <th>Town</th>
                                    <th>Zone</th>
                                    <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employer->jobLocations as $jobLocation)
                                    <tr>                                
                                        <td >{{ $jobLocation->country->country_name }}</td>
                                        <td >{{ $jobLocation->city->city_name }}</td>
                                        <td >{{ $jobLocation->town->town_name }}</td>
                                        <td >{{ $jobLocation->zone->name }}</td>
                                        </td>
                                        <td style="width:3%" class="d-flex">
                                            <a href="{{ route('employer-job-locations.edit', $jobLocation->ejl_id) }}" class="btn btn-sm btn-warning mr-1"><i class="fa fa-edit"></i></a>
                                            <form action="{{ route('employer-job-locations.destroy', $jobLocation->ejl_id) }}" method="POST" id="delete-{{$jobLocation->ejl_id}}">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-sm btn-danger confirm"><i class="fa fa-trash-o"></i></button>
                                            </form>
                                        </td>
                                    </tr> 
                                    @endforeach                           
                                </tbody>                        
                            </table>
                        </div>
                    </div>                
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