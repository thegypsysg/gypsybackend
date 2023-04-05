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
        <li><a href="#"><i class="fa fa-dashboard"></i> Manage Zones</a></li>
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
                                <h3 class="box-title">Manage Zones</h3>
                            </div>
                            @if(!isset($zone))
                            <form action="{{ route('zones.store') }}" method="POST">
                            @else
                            <form action="{{ route('zones.update', $zone->zone_id) }}" method="POST">
                            @method('PATCH')
                            @endif
                                @csrf
                                <div class="container">
                                    <div class="col-lg-2 p-0"> 
                                        @csrf
                                        <input type="text" name="name" class="form-control" value="{{ @$zone->name }}" placeholder="Type zone name">
                                        @if($errors->has('name'))
                                        <small class="text-danger">{{ $errors->first('name') }}</small>
                                        @endif
                                    </div>
                                    
                                    <div class="col-lg-2">
                                        <button class="btn btn-block btn-primary">{{ isset($zone) ? 'Update' : 'Add'}}</button>
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
                        <table id="zones" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                <th>Zone Name</th>
                                <th>User</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($zones as $zone)
                                <tr>
                                    <td>{{ $zone->name }}</td>
                                    <td>{{ $zone->user->name ?? '' }}</td>
                                    <td class="d-flex">
                                        <a href="{{ route('zones.edit', $zone->zone_id) }}" class="btn btn-sm btn-warning mr-1"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('zones.destroy', $zone->zone_id) }}" method="POST" id="delete-{{$zone->zone_id}}">
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
        let table = $('#zones').DataTable({
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
</script>
@endsection