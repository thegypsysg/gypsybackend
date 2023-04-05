@extends('layouts.backend')
@section('content')
    <section class="content-header">
      <h1>App Groups</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> App Groups</a></li>
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
                            
                        </div>
                        @if(!isset($app_group))
                        <form action="{{ route('app-groups.store') }}" method="POST">
                        @else
                        <form action="{{ route('app-groups.update', $app_group->app_group_id) }}" method="POST">
                        @method('PATCH')
                        @endif
                            @csrf
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-2 "> 
                                        @csrf
                                        <input type="text" name="app_group_name" class="form-control" value="{{ @$app_group->app_group_name }}" placeholder="App Group Name">
                                        @if($errors->has('app_group_name'))
                                        <small class="text-danger">{{ $errors->first('app_group_name') }}</small>
                                        @endif
                                    </div>

                                    <div class="col-lg-2 p-0"> 
                                        @csrf
                                        <textarea name="description" class="form-control" value="" rows="1" placeholder="Description">{{ @$app_group->description }}</textarea>
                                        @if($errors->has('description'))
                                        <small class="text-danger">{{ $errors->first('description') }}</small>
                                        @endif
                                    </div>
                                    <div class="col-lg-2 p-2">
                                        <button class="btn btn-block btn-primary">{{ isset($app_group) ? 'Update' : 'Add'}}</button>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-3 dataTables_wrapper w-25 ">
                        <span class="box-header"></span>
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
                    <table id="app-groups" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                            <th>ID</th>
                            <th>Group Nmae</th>
                            <th>Description</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($groups as $group)
                            <tr>
                                <td>{{ $group->app_group_id }}</td>
                                <td>{{ $group->app_group_name }}</td>
                                <td>{{ $group->description }}</td>
                                <td class="d-flex">
                                    <a href="{{ route('app-groups.edit',$group->app_group_id) }}" class="btn btn-sm btn-warning mr-1"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('app-groups.destroy',$group->app_group_id) }}" method="POST" id="delete-{{$group->app_group_id}}">
                                        @method('DELETE')
                                        @csrf
                                        <button type="button" class="btn btn-sm btn-danger confirm"><i class="fa fa-trash-o"></i></button>
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
    
        let table = $('#app-groups').DataTable({
            "dom": 'tipr',
            ordering: false,
            "lengthMenu": [ [500, 1000, 1500, -1], [500, 1000, 1500, "All"] ]
        })

        $('#search').keyup(function(){
            table.search($(this).val()).draw();
        })

        $('#table_length').on('change', function(){
            table.page.len($(this).val()).draw();
        })

</script>
@endsection