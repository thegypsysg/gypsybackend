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
    <ul class="header-links d-flex p-0">
        <li>
            <h4 class="mr-1"><a href="{{ route('countries.index') }}">Manage Countries</a></h4>
        </li>
        <li>
            <h4 class="mr-1"><a href="{{ route('cities.index') }}">Manage Cities</a></h4>
        </li>
        <li>
            <h4 class="mr-1"><a href="{{ route('towns.index') }}">Manage Towns</a></h4>
        </li>
        <li>
            <h4 class="mr-1"><a href="{{ route('zones.index') }}">Manage Zones</a></h4>
        </li>
    </ul>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Manage Countries</a></li>
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
                            <h3 class="box-title">Manage Countries</h3>
                        </div>
                        @if(!isset($country))
                        <form action="{{ route('countries.store') }}" method="POST">
                            @else
                            <form action="{{ route('countries.update', $country->country_id) }}" method="POST">
                                @method('PATCH')
                                @endif
                                @csrf
                                <div class="container">
                                    <div class="col-lg-2 p-0">
                                        @csrf
                                        <select name="country_name" id="add_country" class="form-control select2">
                                            <option value="">Type a country name</option>
                                            @foreach($countries as $data)
                                            <option value="{{ $data->country_name }}">{{ $data->country_name }}</option>
                                            @endforeach
                                        </select>

                                        @if($errors->has('country_name'))
                                        <small class="text-danger">{{ $errors->first('country_name') }}</small>
                                        @endif
                                    </div>

                                    <div class="col-lg-2">
                                        <input type="text" name="country_code" class="form-control"
                                            value="{{ @$country->country_code }}" placeholder="Enter country code">
                                        @if($errors->has('country_code'))
                                        <small class="text-danger">{{ $errors->first('country_code') }}</small>
                                        @endif
                                    </div>
                                    <div class="col-lg-2 p-0">
                                        <input type="text" name="nationality" class="form-control"
                                            value="{{ @$country->nationality }}" placeholder="Enter nationality">
                                        @if($errors->has('nationality'))
                                        <small class="text-danger">{{ $errors->first('nationality') }}</small>
                                        @endif
                                    </div>
                                    <div class="col-lg-2">
                                        <button class="btn btn-block btn-primary">{{ isset($country) ? 'Update' :
                                            'Add'}}</button>
                                    </div>
                                </div>
                            </form>
                    </div>
                    <div class="col-lg-3 dataTables_wrapper w-25 pt-2">
                        <div class="dataTables_length">
                            <label class="ml-2">Show
                                <select id="countries_length" aria-controls="countries" class="form-control input-sm">
                                    <option value="500">500</option>
                                    <option value="1000">1000</option>
                                    <option value="1500">1500</option>
                                    <option value="-1">All</option>
                                </select>
                                entries</label>
                        </div>
                        <div id="countries_filter" class="dataTables_filter"><label>Search:<input type="search"
                                    class="form-control input-sm" placeholder="" id="search"></label></div>

                    </div>
                </div>

                <div class="box-body">
                    <table id="countries" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Country Name</th>
                                <th>Country Code</th>
                                <th>Nationality</th>
                                <th>Active</th>
                                <th>Favorite</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($countries as $country)
                            <tr>
                                <td style="width:46%">
                                    @php $id = $country->country_id;
                                    $image = asset('images/uploader.png');
                                    if($country->image != null){
                                    $image = asset('storage/'.$country->image);
                                    }

                                    @endphp
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <form class="file-uploader" action="{{ url('countries/upload-image') }}"
                                                enctype="multipart/form-data" method="POST" id="{{ $id }}">
                                                @csrf
                                                @if($country->image != null)
                                                <span class="icon">
                                                <i class="fa fa-close text-red removeImage mt-0" onclick="removeImage('{{ $id }}')" id="{{ $id }}"  ></i>
                                                </span>
                                                @endif
                                                <img src="{{ $image }}" id="image-{{ $id }}">
                                                <input type="hidden" name="country_id"
                                                    value="{{ $country->country_id }}">
                                                <input type="file" name="image" class="file-upload image" id="{{$id}}"
                                                    onchange="uploadFile('{{ $id }}')"
                                                    id="country_image{{ $country->country_id }}">
                                            </form>
                                        </div>
                                        <div class="col-lg-19">
                                            {{ $country->country_name }}

                                        </div>
                                    </div>


                                </td>
                                <td>{{ $country->country_code }}</td>
                                <td>{{ $country->nationality }}</td>
                                <td>
                                    <div class="btn-group btn-toggle" id="{{ $country->country_id }}">
                                        <button class="btn btn-xs {{ $country->active == 'Y' ? 'btn-primary ' : '' }}"
                                            onclick="isActive('{{$country->country_id}}', 'Y')">Yes</button>
                                        <button
                                            class="btn btn-xs  {{ $country->active == 'N' || $country->active == NULL ? 'btn-primary' : '' }}"
                                            onclick="isActive('{{$country->country_id}}', 'N')">No</button>
                                    </div>
                                </td>
                                <td>
                                    <!-- {{ $country->favorite }} -->
                                    <div class="btn-group btn-toggle" id="{{ $country->country_id }}">
                                        <button class="btn btn-xs {{ $country->favorite == 'Y' ? 'btn-primary ' : '' }}"
                                            onclick="isFavorite('{{$country->country_id}}', 'Y')">Yes</button>
                                        <button
                                            class="btn btn-xs  {{ $country->favorite == 'N' || $country->favorite == NULL ? 'btn-primary' : '' }}"
                                            onclick="isFavorite('{{$country->country_id}}', 'N')">No</button>
                                    </div>
                                </td>
                                <td class="d-flex">
                                    <a href="{{ route('countries.edit', $country->country_id) }}"
                                        class="btn btn-sm btn-warning mr-1"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('countries.destroy', $country->country_id) }}"
                                        id="delete-{{$country->country_id}}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-sm btn-danger confirm"><i
                                                class="fa fa-trash-o"></i></button>
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
        

    $(function () {

        var table = $('#countries').DataTable({
            "dom": 'tipr',
            "lengthMenu": [ [500, 1000, 1500, -1], [500, 1000, 1500, "All"] ]
        })

        $('#search').keyup(function(){
            table.search($(this).val()).draw();
        })

        $('#countries_length').on('change', function(){
            table.page.len($(this).val()).draw();
        })

        
    })

    function isActive(id, value){
        $.ajax({
            url: 'countries/update-active/'+id,
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

    function isFavorite(id, value){
        $.ajax({
            url: 'countries/update-favorite/'+id,
            method: "POST",
            data: { favorite: value },
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
                formData.append('country_id',id);
                formData.append('_token',"{{ csrf_token() }}")
                
                $.ajax({
                        url: 'countries/upload-image',
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
                        window.location.href="/countries"
                    }).fail(function(){
                        toastr.error(response.message, 'Error')
                    });
            });


           
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
                                url: 'countries/image-remove/'+id,
                                method: "GET",
                                headers: 
                                {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                }
                            }).done(function(response){
                                toastr.success(response.message, 'Success')
                                document.getElementById('image-'+id).src = response.data
                                window.location.href="/countries"

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

    $(document).ready(function() {
        $('#add_country').select2({
            tags: true
        });

       
    })
    
</script>
@endsection