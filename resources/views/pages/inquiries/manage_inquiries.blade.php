@extends('layouts.backend')
@section('content')
    <section class="content-header">
      <h1>Inquiries</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Manage Inquiries</a></li>
        <li class="active">Index</li>
      </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class="row">
                            <form id="filterForm">
                                <div class="col-lg-3">
                                    <label for="">Type</label>
                                    <select name="" id="type" class="form-control">
                                        <option value="">All</option>
                                        <option value="Agency">Agency</option>
                                        <option value="Employer">Employer</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 p-0">
                                    <label for="">Countries</label>
                                    <select name="" id="country" class="form-control">
                                        <option value="">All</option>
                                        @foreach($countries as $country)
                                        <option value="{{ $country->country_name }}">{{ $country->country_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label class=""></label>
                                    <a id="reset" class="btn btn-primary mt-3">
                                        Reset filter
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="box-body">
                        <table id="inquiries" class="table table-bordered table-hover table-striped nowrap">
                            <thead>
                                <tr>
                                    <th>Inquiry</th>
                                    <th>Date</th>
                                    <th>Company Name</th>
                                    <th>Type</th>
                                    <th>Country</th>
                                    <th>City</th>
                                    <th>Email</th>
                                    <th>Position Held</th>
                                    <th>Contact person</th>
                                    <th>Action</th>                                
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach($inquiries as $inquiry)
                                <tr>
                                    <td>{{ $inquiry->inquiry_id }}</td>
                                    <td>{{ $inquiry->inquiry_date }}</td>
                                    <td>{{ $inquiry->company_name }}</td>
                                    <td >{{ $inquiry->type == 'E' ? 'Employer' : 'Agency' }}</td>
                                    <td>{{ $inquiry->country }}</td>
                                    <td >{{ $inquiry->city }}</td>
                                    <td >{{ $inquiry->email }}</td>
                                    <td>{{ $inquiry->position_held }}</td>
                                    <td>{{ $inquiry->contact_person }}</td>
                                    <td class="d-flex" >
                                        <a href="{{ route('inquiries.edit', $inquiry->inquiry_id) }}" class="btn btn-sm btn-warning mr-1" disabled style="pointer-events: none"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('inquiries.destroy', $inquiry->inquiry_id) }}" id="delete-{{$inquiry->inquiry_id}}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-sm btn-danger confirm" disabled><i class="fa fa-trash-o"></i></button>
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

$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var type = data[3];
        var data = $('#type').val()
        if (
            ( data === '' ) ||
            ( data === type )
        ) {
            return true;
        }
        return false;
    }
);

$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var country = data[4];
        var data = $('#country').val()
        if (
            ( data === '' ) ||
            ( data === country )
        ) {
            return true;
        }
        return false;
    }
);

    
    $(function () {
        var table = $('#inquiries').DataTable({
            "dom": 'tipr',
            "responsive": true,
            columnDefs: [
                { responsivePriority: 1, targets: 1 },
                { responsivePriority: 2, targets: 2 },
                { responsivePriority: 3, targets: 3 },
                { responsivePriority: 4, targets: 4 },
                { responsivePriority: 5, targets: 5 },
                { responsivePriority: 10002, targets: 6 },
                { responsivePriority: 10003, targets: 7 },
                { responsivePriority: 10004, targets: 8 },
                { responsivePriority: -1, targets: 9 },
            ],
            "ordering": false,
            "lengthMenu": [ [500, 1000, 1500, -1], [500, 1000, 1500, "All"] ]
        })

        $('#search').keyup(function(){
            table.search($(this).val()).draw();
        })

        $('#inquiries_length').on('change', function(){
            table.page.len($(this).val()).draw();
        })

        $('#type, #country').on('change', function () {
            table.draw();
        });

        $('#reset').on('click', function () {            
            $("#filterForm").trigger("reset");
            table.draw();
        });
    })

</script>
@endsection