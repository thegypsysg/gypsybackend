@extends('layouts.backend')
@section('content')
    <section class="content-header">
      <h1>
        Health Care
        <small>Health Care</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Health Care</a></li>
        <li class="active">Index</li>
      </ol>
    </section>


    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                
                <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Health Care</h3>
                </div>
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>No of Jobs</th>
                            <th>Image</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($healthCareSettings as $health)
                            <tr>
                                <td>{{ $health->settings_name }}</td>
                                <td>{{ $health->description }}</td>
                                <td>{{ $health->job_number }}</td>
                                <td>{{ $health->image }}</td>
                                <td class="d-flex">
                                    <a href="" class="btn btn-sm btn-warning mr-1"><i class="fa fa-edit"></i></a>
                                    <form action="#" method="POST">
                                        @csrf
                                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></button>
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
    $('#example1').DataTable()
    
  })
</script>
@endsection