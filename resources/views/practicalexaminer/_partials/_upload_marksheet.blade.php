
<a 
    href="javascript:uploadms({{$template->id}})" 
    class="btn btn-xs @if($ap->academicyear_id == (13-$term)) btn-primary @else btn-info @endif upload_link_{{$template->id}}"
    style="margin-bottom:5px;"
>
    @if($ap->academicyear_id == (13-$term)) Regular @else Backlog  @endif 
    ( Term {{$term}})   - Upload Singed Scan copy of the marksheet
    
</a>

    
<div class=" alert alert-danger pull-right hidden upload_{{$template->id}}" style="margin-bottom:0px;">
    <h5>Upload Marksheet -  @if($ap->academicyear_id == (13-$term)) Regular @else Backlog  @endif 
        ( Term {{$term}})  </b></h5>
    
    <form id="msupload_form_{{$template->id}}" action="{{url('practicalexam/awardlisttemplate')}}/{{$template->id}}" method="POST" enctype="multipart/form-data" >
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT"> 
        <input type="hidden" name="awardlisttemplate_id" value="{{$template->id}}">
        <input type="file" name="marksheet" id="fileupms_{{$template->id}}">
        <button
            type="submit"
            class="btn btn-xs btn-primary pull-right"
            id="btnmsu_{{$template->id}}"
        >
            

            <img src="{{url('images/loading1.gif')}}" class="hidden msupload" style="width: 18px;margin-right: 10px;">                
            <span class="uploadmarksheet">@if(!is_null($template->marksheet))  Re - @endif Upload </span>

        </button>
    </form>
</div>

@if(!is_null($template->marksheet))
        <a target="_blank" href="{{url('files/externalpractical')}}/{{$template->marksheet}}"> Download (Term {{$term}}) </a>

<div class="alert alert-warning">
@if($template->subjects->count()>0)
    <table class="table table-bordered">
        <tr>
            <th>Subject Code</th>
            <th>Marks</th>
        </tr>
    @foreach($template->subjects as $subject)
        <tr><td>
        {{$subject->scode}}  
    </td>
    <td>
        <a href="{{url('practicalexam/awardlisttemplate')}}/{{$template->id}}?subject_id={{$subject->id}}" 
            class="btn btn-xs btn-primary"   
        >
                Enter Marks
        </a>
    </td>
</tr>
    @endforeach
    </table>
@endif
</div>
@endif

<script>
    $('#fileupms_{{$template->id}}').on('change', function() { 
        if (this.files[0].size > 1000000) { 
            alert("Try to upload file less than 1MB!"); 
        } else { 
            
        } 
    });
    $('#msupload_form_{{$template->id}}').submit(function(e){
        e.preventDefault();
        $('.uploadmarksheet').text('Please wait...');
        $('#btnmsu_{{$template->id}}').prop('disabled', true);
        $('.msupload').removeClass('hidden');
        if($("#fileupms_{{$template->id}}").get(0).files[0].size > 1000000){
            swal({
                type: 'warning',
                title: 'Please choose file size less than 1MB',
                showConfirmButton: false,
                timer: 4500
                });
                $('.uploadfile').text('@if(!is_null($template->marksheet))  Re - @endif Upload');
                $('#btnmsu_{{$template->id}}').prop('disabled', false);
        $('.msupload').addClass('hidden');
            return false;
        }
        
        
        e.currentTarget.submit();
    });
</script>
