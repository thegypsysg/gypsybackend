@extends('layouts.backend')
@section('content')
    <section class="content-header">
      <ul class="header-links d-flex p-0">
        <li><h4 class="mr-1"><a href="{{ route('countries.index') }}">Manage Countries</a></h4></li>
        <li><h4 class="mr-1"><a href="{{ route('cities.index') }}">Manage Cities</a></h4></li>
        <li><h4 class="mr-1"><a href="{{ route('towns.index') }}">Manage Towns</a></h4></li>
        <li><h4 class="mr-1"><a href="{{ route('zones.index') }}">Manage Zones</a></h4></li>
      </ul>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Manage Towns</a></li>
        <li class="active">Index</li>
      </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="box-header">
                            <h3 class="box-title">Manage Towns</h3>
                        </div>

                        @if(!isset($town))
                        <form action="{{ route('towns.store') }}" method="POST">
                        @else
                        <form action="{{ route('towns.update', $town->town_id) }}" method="POST">
                        @method('PATCH')
                        @endif
                            @csrf
                            <div class="container">
                                <div class="col-lg-2 p-0"> 
                                    @csrf
                                    <!-- <input type="text" name="town_name" class="form-control" value="{{ @$town->town_name }}" placeholder="Type town name"> -->
                                    <select name="town_name" id="town_name" class="form-control select2">
                                        <option value="">Type a town name</option>
                                        @foreach($towns as $data)
                                            <option value="{{ $data->town_name }}">{{ $data->town_name }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('town_name'))
                                    <small class="text-danger">{{ $errors->first('town_name') }}</small>
                                    @endif
                                </div>

                                <div class="col-lg-2">
                                    <select name="city_id" class="select2 form-control">
                                        <option value="">Select City</option>
                                        @foreach($cities as $city)
                                        <option value="{{ $city->city_id }}" {{ @$town->city_id == $city->city_id ? 'selected' : ''}}>{{ $city->city_name }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('city_id'))
                                    <small class="text-danger">{{ $errors->first('city_id') }}</small>
                                    @endif
                                </div>
                                
                                <div class="col-lg-2">
                                    <button class="btn btn-block btn-primary">{{ isset($town) ? 'Update' : 'Add'}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-3 dataTables_wrapper w-25 pt-2">
                        <div class="dataTables_length">
                            <label class="ml-2">Show 
                                <select id="table_length" aria-controls="countries" class="form-control input-sm">
                                    <option value="500">500</option>
                                    <option value="1000">1000</option>
                                    <option value="1500">1500</option>
                                    <option value="-1">All</option>
                                </select> 
                            entries</label>
                        </div>
                        <div id="countries_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control input-sm" placeholder="" id="search"></label></div>
                    </div>
                </div>
                
               
                

                <div class="box-body">
                    <table id="towns" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                            <th>Town Name</th>
                            <th>City Name</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($towns as $town)
                            <tr>
                                <td>{{ $town->town_name }}</td>
                                <td>{{ $town->city->city_name ?? '' }}</td>
                                <td class="d-flex">
                                    <a href="{{ route('towns.edit', $town->town_id) }}" class="btn btn-sm btn-warning mr-1"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('towns.destroy', $town->town_id) }}" method="POST" id="delete-{{$town->city_id}}">
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
    </section>
@endsection

@section('js')
<script>
    $(function () {
        let table = $('#towns').DataTable({
            "dom": 'tipr',
            "lengthMenu": [ [500, 1000, 1500, -1], [500, 1000, 1500, "All"] ]
        })

        $('#search').keyup(function(){
            table.search($(this).val()).draw();
        })

        $('#table_length').on('change', function(){
            table.page.len($(this).val()).draw();
        })
    })

    $(document).ready(function() {
        $('#town_name').select2({
            tags: true
        });
    })
</script>
@endsection