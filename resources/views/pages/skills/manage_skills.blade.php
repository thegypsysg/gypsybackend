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
      <h1>Skill Groups</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Skill Groups</a></li>
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
                            <h3 class="box-title">Manage skill</h3>
                        </div>
                        @if(!isset($skill))
                        <form action="{{ route('skills.store') }}" method="POST">
                        @else
                        <form action="{{ route('skills.update', $skill->sgm_id) }}" method="POST">
                        @method('PATCH')
                        @endif
                            @csrf
                            <div class="container">                                
                                <div class="col-lg-2 p-0">
                                    <input type="text" name="group_name" class="form-control" value="{{ @$skill->group_name }}" placeholder="Enter group name">
                                    @if($errors->has('group_name'))
                                    <small class="text-danger">{{ $errors->first('group_name') }}</small>
                                    @endif
                                </div>
                                <div class="col-lg-4">
                                    <textarea name="description" class="form-control" id="" rows="1" placeholder="Description">{!! @$skill->description !!}</textarea>
                                    @if($errors->has('description'))
                                    <small class="text-danger">{{ $errors->first('description') }}</small>
                                    @endif
                                </div>
                                <div class="col-lg-2 p-0">
                                    <button class="btn btn-block btn-primary">{{ isset($skill) ? 'Update' : 'Add'}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-3 dataTables_wrapper w-25 pt-2">
                        <div class="dataTables_length">
                            <label class="ml-2">Show 
                                <select id="skill_length" aria-controls="skill" class="form-control input-sm">
                                    <option value="500">500</option>
                                    <option value="1000">1000</option>
                                    <option value="1500">1500</option>
                                    <option value="-1">All</option>
                                </select> 
                            entries</label>
                        </div>
                        <div id="skill_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control input-sm" placeholder="" id="search"></label></div>
                        
                    </div>
                </div>
                <div class="box-body">
                    <table id="skill" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>No of Jobs</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($skills as $skill)
                            <tr>
                            <td style="width:32%">
                                    @php $id = $skill->sgm_id;
                                    $image = asset('images/uploader.png');
                                    if($skill->image !== null || file_exists(Storage::path('Skills/'.$image))){
                                        $image = imageUrl('Skills', $skill->image);
                                    }                                    
                                    @endphp
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <form class="file-uploader" action="{{ url('skills/upload-image') }}" enctype="multipart/form-data" method="POST" id="{{ $id }}">    
                                                @csrf
                                                @if($skill->image != null)
                                                <span class="icon">
                                                <i class="fa fa-close text-red removeImage mt-0" onclick="removeImage('{{ $id }}')" id="{{ $id }}"  ></i>
                                                </span>
                                                @endif

                                                <img src="{{ $image }}" id="image-{{ $id }}">
                                                <input type="hidden" name="sgm_id" value="{{ $skill->sgm_id }}">
                                                <input type="file" name="image" class="file-upload image" id="{{$id}}" onchange="uploadFile('{{ $id }}')" id="skill_image{{ $skill->sgm_id }}">                                        
                                            </form>
                                        </div>
                                        {{ $skill->group_name }}
                                    </div>                                    
                                </td>                                
                                <td>{{ $skill->description }}</td>
                                <td>{{ $skill->job_number }}</td>
                                <td class="d-flex" >
                                        <a href="{{ route('skills.edit', $skill->sgm_id) }}" class="btn btn-sm btn-warning mr-1"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('skills.destroy', $skill->sgm_id) }}" id="delete-{{$skill->sgm_id}}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-sm btn-danger confirm"><i class="fa fa-trash-o"></i></button>
                                        </form>
                                    </td>
                                </tr> 
                            @endforeach                           
                        </tbody>
                        
                    </table>
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
                                            <button type="button" class="btn btn-primary" id="crop">Crop</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
<script>
    $(function () {
        let table = $('#skill').DataTable({
            "dom": 'tipr',
            ordering: false,
            "lengthMenu": [ [500, 1000, 1500, -1], [500, 1000, 1500, "All"] ]
        })

        $('#search').keyup(function(){
            table.search($(this).val()).draw();
        })

        $('#skill_length').on('change', function(){
            table.page.len($(this).val()).draw();
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
                formData.append('sgm_id',id);
                formData.append('_token',"{{ csrf_token() }}")
                 $.ajax({
                    url: 'skills/upload-image',
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers:
                    {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                }).done(function(response){
                    document.getElementById('image-'+id).src = response.data
                    toastr.success(response.message, 'Success')
                    window.location.href="/skills"
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
                                url: 'skills/image-remove/'+id,
                                method: "GET",
                                headers: 
                                {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                }
                            }).done(function(response){
                                toastr.success(response.message, 'Success')
                                document.getElementById('image-'+id).src = response.data
                                window.location.href="/skills"
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

</script>
@endsection