@extends('layouts.backend')
@section('content')
    <section class="content-header">
      <h1>{{ $employer->employer_name }}
        <small>Contacts</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('employers.index') }}"><i class="fa fa-dashboard"></i> Manage Employers</a></li>
        <li class="active">contacts</li>
      </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body pb-2">                    
                        @if(!isset($employerContact))
                        <form action="{{ route('employer-contacts.store') }}" method="POST">
                        @else
                        <form action="{{ route('employer-contacts.update', $employerContact->ec_id) }}" method="POST">
                        @method('PATCH')
                        @endif                     
                            @csrf
                                <input type="hidden" name="employer_id" value="{{ $employer->employer_id }}">
                                <div class="col-lg-3 mb-1">
                                    <label for="">Contact Person</label>
                                    <input type="text" name="name" class="form-control" value="{{ @$employerContact->name }}" placeholder="Enter employer Name">
                                    @if($errors->has('name'))
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                    @endif
                                </div>

                                <div class="col-lg-3 mb-1 p-0">
                                    <label for="">Position Held</label>
                                    <input type="text" name="position_held" class="form-control" value="{{ @$employerContact->position_held }}" placeholder="Enter employer position">
                                    @if($errors->has('position_held'))
                                    <small class="text-danger">{{ $errors->first('position_held') }}</small>
                                    @endif
                                </div>

                                <div class="col-lg-3 mb-1">
                                    <label for="">Contact</label>
                                    <input type="text" name="phone_number" class="form-control" value="{{ @$employerContact->phone_number }}" placeholder="Enter employer contact">
                                    @if($errors->has('phone_number'))
                                    <small class="text-danger">{{ $errors->first('phone_number') }}</small>
                                    @endif
                                </div>

                                <div class="col-lg-3 mb-1 pl-0">
                                    <label for="">Email</label>
                                    <input type="text" name="email_id" class="form-control" value="{{ @$employerContact->email_id }}" placeholder="Enter employer email">
                                    @if($errors->has('email_id'))
                                    <small class="text-danger">{{ $errors->first('email_id') }}</small>
                                    @endif
                                </div>

                                <div class="col-lg-2 mt-1 ">
                                    <button class="btn btn-block btn-primary">{{ isset($employerContact) ? 'Update' : 'Add'}}</button>
                                </div>
                        </form>
    
                        <div class="col-lg-12 mt-2">
                            <table id="contacts" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                    <th>Contact Person</th>
                                    <th>Position Held</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employer->contacts as $contact)
                                    <tr>                                
                                        <td >{{ $contact->name }}</td>
                                        <td >{{ $contact->position_held }}</td>
                                        <td >{{ $contact->phone_number }}</td>
                                        <td >{{ $contact->email_id }}</td>
                                        </td>
                                        <td style="width:3%" class="d-flex">
                                            <a href="{{ route('employer-contacts.edit', $contact->ec_id) }}" class="btn btn-sm btn-warning mr-1"><i class="fa fa-edit"></i></a>
                                            <form action="{{ route('employer-contacts.destroy', $contact->ec_id) }}" method="POST" id="delete-{{$contact->ec_id}}">
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
    
</script>
@endsection