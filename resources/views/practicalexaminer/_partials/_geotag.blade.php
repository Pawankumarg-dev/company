{{-- @if($exam->geotaggedphotos->where('exam_date',$date)->count() > 0 || $geotagged == 0 || $markuploadstatus == true)  --}}
<a href="javascript:upload({{$exam->id}})" class="btn btn-xs btn-primary link_{{$exam->id}} pull-right">
    @if($exam->geotaggedphotos->where('exam_date',$date)->count() > 0 )  Upload more photos @else    Upload Geotagged Group Photo @endif
</a>
{{--  @endif --}}

<div class=" alert alert-warning pull-right hidden gt_{{$exam->id}}" style="margin-bottom:0px;">
    <h5>Upload Geotagged photo for <b> {{$date}}</b></h5>
    <form id="form_{{$exam->id}}" action="{{url('practicalexaminer/geotaggedphotos')}}" method="POST" enctype="multipart/form-data" >
        {{ csrf_field() }}
        <input type="hidden" name="practicalexam_id" value="{{$exam->id}}">
        <input type="file" id="file_{{$exam->id}}" name="photo" >
        <input type="text" name="comment" style="border:1px solid #ccc;margin-top:2px;" placeholder="Description">
        <button
            type="submit"
            class="btn btn-xs btn-primary pull-right"
            id="btnup_{{$exam->id}}"
        >
            <img src="{{url('images/loading1.gif')}}" class="hidden uploading" style="width: 18px;margin-right: 10px;">                
            <span class="uploadfile">Upload</span>
        </button>
    </form>
</div>
<script>
    $('#file_{{$exam->id}}').on('change', function() { 
        if (this.files[0].size > 1000000) { 
            alert("Try to upload file less than 1MB!"); 
        } else { 
            
        } 
    });
    $('#form_{{$exam->id}}').submit(function(e){
        e.preventDefault();
        $('.uploadfile').text('Please wait...');
        $('#btnup_{{$exam->id}}').prop('disabled', true);
        $('.uploading').removeClass('hidden');
        if($("#file_{{$exam->id}}").get(0).files[0].size > 1000000){
            swal({
                type: 'warning',
                title: 'Please choose file size less than 1MB',
                showConfirmButton: false,
                timer: 4500
                });
                $('.uploadfile').text('Upload');
        $('#btnup_{{$exam->id}}').prop('disabled', false);
        $('.uploading').addClass('hidden');
            return false;
        }
        
        
        e.currentTarget.submit();
    });
</script>