@extends('layouts.backend')
<style type="text/css">
    body{
        background:#f6d352; 
    }
    h1{
        font-weight: bold;
        font-size:23px;
    }
    img {
        display: block;
        max-width: 100%;
    }
    .preview {
        text-align: center;
        overflow: hidden;
        width: 160px; 
        height: 160px;
        margin: 10px;
        border: 1px solid red;
    }
    input{
        margin-top:40px;
    }
    .section{
        margin-top:150px;
        background:#fff;
        padding:50px 30px;
    }
    .modal-lg{
        max-width: 1000px !important;
    }
    .show-icon {
    display: block !important;
}
</style>
@section('content')
    <section class="content-header">
      <h1>Manage Employers</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Manage Employers</a></li>
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
                        @if(!isset($employer))
                        <form action="{{ route('employers.store') }}" method="POST">
                        @else
                        <form action="{{ route('employers.update', $employer->employer_id) }}" method="POST">
                        @method('PATCH')
                        @endif
                            @csrf
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-2 "> 
                                        @csrf
                                        <input type="text" name="employer_name" class="form-control" value="{{ @$employer->employer_name }}" placeholder="Enter employer Name">
                                        @if($errors->has('employer_name'))
                                        <small class="text-danger">{{ $errors->first('employer_name') }}</small>
                                        @endif
                                    </div>

                                    <div class="col-lg-2 p-0">
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
                                    
                                </div>

                                <div class="row mt-2">

                                <div class="col-lg-2 ">
                                        <select name="country_id" class="select2 form-control" id="country_id">
                                            <option value="">Select Country</option>
                                            @foreach($countries as $country)
                                            <option value="{{ $country->country_name }}" {{ @$employer->country_id == $country->country_id ? 'selected' : ''}}>{{ $country->country_name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('country_id'))
                                        <small class="text-danger">{{ $errors->first('country_id') }}</small>
                                        @endif
                                    </div>

                                    <div class="col-lg-2 p-0">
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
                                    
                                    <div class="col-lg-2 ">
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

                                    <div class="col-lg-2 p-0">
                                        <button class="btn btn-block btn-primary">{{ isset($employer) ? 'Update' : 'Add'}}</button>
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
                            <th>Employer Name</th>
                            <th>Country</th>
                            <th>City</th>
                            <th>Town</th>
                            <th>Type</th>
                            <th>Active</th>
                            <th>Featured</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employers as $employer)
                            <tr>
                                <td style="width:30%">
                                    @php $id = $employer->employer_id;
                                    $image = asset('images/uploader.png');
                                    if($employer->image !== null || file_exists(Storage::path('Employers/'.$image))){
                                        $image = asset('storage/'. $employer->image);
                                    }                                    
                                    @endphp
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <form class="file-uploader" action="{{ url('employers/upload-image') }}" enctype="multipart/form-data" method="POST" id="{{ $id }}">    
                                                @csrf
                                                @if($employer->image != null)
                                                <span class="icon">
                                                <i class="fa fa-close text-red removeImage mt-0" onclick="removeImage('{{ $id }}')" id="{{ $id }}"  ></i>
                                                </span>
                                                @endif
                                                <img src="{{ $image }}" id="image-{{ $id }}">
                                                <input type="hidden" name="employer_id" value="{{ $country->employer_id }}">
                                                <input type="file" name="image" class="file-upload image" id="{{$id}}" onchange="uploadFile('{{ $id }}')" id="employer_image{{ $employer->employer_id }}">                                        
                                            </form>
                                        </div>
                                        <div class="col-lg-10 p-0">
                                            {{ $employer->employer_name }}
                                            <span class="d-flex floating-data">
                                                <ul class="p-0 list-style-none float-left">
                                                    <li class="float-left mr-1 bold"><a href="{{ route('employers.mainInfo', $employer->employer_id) }}">Main Info &nbsp;|</a></li>
                                                    <li class="float-left mr-1 bold"><a href="{{ route('employer-contacts.show', $employer->employer_id) }}">Contact &nbsp;|</a></li>
                                                    <li class="float-left mr-1 bold"><a href="{{ route('employer-job-locations.show', $employer->employer_id) }}">Job Location |</a></li>
                                                    <li class="float-left mr-1 bold"><a href="">Images |</a></li>
                                                    <li class="float-left mr-1 bold"><a href="">Social  Media &nbsp;</a></li>
                                                </ul>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td style="width: 16%">{{ $employer->country->country_name ?? '' }}</td>
                                <td >{{ $employer->city->city_name ?? '' }}</td>
                                <td >{{ $employer->town->town_name ?? '' }}</td>
                                <td >{{ $employer->type->settings_name ?? '' }}</td>
                                <td style="width: 7%">
                                    <div class="btn-group btn-toggle" id="{{ $employer->employer_id }}">
                                        <button class="btn btn-xs {{ $employer->active == 'Y' ? 'btn-primary ' : '' }}" onclick="isActive('{{$employer->employer_id}}', 'Y')">Yes</button>
                                        <button class="btn btn-xs  {{ $employer->active == 'N' || $employer->active == NULL ? 'btn-primary' : '' }}" onclick="isActive('{{$employer->employer_id}}', 'N')">No</button>
                                    </div>
                                </td>
                                <td >
                                    <div class="btn-group btn-toggle" id="{{ $employer->employer_id }}">
                                        <button class="btn btn-xs {{ $employer->featured == 'Y' ? 'btn-primary ' : '' }}" onclick="isFeatured('{{$employer->employer_id}}', 'Y')">Yes</button>
                                        <button class="btn btn-xs  {{ $employer->featured == 'N' || $employer->featured == NULL ? 'btn-primary' : '' }}" onclick="isFeatured('{{$employer->employer_id}}', 'N')">No</button>
                                    </div>
                                </td>
                                <td style="width:3%" class="d-flex">
                                    <a href="{{ route('employers.edit', $employer->employer_id) }}" class="btn btn-sm btn-warning mr-1"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('employers.destroy', $employer->employer_id) }}" method="POST" id="delete-{{$employer->city_id}}">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-sm btn-danger confirm"><i class="fa fa-trash-o"></i></button>
                                    </form>
                                </td>
                            </tr> 
                            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalLabel">Crop image here before upload image</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="img-container">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="preview"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-primary" data-id="{{ $id }}" id="crop">Crop</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
            var country = data[1];
            var data = $('#country_id').val()
            if (
                ( data === '' ) ||
                ( data === country )
            ) {
                return true;
            }
            return false;
        }
    );

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var city = data[2];
            var data = $('#city_id').val()
            if (
                ( data === '' ) ||
                ( data === city )
            ) {
                return true;
            }
            return false;
        }
    );
    
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

        function isActive(id, value){
            $.ajax({
                url: 'employers/update-active/'+id,
                method: "POST",
                data: { active: value },
                headers: 
                {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            }).done(function(response){
                toastr.success(response.message, 'Success')
            }).fail(function(){
                toastr.error(response.message, 'Error')
            });
        }

        function isFeatured(id, value){
            $.ajax({
                url: 'employers/update-featured/'+id,
                method: "POST",
                data: { featured: value },
                headers: 
                {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            }).done(function(response){
                toastr.success(response.message, 'Success')
            }).fail(function(){
                toastr.error(response.message, 'Error')
            });
        }
        function removeImage(id){
        $('.removeImage').on('click', function(e){
            e.preventDefault();
            
            $.confirm({
                title: 'A secure action',
                content: 'Are You sure to delete this image?',
                icon: 'fa fa-question-circle',
                animation: 'scale',
                closeAnimation: 'scale',
                opacity: 0.5,
                buttons: {
                    'confirm': {
                        text: 'Proceed',
                        btnClass: 'btn-blue',
                        action: function(){
                            $.ajax({
                                url: 'employers/image-remove/'+id,
                                method: "GET",
                                headers: 
                                {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                }
                            }).done(function(response){
                                toastr.success(response.message, 'Success')
                                document.getElementById('image-'+id).src = response.data
                                window.location.href="/employers"

                            }).fail(function(){
                                toastr.error(response.message, 'Error')
                            });
                        }
                    },
                    cancel: function(){
                        return
                    }
                }
            });
        });

    }

        $('#country_id').on('change', function(){
            let country_id = $(this).val();
            table.draw()
            $.get('country/'+country_id).done(function(response){
                $('#city_id').html(response);
            })
            
        })

        $('#city_id').on('change', function(){
            let city_id = $(this).val();
            table.draw()
            $.get('city/'+city_id).done(function(response){
                $('#town_id').html(response);
            })
        })

        function uploadFile(id){
        let form = document.getElementById(id);
        var $modal = $('#modal');
        var image = document.getElementById('image');
        var cropper;

        $("body").on("change", ".image", function(e){
            var files = e.target.files;
            var done = function (url) {
                image.src = url;
                $modal.modal('show');
            };

            var reader;
            var file;
            var url;

            if (files && files.length > 0) {
                file = files[0];

                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function (e) {
                        done(reader.result);
                    };
                reader.readAsDataURL(file);
                }
            }
        });

        $modal.on('shown.bs.modal', function () {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });
        
        $("#crop").click(function(){
            cropper.getCroppedCanvas().toBlob(function(blob) {
                var formData = new FormData();
                formData.append('image', blob);
                formData.append('employee_id',id);
                formData.append('_token',"{{ csrf_token() }}")
                
                $.ajax({
                        url: 'employers/upload-image',
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: 
                        {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        }
                    }).done(function(response){
                        console.log(response)
                        $modal.modal('hide');
                        document.getElementById('image-'+id).src = response.data
                        $('#'+id).parent().show();
                        toastr.success(response.message, 'Success')
                        window.location.href="/employers"
                    }).fail(function(){
                        toastr.error(response.message, 'Error')
                    });
            });


           
        });
        
    }

</script>
@endsection