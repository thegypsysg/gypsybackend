@extends('layouts.backend')
@section('content')
    <section class="content-header">
      <h1>Manage Users</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Manage Users</a></li>
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
                        @if(!isset($user))
                        <form action="{{ route('users.store') }}" method="POST">
                        @else
                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @method('PATCH')
                        @endif
                            @csrf
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-2 "> 
                                        @csrf
                                        <input type="text" name="name" class="form-control" value="{{ @$user->name }}" placeholder="Enter user Name">
                                        @if($errors->has('name'))
                                        <small class="text-danger">{{ $errors->first('name') }}</small>
                                        @endif
                                    </div>

                                    <div class="col-lg-2 p-0"> 
                                        @csrf
                                        <input type="text" name="email" class="form-control" value="{{ @$user->email }}" placeholder="Enter user email">
                                        @if($errors->has('email'))
                                        <small class="text-danger">{{ $errors->first('email') }}</small>
                                        @endif
                                    </div>

                                    <div class="col-lg-2 ">
                                        <select name="country_id" class="select2 form-control">
                                            <option value="">Select Country</option>
                                            @foreach($countries as $country)
                                            <option value="{{ $country->country_id }}" {{ @$user->country_id == $country->country_id ? 'selected' : ''}}>{{ $country->country_name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('country_id'))
                                        <small class="text-danger">{{ $errors->first('country_id') }}</small>
                                        @endif
                                    </div>
                                    
                                </div>

                                <div class="row mt-2">

                                    <div class="col-lg-2">
                                        <select name="type" class="select2 form-control">
                                            <option value="">Select Type</option>
                                            @if(!$hasSuperAdmin)
                                            <option value="S" {{ @$user->type == 'S' ? 'selected' : '' }}>Super Admin</option>
                                            @endif
                                            <option value="A" {{ @$user->type == 'A' ? 'selected' : '' }}>Admin</option>
                                            <option value="U" {{ @$user->type == 'U' ? 'selected' : '' }}>User</option>
                                        </select>
                                        @if($errors->has('type'))
                                        <small class="text-danger">{{ $errors->first('type') }}</small>
                                        @endif
                                    </div>

                                    <div class="col-lg-2 p-0">
                                        <button class="btn btn-block btn-primary">{{ isset($user) ? 'Update' : 'Add'}}</button>
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
                    <table id="cities" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Country</th>
                            <th>Type</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            @php 
                                if($user->type == 'S'){
                                    $type = "Super Admin";
                                } else if($user->type == 'A'){
                                    $type = "Admin";
                                } else {
                                    $type = "User";
                                }
                            @endphp
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->country->country_name ?? '' }}</td>
                                <td>{{ $type }}</td>
                                <td class="d-flex">
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning mr-1"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" id="delete-{{$user->id}}">
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
    
        let table = $('#cities').DataTable({
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